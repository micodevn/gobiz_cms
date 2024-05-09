<?php

namespace App\Http\Services;

use App\Exceptions\FileServiceException;
use App\Helpers\Helper;
use App\Http\Services\Service as BaseService;
use App\Models\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\File\File as LocalFile;

class FileService extends BaseService
{
    protected $server;
    protected $authUsername;
    protected $authPassword;
    protected $connection;

    const UPLOAD_ROOT = '/k12/product-cms/resources/uploads/';

    public function __construct()
    {
        $this->server = config('cdn.server');
        $this->authUsername = config('cdn.auth.username');
        $this->authPassword = config('cdn.auth.password');

//        $this->connect();
    }

    public function connect(): bool
    {
        try {
            if (!$this->server || !$this->authUsername || !$this->authPassword) {
                throw new FileServiceException('server, authUsername, authPassword must be set.');
            }
            $this->connection = ftp_connect($this->server);
            if(!$this->connection) {
                throw new FileServiceException("Couldn't connect to FTP Server " . $this->server);
            }
            $loginResult = ftp_login($this->connection, $this->authUsername, $this->authPassword);

            if (!$loginResult) {
                throw new FileServiceException('Unable to connect to FTP Server ' . $this->server);
            }

            if (!ftp_pasv($this->connection, true)) {
                throw new FileServiceException("Cannot switch to passive mode");
            }

            return true;
        } catch (\Exception $exception) {
            Log::channel('ftp-service')->error($exception->getMessage());
            return false;
        }
    }

    public function getConnection()
    {
        if (!$this->connection) {
            $this->connect();
        }
        return $this->connection;
    }

    private function closeConnection()
    {
        ftp_close($this->connection);
        $this->connection = null;
    }


    /**
     * @param $path
     * @return bool
     * @throws FileServiceException
     */
    public function mkdirRecursive($path)
    {
        $conn = $this->getConnection();

        $parts = explode("/", $path);
        $fullPath = "";
        foreach ($parts as $part) {
            if (empty($part)) {
                $fullPath .= "/";
                continue;
            }
            $fullPath .= $part . "/";
            if (@ftp_chdir($conn, $fullPath)) {
                ftp_chdir($conn, $fullPath);
            } else {
                if (@ftp_mkdir($conn, $part)) {
                    ftp_chdir($conn, $part);
                } else {
                    $this->closeConnection();
                    throw new FileServiceException('Unable to create directory');
                }
            }
        }

        $this->closeConnection();
        return true;
    }

    public function fileIsExist($path)
    {
        $conn = $this->getConnection();
        $size = ftp_size($conn, $path);
        $this->closeConnection();

        return $size > 0;
    }

    public function folderIsExist($path)
    {
        try {
            $conn = $this->getConnection();
            $list = ftp_nlist($conn, $path);
            $this->closeConnection();

            return $list;
        } catch (\Exception $exception) {
            return false;
        }
    }

    private function getFolderByType($type)
    {
        $type = strtolower($type);
        if (in_array(strtoupper($type), File::TYPE_LIST)) {
            return "${type}s/";
        }

        return 'others/';
    }

    private function generatePath($fileName, $type, $detail = false , $subFolder = "")
    {
        $pathByTime = date('Y') . '/' . date('m') . '/' . date('d') . "/";
        $relativePath = Helper::makePath(
            $subFolder,
            $this->getFolderByType($type),
            $pathByTime
        );
        $uploadPath = Helper::makePath(
            self::UPLOAD_ROOT,
            $relativePath
        );

        $fileNameSlug = Helper::changeToSlug($fileName, true);
        $fullPath = Helper::makePath($uploadPath, $fileNameSlug);

        if ($detail) {
            return compact('uploadPath', 'relativePath', 'fileNameSlug', 'fullPath');
        }

        return $fullPath;
    }

    private function addUniqueToFileName($fileName, $type = null): string
    {
        $exploded = explode('.', $fileName);
        if (count($exploded) >= 2) {
            $exploded[count($exploded) - 2] .= '_' . bin2hex(random_bytes(4));
            $fileName = implode('.', $exploded);
        } else {
            $fileName .= '_' . bin2hex(random_bytes(4));
        }
        return $fileName;
    }

    public function storeResourceFile(LocalFile|string $localFile, $type): array|string|null
    {
        if (is_string($localFile)) {
            $localFile = new LocalFile($localFile);
        }

        $pathDetail = $this->generatePath($localFile->getClientOriginalName(), $type, detail: true);
        /**
         * @var $uploadPath
         * @var $relativePath
         * @var $fileNameSlug
         * @var $fullPath
         */
        extract($pathDetail);

        $uploadedFileName = $this->storeFile($localFile, $uploadPath, $fileNameSlug, $type);
        return Helper::makePath($relativePath, $uploadedFileName);
    }

    private function removeSpecialCharacters($string)
    {

    }

    public function storeFile(LocalFile|string $localFile, $path, $fileName, $type = null)
    {
        try {
            set_time_limit(0); // safe_mode is off

            ini_set('max_execution_time', 0); //500 seconds
            if (!$this->folderIsExist($path)) {
                $this->mkdirRecursive($path);
            }

            $fullPath = Helper::makePath($path, $fileName);
            if ($this->fileIsExist($fullPath)) {
                $fileName = $this->addUniqueToFileName($fileName, $type);
                $fullPath = Helper::makePath($path, $fileName);
            }

            $conn = $this->getConnection();
            $uploadProgress = ftp_nb_put($conn, $fullPath, $localFile, FTP_BINARY);

            while ($uploadProgress === FTP_MOREDATA) {
                $uploadProgress = ftp_nb_continue($conn);
            }

            if ($uploadProgress !== FTP_FINISHED) {
                $this->closeConnection();
                throw new FileServiceException('There was an error while uploading file');
            }

            $this->closeConnection();

            return $fileName;
        } catch (\Exception $exception) {
            Log::channel('ftp-service')->error($exception->getMessage());
            return false;
        }
    }
}

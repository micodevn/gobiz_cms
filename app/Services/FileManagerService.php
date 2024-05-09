<?php
namespace App\Services;

use App\Helpers\VtHelper;
use App\Helpers\UpFileHelper;

class FileManagerService {

    public function doUploadFile($file, $path)
    {
        $timestamp = date('Y') . '/' . date('m') . '/' . date('d') . "/";
        $fileName = $path . $timestamp. VtHelper::changeToSlug($file->getClientOriginalName());
        $local_file = $file->getPathname();
        $destination_file = $fileName;
        $check_has_file = UpFileHelper::checkPathFile($local_file, $destination_file);
        if ($check_has_file == false) {
            return false;
        }

        return $fileName;
    }

    public static function getFileSize($remoteFile){
        $curl = curl_init($remoteFile);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_exec($curl);
        $fileSize = curl_getinfo($curl, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
        $fileSizeKB = round($fileSize / 1024);
        return (int)$fileSizeKB;
    }
}

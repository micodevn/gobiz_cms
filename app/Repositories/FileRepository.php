<?php

namespace App\Repositories;

use App\Helpers\Helper;
use App\Helpers\UpFileHelper;
use App\Http\Services\FileService;
use App\Models\File;
use App\Models\ModelLabels;
use Illuminate\Container\Container as Application;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class FileRepository
 * @package App\Repositories
 * @version March 22, 2022, 1:32 pm +07
 */
class FileRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
        'type',
        'file_path',
        'is_active',
    ];

    protected FileService $fileService;

    public function __construct(Application $app, FileService $fileService)
    {
        parent::__construct($app);
        $this->fileService = $fileService;
    }

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return File::class;
    }

    private function uploadFileAndIcon(&$attributes)
    {
        /** @var UploadedFile $fileUpload */
        $fileUpload = Arr::get($attributes, 'file_path');
        $iconUpload = Arr::get($attributes, 'icon_file_path');
        $type = Arr::get($attributes, 'type');
        $filePath = $this->fileService->storeResourceFile($fileUpload, $type);
        $attributes['file_path'] = $filePath;

        // Check if resource file and icon file are the same
        $isSameFile = filesize($fileUpload) == filesize($iconUpload) && md5_file($fileUpload) == md5_file($iconUpload);

        if ($iconUpload && !$isSameFile) {
            $iconFile = $this->fileService->storeResourceFile($iconUpload, File::TYPE_IMAGE);
            $attributes['icon_file_path'] = $iconFile;
        }

        if ($iconUpload && $isSameFile) {
            $attributes['icon_file_path'] = $filePath;
        }
    }

    public function create(array $attributes, $create_physical_files = true)
    {
        Helper::setUploadSize('120M');

        $file = $attributes['file_path'];

        $directory = public_path('uploads/' . date('Y/m/d'));
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move($directory, $filename);
        $filePath = '/uploads/' . date('Y/m/d') . '/' . $filename;


        $attributes['file_path'] = $filePath;
        $created = parent::create($attributes); // TODO: Change the autogenerated stub
        return $created;
    }

    public function update(array $attributes, $id, $create_physical_files = true): bool|File
    {
        try {
            Helper::setUploadSize('120M');

            if (!empty($attributes['url_static_options'])) {
                $attributes['file_path'] = $attributes['url_static_options'];
                $create_physical_files = false;
            }

            if (Arr::has($attributes, 'file_path') && $create_physical_files) {
                $this->uploadFileAndIcon($attributes);
            }
            if ($create_physical_files) {
                !empty($attributes['file_path']) && $size = request()->file('file_path', null)->getSize();
                !empty($size) && $attributes['size'] = UpFileHelper::FileSizeConvert($size);
            }

            /** @var File $updated */
            $updated = parent::update($attributes, $id); // TODO: Change the autogenerated stub
//        $this->syncWithLabel($updated,$attributes);

//        $timestamps = \Arr::get($attributes, 'video_timestamps', []);
//        $subtitles = \Arr::get($attributes, 'subtitles', []);
//        $timestamps = json_decode($timestamps, true);
//        $subtitles = json_decode($subtitles, true);
//        $updated->saveTimestamps($timestamps);
//        $updated->saveSubtitles($subtitles);
//
//        foreach ($updated->exercises as $exercise) {
//            $exercise->cache();
//        }

            return $updated;
        } catch (\Exception $exception) {
            return false;
        }
    }


    public function syncWithLabel($model, $attributes)
    {
        $labelIds = \Arr::get($attributes, 'label_ids');
        if (!$labelIds) return true;
        $labelIds = is_array($labelIds) ? $labelIds : explode(',', $labelIds);
        $labelIds = array_filter($labelIds);
        $fileLabels = [];
        ModelLabels::query()->where('model_type', File::MODEL_TYPE)->where('model_id', $model->id)->forceDelete();
        foreach ($labelIds as $labelId) {
            $fileLabels[] = [
                'model_id' => $model->id,
                'label_id' => $labelId,
                'model_type' => File::MODEL_TYPE,
                'created_by' => \Auth::id()
            ];
        }
        ModelLabels::insert($fileLabels);
    }
}

<?php

namespace App\Models;

use App\Helpers\Helper;
use App\Http\Resources\API\FileResource;
use App\Traits\Cacheable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Http\Resources\Json\JsonResource;

class File extends BaseModel
{
    use SoftDeletes, Cacheable;

    use HasFactory;

    /**
     * Cache collection for model
     * @var
     */
    public $cacheCollection = 'k12.files';
    public $isFilterProduct = true;
    /**
     * Resource for model
     * @var JsonResource
     */
    protected $cacheResource = FileResource::class;

    const MODEL_TYPE = 'App\Models\File';
    const TYPE_VIDEO = 'VIDEO';
    const TYPE_IMAGE = 'IMAGE';
    const TYPE_AUDIO = 'AUDIO';
    const TYPE_VIDEO_TIMESTAMP = 'VIDEO_TIMESTAMP';
    const TYPE_PDF = 'PDF';
    const TYPE_ASSET_BUNDLE = 'ASSET_BUNDLE';
    const TYPE_DOCUMENT = 'DOCUMENT';
    const TYPE_CLASSIN = 'CLASSIN';

    const TYPE_LIST = [
        'VIDEO',
        'IMAGE',
        'AUDIO',
//        'VIDEO_TIMESTAMP',
//        'PDF',
//        'ASSET_BUNDLE',
//        'DOCUMENT',
//        'CLASSIN'
    ];


    const TYPE_LIST_HAVE_RESOURCE = [
        'VIDEO',
        'IMAGE',
        'AUDIO'
    ];

    public $table = 'files';
    protected $appends = [
        'file_path_url',
        'url'
    ];

    protected $dates = ['deleted_at'];

    protected $attributes = [
        'is_active' => true
    ];

    public $fillable = [
        'name',
        'type',
        'file_path',
        'is_active',
        'size',
        'created_by',
        'updated_by'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'type' => 'string',
        'file_path' => 'string',
        'is_active' => 'integer',
//        'size' => 'string',
        'created_by' => 'integer',
        'updated_by' => 'integer'
    ];


    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'name',
        'is_active',
        'type'
    ];

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
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'type' => 'required',
        'file_path' => 'required_if:url_static_options,==,null',
        'url_static_options' => 'nullable',
        'label_ids' => 'nullable',
        'is_active' => 'required'
    ];

    protected function isActive(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value,
            set: function ($value) {
                return intval($value);
            }
        );
    }

    protected function type(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value,
            set: function ($value) {
                return strtoupper($value);
            }
        );
    }

    public function getUrlAttribute()
    {
        return $this->file_path_url;
    }

    public function getFilePathUrlAttribute()
    {
        if (!$this->file_path) {
            return null;
        }

        return Helper::makeResourceUrl($this->file_path);
    }

    public function getTimestampsParsedAttribute()
    {
        $timestamps = json_decode($this->video_timestamps, true) ?? [];
        $fileIds = array_column($timestamps, 'icon');
        $files = self::getUrlByIds($fileIds);

        foreach ($timestamps as $key => $timestamp) {
            $timestamps[$key]['icon'] = $timestamp['icon'] ? $files[$timestamp['icon']] : [];
        }

        return $timestamps;
    }

    public function labels()
    {
        $table = (new ModelLabels())->getTable();

        return $this->belongsToMany(Label::class,$table,'model_id')->select(['id','name', 'slug'])->where('model_type',self::MODEL_TYPE);
    }

    public function getSubtitlesParsedAttribute()
    {
        return json_decode($this->subtitles, true) ?? [];
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function videoTimestamps()
    {
        return $this->hasMany(VideoTimeProperty::class, 'file_id')
            ->select([
                'id', 'title', 'start', 'end', 'fulltext', 'file_id'
            ])
            ->with('timestampQuestionsFull')
            ->where('type', VideoTimeProperty::TYPE_TIMESTAMP)
            ->orderBy('position');
    }

    public function videoTimestampsNoQuestion()
    {
        return $this->hasMany(VideoTimeProperty::class, 'file_id')
            ->select([
                'id', 'title', 'start', 'end', 'fulltext', 'file_id'
            ])
            ->with('timestampQuestionsFull')
            ->where('type', VideoTimeProperty::TYPE_TIMESTAMP)
            ->orderBy('position');
    }

    public function videoTimestampsFileList()
    {
        return $this->hasMany(VideoTimeProperty::class, 'file_id')
            ->select([
                'id', 'title', 'start', 'end', 'fulltext', 'file_id'
            ])
            ->with('timestampQuestionsFileList')
            ->where('type', VideoTimeProperty::TYPE_TIMESTAMP);
    }

    public function videoSubtitles()
    {
        return $this->hasMany(VideoTimeProperty::class, 'file_id')
            ->select([
                'id', 'title', 'start', 'end', 'file_id'
            ])
            ->where('type', VideoTimeProperty::TYPE_SUBTITLE);
    }

    public function questions()
    {
        $relateTable = (new VideoTimeProperty())->getTable();

        return $this
            ->belongsToMany(VideoTimeProperty::class, 'question_video_times', 'question_id', 'vid_time_property_id')
            ->where('question_video_times.type', VideoTimeProperty::TYPE_TIMESTAMP)
            ->select('title', "${relateTable}.id");
    }

    public static function getTypeListOptions()
    {
        $data = [];

        foreach (self::TYPE_LIST as $type) {
            $data[$type] = __($type);
        }

        return $data;
    }

    public static function getPathById($id)
    {
        $file = self::query()->select(['id', 'file_path'])->find($id);
        if ($file) {
            return $file->file_path;
        }

        return null;
    }

    public static function getUrlById($id)
    {
        $path = self::getPathById($id);

        if (!$path) {
            return null;
        }

        return Helper::makeResourceUrl($path);
    }

    public static function getUrlByIds($ids)
    {
        $files = self::query()->select(['id', 'file_path'])->whereIn('id', $ids)->get();
        $result = [];

        foreach ($files as $file) {
            $result[$file->id] = $file->toArray();
            $result[$file->id]['url'] = Helper::makeResourceUrl($file->file_path);
        }

        return $result;
    }

    public function saveTimestamps($timestamps)
    {
        $timestamps = collect($timestamps)->map(function ($item) {
            $item['type'] = VideoTimeProperty::TYPE_TIMESTAMP;
            $item['file_id'] = $this->id;

            return $item;
        })->toArray();

        foreach ($timestamps as $key => $timestamp) {
            if (!\Arr::get($timestamp, 'id')) {
                $timestamps[$key]['id'] = null;
            }
        }

        $existIds = array_map('intval', array_column($timestamps, 'id'));

        $timestampToDelete = $this->videoTimestampsNoQuestion()->whereNotIn('id', $existIds);
        $timestampToDelete->get()->each(function ($ts) {
            /** @var VideoTimeProperty $ts */
            $ts->questionVideoTimestamps()->delete();
        });
        $timestampToDelete->delete();

        $fillable = (new VideoTimeProperty())->fillable;

        foreach ($timestamps as $key => $timestamp) {
            $values = array_reduce($fillable, function ($val, $field) use ($timestamp) {
                $val[$field] = \Arr::get($timestamp, $field);
                return $val;
            }, []);

            /** @var VideoTimeProperty $videoTimestamp */
            $videoTimestamp = $this->videoTimestamps()->updateOrCreate([
                'id' => $timestamp['id'] ?? null
            ], $values);

            $questionIds = \Arr::get($timestamp, 'question_ids', []);
            $questionsSync = [];

            foreach ($questionIds as $id) {
                $questionsSync[$id] = [
                    'from' => VideoTimeProperty::FROM_VIDEO,
                    'type' => VideoTimeProperty::TYPE_TIMESTAMP
                ];
            }

            $videoTimestamp->timestampQuestions()
                ->wherePivot('type', VideoTimeProperty::TYPE_TIMESTAMP)
                ->wherePivot('from', VideoTimeProperty::FROM_VIDEO)->detach(null,false);

            $videoTimestamp->timestampQuestions()->attach($questionsSync);
        }

        return $this;
    }

    public function saveSubtitles($subtitles)
    {
        $subtitles = collect($subtitles)->map(function ($item) {
            $item['type'] = VideoTimeProperty::TYPE_SUBTITLE;
            $item['file_id'] = $this->id;

            return $item;
        })->toArray();

        foreach ($subtitles as $key => $subtitle) {
            if (!\Arr::get($subtitle, 'id')) {
                $subtitles[$key]['id'] = null;
            }
        }

        $existIds = array_map('intval', array_column($subtitles, 'id'));
        $this->videoSubtitles()->whereNotIn('id', $existIds)->delete();

        $this->videoSubtitles()->upsert(
            $subtitles,
            ['id'],
            (new VideoTimeProperty())->fillable
        );

        return $this;
    }

    public function exercises()
    {
        return $this->hasMany(Exercise::class, 'video');
    }

    public function isImage() {
        return $this->type === self::TYPE_IMAGE;
    }
}

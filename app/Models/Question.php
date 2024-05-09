<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redis;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\AdaptiveLearning\Entities\LearningObjective;
use Modules\AdaptiveLearning\Entities\SkillVerb;
use Modules\AdaptiveLearning\Entities\TargetLanguage;

class Question extends BaseModel
{
    use SoftDeletes;

    public $table = 'questions';

    protected $dates = ['deleted_at'];

    protected $cacheQuestionLevel = 'k12.questions.topic.level';


    const CLASS_INFO = [
      1 => 'Lớp một',
      2 => 'Lớp hai',
      3 => 'Lớp ba',
      4 => 'Lớp bốn',
      5 => 'Lớp năm'
    ];

    protected $attributes = [
        'metadata_version' => '1.0.0.0',
        'response_interaction_type' => self::ITR_TYPE_NONE,
        'is_active' => true
    ];

    protected bool $isFilterProduct = true;

    const ITR_TYPE_NONE = 'NONE';
    const ITR_TYPE_SELECTION = 'SELECTION';
    const ITR_TYPE_ARRANGE = 'ARRANGE';
    const ITR_TYPE_FREE_TEXT = 'FREE_TEXT';
    const ITR_TYPE_MATCHING = 'MATCHING';

    const ITR_LIST = [
        self::ITR_TYPE_NONE,
        self::ITR_TYPE_SELECTION,
        self::ITR_TYPE_ARRANGE,
        self::ITR_TYPE_FREE_TEXT,
        self::ITR_TYPE_MATCHING
    ];

    const ITR_LIST_INTEGER = [
        self::ITR_TYPE_NONE => 1,
        self::ITR_TYPE_SELECTION => 2,
        self::ITR_TYPE_ARRANGE => 3,
        self::ITR_TYPE_FREE_TEXT => 4,
        self::ITR_TYPE_MATCHING => 5
    ];

    const LEVEL_QUESTIONS = [
        1 => 'Ghi nhớ kiến thức',
        2 => 'Hiểu được kiến thức',
        3 => 'Vận dụng kiến thức vào các tính huống quen thuộc',
        4 => 'Vận dụng kiến thức mức độ khá',
        5 => 'Vận dụng kiến thức mức độ nâng cao',
    ];

    public $fillable = [
        'name',
        'description',
        'duration',
        'thumbnail',
        'response_interaction_type',
        'question_content',
        'answers',
        'platform_id',
        'topic_id',
        'skill_verb_id',
        'level',
        'is_active',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'response_interaction_type' => 'string',
        'question_content' => 'string',
        'answers' => 'string',
        'platform_id' => 'integer',
        'skill_verb_id' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'description' => 'nullable',
        'duration' => 'nullable',
        'thumbnail' => 'nullable',
        'metadata_version' => 'nullable',
        'response_interaction_type' => 'required',
        'question_content' => 'nullable',
        'answers' => 'nullable',
        'platform_id' => 'required',
        'is_active' => 'nullable',
    ];

    protected $cacheQuestionContent;
    protected $cacheQuestionAnswers;


    public static function filters() {
        return [
            'name' => [
                'type' => 'text',
                'placeholder' => 'Nhập tên ...',
                'filter_type' => self::RELATIVE

            ],
            'description' => [
                'type' => 'text',
                'placeholder' => 'Nhập description ...',
                'filter_type' => self::RELATIVE
            ],
            'code' => [
                'type' => 'text',
                'placeholder' => 'Nhập code ...',
                'filter_type' => self::ABSOLUTE
            ],
            'platform' => [
                'type' => 'component',
                'componentName' => 'api-select',
                'options' => [
                    'url' => route('question-platform.group-options'),
                    'selected' => null,
                    'class' => 'api-select',
                    'labelField' => 'name',
                    'valueField' => 'id'
                ]
            ],
            'is_active' => [
                'type' => 'component',
                'componentName' => 'select-normal',
                'options' => [
                    'options' => [
                        0 => 'Active',
                        1 => 'DeActive'
                    ],
                    'class' => 'form-control'
                ]
            ]
        ];
    }

    public function getPlatformNameAttribute()
    {
        if (!$this->platform) {
            return "";
        }

        return $this->platform->name;
    }

    public static function interactionTypeOptions()
    {
        $results = [];

        foreach (self::ITR_LIST as $type) {
            $results[$type] = __($type);
        }

        return $results;
    }

    private function loadAssetBundle($asset)
    {
        $iosId = \Arr::get($asset, 'ios_id');
        $androidId = \Arr::get($asset, 'android_id');
        $webglId = \Arr::get($asset, 'webgl_id');
        $iconId = \Arr::get($asset, 'icon_id');
        $backgroundId = \Arr::get($asset, 'background_id');
        $anims = \Arr::get($asset, 'animations', []);

        $fileIds = array_filter([
            $iosId,
            $androidId,
            $webglId,
            $iconId,
            $backgroundId,
            ...array_column($anims, 'file_id')
        ]);

        $files = count($fileIds) > 0 ? File::query()->select([
            'id', 'file_path', 'name', 'type'
        ])->whereIn('id', $fileIds)->get()->keyBy('id') : collect();

        if ($iosId) {
            $ios = $files->get($iosId) ?? new File();
            $asset['ios'] = $ios;
        }

        if ($androidId) {
            $android = $files->get($androidId) ?? new File();
            $asset['android'] = $android;
        }

        if ($webglId) {
            $webgl = $files->get($webglId) ?? new File();
            $asset['webgl'] = $webgl;
        }

        if ($iconId) {
            $icon = $files->get($iconId) ?? new File();
            $asset['icon'] = $icon;
        }

        if ($backgroundId) {
            $background = $files->get($backgroundId) ?? new File();
            $asset['background'] = $background;
        }

        foreach ($anims as $animI => $anim) {
            if (\Arr::has($anim, 'file_id')) {
                $animFile = $files->get(\Arr::get($anim, 'file_id')) ?? new File();
                $anims[$animI]['url'] = $animFile->file_path_url;
                $anims[$animI]['file_data'] = $animFile->toArray();
            }
        }
        $asset['animations'] = $anims;

        return $asset;
    }

    public function getQuestionContentParsedAttribute()
    {
        if (!empty($this->cacheQuestionContent)) {
            return $this->cacheQuestionContent;
        }

        $content = json_decode($this->question_content, true);
        $resourceKeys = [
            'image', 'audio', 'video', 'document' , 'explanation_audio', 'explanation_video'
        ];

        if (!$content) {
            return [];
        }

        $resourceIds = [];
        foreach ($resourceKeys as $key) {
            $resource = \Arr::get($content, $key, null);
            if (!$resource) {
                $content[$key] = [];
                continue;
            }
            $id = \Arr::get($content[$key], 'id');
            $resourceIds[] = $id;
        }

        $resourceIds = array_filter($resourceIds);

        $files = count($resourceIds) > 0 ? File::query()->select([
            'id', 'file_path', 'name', 'type'
        ])->whereIn('id', $resourceIds)->get()->keyBy('id') : collect();

        foreach ($resourceKeys as $key) {
            $resource = \Arr::get($content, $key, null);
            if (!$resource) {
                $content[$key] = [];
                continue;
            }
            $id = \Arr::get($content[$key], 'id');
            $file = $files->get($id);

            $file = $file ? $file->toArray() : [];

            $content[$key] = [
                ...$content[$key],
                ...$file
            ];
        }

        // get id video timestamp
//        $getAllTypeTimestamp = \Arr::get($content, 'all_type_timestamp', false);
//        if ($getAllTypeTimestamp && !empty($content['video'])) {
//            foreach ($content['video']['video_timestamps'] as $val) {
//                $content['video_timestamps'][] = \Arr::get($val, 'id');
//            }
//        }

        //Get Asset Bundle Block
//        $assetField = 'asset_bundle_block';
//        $asset = Arr::get($content, $assetField, []);
//        $asset = $this->loadAssetBundle($asset);
//        $content[$assetField] = $asset;
        $this->cacheQuestionContent = $content;
        return $this->cacheQuestionContent;
    }

    public function getQuestionAnswersParsedAttribute()
    {
        if ($this->cacheQuestionAnswers) {
            return $this->cacheQuestionAnswers;
        }

        $answers = json_decode($this->answers, true);

        if (!$answers) {
            return [];
        }

//        dd($answers);
        $fileIds = [];
        foreach ($answers as $idx => &$answer) {
            $resourceKeys = [
                'image', 'audio', 'animation'
            ];

            foreach ($answer as $key => $value) {
                if (!in_array($key, $resourceKeys)) {
                    continue;
                }

                $resource = \Arr::get($answer, $key, null);
                if (!$resource) {
                    $answer[$key] = [];
                    continue;
                }
                $id = \Arr::get($value, 'id');
                $fileIds[] = $id;
            }
        }

        $fileIds = array_filter($fileIds);

        $files = count($fileIds) > 0 ? File::query()->select([
            'id', 'file_path', 'name', 'type'
        ])->whereIn('id', $fileIds)->get()->keyBy('id') : collect();

        foreach ($answers as $idx => &$answer) {
            $resourceKeys = [
                'image', 'audio', 'animation'
            ];

            foreach ($answer as $key => $value) {
                if (!in_array($key, $resourceKeys)) {
                    continue;
                }

                $resource = \Arr::get($answer, $key, null);
                if (!$resource) {
                    $answer[$key] = [];
                    continue;
                }
                $id = \Arr::get($value, 'id');
                $file = $files->get($id);
                $file = $file ? $file->toArray() : [];

                $answer[$key] = [
                    ...$value,
                    ...$file
                ];
            }
        }

        $this->cacheQuestionAnswers = $answers;

        return $this->cacheQuestionAnswers;
    }

    public function getThumbnailUrlAttribute($getName = false)
    {
        if (!$this->thumbnail || !$this->thumbnailPath) {
            return config('cdn.default_image');
        }

        return Helper::makeResourceUrl($this->thumbnailPath->file_path);
    }


    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function sync()
    {
        return $this->belongsTo(Question::class, 'sync_id');
    }

    public function platform()
    {
        return $this->belongsTo(QuestionPlatform::class, 'platform_id');
    }

    public function thumbnailPath()
    {
        return $this->belongsTo(File::class, 'thumbnail')->select([
            'id', 'file_path', 'name', 'type'
        ]);
    }

    public function exercises()
    {
        $table = (new ExerciseQuestions())->getTable();

        return $this->belongsToMany(Exercise::class, $table);
    }

    public function videoTimestamps()
    {
        $relateTable = (new VideoTimeProperty())->getTable();

        return $this
            ->belongsToMany(VideoTimeProperty::class, 'question_video_times', 'question_id', 'vid_time_property_id')
            ->where('question_video_times.type', VideoTimeProperty::TYPE_TIMESTAMP)
            ->where('question_video_times.from', VideoTimeProperty::FROM_QUESTION)
            ->select('title', "${relateTable}.id");
    }

    public function videoTimestampsFromVideo()
    {
        $relateTable = (new VideoTimeProperty())->getTable();

        return $this
            ->belongsToMany(VideoTimeProperty::class, 'question_video_times', 'question_id', 'vid_time_property_id')
            ->where('question_video_times.type', VideoTimeProperty::TYPE_TIMESTAMP)
            ->where('question_video_times.from', VideoTimeProperty::FROM_VIDEO)
            ->select('title', "${relateTable}.id", 'file_id');
    }

    protected function saveTimestamps($timestamps)
    {
        $this->videoTimestamps()->sync($timestamps);

        return $this;
    }

    public function targetLanguages()
    {
//        $table = (new QuestionTargetLanguage())->getTable();
//
//        return $this->belongsToMany(TargetLanguage::class, $table)->select(['id', 'target_language as name', 'part','explain'])->withTimestamps();
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class, 'topic_id');
    }

    public function skillVerb(): BelongsTo
    {
//        return $this->belongsTo(SkillVerb::class)->select(['id', 'name']);
    }

    public function attributes()
    {
        return $this->hasMany(QuestionAttributes::class, 'question_id');
    }

    public function getClassName()
    {
        if (!empty($this->class_id)) {
            return self::CLASS_INFO[$this->class_id];
        }
        return '';
    }


    public function syntheticIdQuestionWithLevel($destroy = false)
    {
        if (!empty($this->topic_id) && !empty($this->level) && !empty($this->product_id)) {
            $questions = Redis::get($this->solveKey());
            if ($questions) {
                $questions = json_decode($questions, true);
                $questions = Helper::reAssignKey($questions, 'id');
                $questionsIds = Helper::arrayColumn($questions, 'id');

                if ($destroy) {
                    foreach ($questions as $key => $val) {
                        if ($val['id'] == $this->id) {
                            unset($questions[$key]);
                        }
                    }
//                    Redis::set($this->solveKey(), json_encode($questions));
                    return true;
                }


                if (!in_array($this->id, $questionsIds)) {
                    $questions[$this->id] = [
                        'id' => $this->id,
                        'platform_id' => $this->platform_id
                    ];
//                    Redis::set($this->solveKey(), json_encode($questions));
                    return $questions;
                }
            }
            $questions[$this->id] = [
                'id' => $this->id,
                'platform_id' => $this->platform_id
            ];
//            Redis::set($this->solveKey(), json_encode($questions));

            return $this->id;
        }
        return false;
    }

    public function uniqueQuestionInCacheKey($attributes = null)
    {
        if ($attributes) {
            $topic = Arr::get($attributes, 'topic_id', null);
            $level = Arr::get($attributes, 'level', null);
            $product_id = Arr::get($attributes, 'product_id', null);

            if ((!empty($this->topic_id) && !empty($this->level)) && !empty($this->product_id) && $this->topic_id != $topic || $this->level != $level || $this->product_id != $product_id) {
                $questions = Redis::get($this->solveKey($this->topic_id, $this->level, $this->product_id));
                if ($questions) {
                    $questions = json_decode($questions, true);
                    $questions = Helper::reAssignKey($questions, 'id');

                    $questionsIds = Helper::arrayColumn($questions, 'id');

                    foreach ($questions as $key => $val) {
                        if ($val['id'] == $this->id) {
                            unset($questions[$key]);
                        }
                    }
                    Redis::set($this->solveKey(), json_encode($questions));
                }
            }
        }
    }

    public function solveKey($topic = null, $level = null, $product = null): string
    {
        $topic = $topic ?? $this->topic_id;
        $level = $level ?? $this->level;
        $product = $product ?? $this->product_id;
        return $this->cacheQuestionLevel . ':' . $topic . '_' . $level . '_' . $product;
    }

    public function detachDataAttribute($attrWithParent, $resourcePare = false, $data_apiName = [])
    {
        $dataFill = [];
        foreach ($attrWithParent as $key => &$value) {
            if (count($value) > 1) {
                $this->detachChild($value, $dataFill, $key, $resourcePare, $data_apiName);
            } else {
                if (!empty($value[0]['group_parent'])) {

                    // replace with api_name
                    if (!empty($data_apiName[$value[0]['attribute']])) {
                        $dataFill[$data_apiName[$value[0]['attribute']]] = $value[0]['value'];
                    } else {
                        $dataFill[$value[0]['attribute']] = $value[0]['value'];
                    }

                    if ($resourcePare && !empty($value[0]['type']) && $value[0]['type'] == QuestionAttributes::TYPE_RELATION) {

                        $model_value = null;
                        $model_name = $value[0]['type_option'];
                        $model_name && $model_value = $model_name::find($value[0]['value']);
                        $model_value && $model_value = "Audio".Resource::make($this->videoPath);

                        // replace with api_name
                        if (!empty($data_apiName[$value[0]['attribute']])) {
                            $dataFill[$data_apiName[$value[0]['attribute']]] = $model_value;
                        } else {
                            $dataFill[$value[0]['attribute']] = $model_value;
                        }

                    }
                }


            }
        }
        return $dataFill;
    }

    protected function detachChild(&$arrays, &$result, $key, $resourcePare, $dataApiName = [])
    {

        foreach ($arrays as $k => $val) {
            if (!is_array($val) || empty($val['attribute'])) continue;
            $arr = explode('.', $val['attribute']);
            $keyApi = end($arr);

            // replace with api_name
            if (!empty($dataApiName[$keyApi])) {
                array_pop($arr);
                $arr[] = $dataApiName[$keyApi];
                $keyApi = implode('.', $arr);
                \Arr::set($result[$key], $keyApi, $val['value']);
            } else {
                \Arr::set($result[$key], $val['attribute'], $val['value']);
            }


            if ($resourcePare && !empty($val['type']) && $val['type'] == QuestionAttributes::TYPE_RELATION) {
                $model_value = $value = null;
                $modelName = $val['type_option'];

                $modelName && $model_value = $modelName::find($val['value']);
                if ($model_value && !empty($model_value->type) && in_array($model_value->type,File::TYPE_LIST_HAVE_RESOURCE)) {
                    $resource = ucfirst(strtolower($model_value->type));
                    $class = "\App\Http\Resources\API\\".$resource."Resource";
                    if (class_exists($class)) {
                        $value =  $class::make($model_value)->toArray($model_value);
                    }
                }

                // replace with api_name
                if (!empty($dataApiName[$keyApi])) {
                    array_pop($arr);
                    $arr[] = $dataApiName[$keyApi];
                    $keyApi = implode('.', $arr);
                    \Arr::set($result[$key], $keyApi, $value);

                } else {
                    \Arr::set($result[$key], $val['attribute'], $value);
                }


            }

            if (count($val) != count($val, COUNT_RECURSIVE)) {
                $this->detachChild($val, $result, $k, $resourcePare, $dataApiName);
            }
        }

    }

    public function repairAssetBundle($asset) {
        $fileIds = [];
        $anims = \Arr::get($asset, 'animations', []);
        foreach ($anims as $anim) {
            if (!empty($anim['file_id']['id'])) $fileIds[] = $anim['file_id']['id'];
        }
        $files = count($fileIds) > 0 ? File::query()->select([
            'id', 'file_path', 'name', 'type'
        ])->whereIn('id', $fileIds)->get()->keyBy('id') : collect();

        foreach ($fileIds as $animI => $anim) {
            $animFile = $files->get($anim) ?? new File();
            $anims[$animI]['url'] = $animFile->file_path_url;
            $anims[$animI]['file_data'] = $animFile;
        }

        $asset['animations'] = $anims;

        return $asset;
    }

    public function learningObjectives()
    {
//        $table = (new QuestionLearningObjective())->getTable();
//        return $this->belongsToMany(LearningObjective::class, $table)->select(['learning_objectives.id', 'code as name', 'explain', 'goal_id', 'skill_id'])->withTimestamps();
    }

    public function learningObjectiveIds()
    {
        return $this->hasMany(QuestionLearningObjective::class);
    }

}

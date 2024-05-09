<?php

namespace App\Services;

use App\Helpers\Helper;
use App\Http\Resources\API\AnswerResource;
use App\Http\Resources\API\AudioResource;
use App\Http\Resources\API\DocumentResource;
use App\Http\Resources\API\ImageResource;
use App\Http\Resources\API\TextResource;
use App\Http\Resources\API\VideoResource;
use App\Http\Services\CurlInitCustom;
use App\Models\Question;
use App\Models\VideoTimeProperty;
use Illuminate\Support\Arr;
use Modules\AdaptiveLearning\Entities\LearningObjective;
use Modules\AdaptiveLearning\Entities\TargetLanguage;

class CustomSpecialQuestionResourceService
{


//    protected $model = null;
//    protected $request = null;

//    /**
//     * Transform the resource into an array.
//     *
//     * @param \Illuminate\Http\Request $request
//     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
//     */
//    public function __construct($model, \Illuminate\Http\Request $request)
//    {
//        $useNewTypePlatform = $model->platform->use_new_platform ?? false;
//
//        $this->model = $model;
//        $this->request = $request;
//        return $this->switchResourceQuestion($this->model, $this->request, $useNewTypePlatform);
//    }


    public function switchResourceQuestion($model, $request, $useNewTypePlatform = false)
    {
        return self::oldResource($model, $request);
    }


    private function oldResource($model, $request): array
    {
        $media_types = !empty($model->platform->media_types) ? explode(',', $model->platform->media_types) : [];
        $questionContent = $model->question_content_parsed;
        $answers = $model->question_answers_parsed;
        $response_interaction_type = $model->response_interaction_type
            ? \Arr::get(Question::ITR_LIST_INTEGER, $model->response_interaction_type, '') : '';

        $index = '';
        if (isset($model->index)) {
            $index = $model->index;
        } elseif (isset($model->pivot->index)) {
            $index = $model->pivot->index;
        }

//        $appearanceTime = '';
//        if (!empty($model->appearanceTime)) {
//            $appearanceTime = $model->appearanceTime;
//        } elseif (!empty($model->pivot->appearanceTime)) {
//            $appearanceTime = $model->pivot->appearanceTime;
//        }
//        $rankingTime = '';
//        if (!empty($model->rankingTime)) {
//            $rankingTime = $model->rankingTime;
//        } elseif (!empty($model->pivot->rankingTime)) {
//            $rankingTime = $model->pivot->rankingTime;
//        }
        $content = [];
        if ($media_types) {
            foreach ($media_types as $val) {
                $val = strtolower($val);
                if ($val === 'text') {
                    $content['title'] = TextResource::make(\Arr::get($questionContent, 'title'))->toArray($request);
                    $content['text'] = TextResource::make(\Arr::get($questionContent, 'text'))->toArray($request);
                    $content['explanation_text'] = TextResource::make(\Arr::get($questionContent, 'explanation_text'))->toArray($request);
                    $content['explanation_video'] = VideoResource::make(\Arr::get($questionContent, 'explanation_video'))->toArray($request);
                    $content['explanation_audio'] = AudioResource::make(\Arr::get($questionContent, 'explanation_audio'))->toArray($request);
                    $content['description'] = TextResource::make(\Arr::get($questionContent, 'description'))->toArray($request);
                }
                $val == 'audio' && $content[strtolower($val)] = AudioResource::make(\Arr::get($questionContent, strtolower($val)))->toArray($request);
                $val == 'image' && $content[strtolower($val)] = ImageResource::make(\Arr::get($questionContent, strtolower($val)))->toArray($request);
                $val == 'video' && $content[strtolower($val)] = VideoResource::make(\Arr::get($questionContent, strtolower($val)))->toArray($request);
                $val == 'document' && $content[strtolower($val)] = DocumentResource::make(\Arr::get($questionContent, strtolower($val)))->toArray($request);
//                if ($val == 'asset_bundle_block') {
//                    $animations = \Arr::get($questionContent, 'asset_bundle_block.animations', []);
//                    $content['asset_bundle_block'] = [
//                        'id' => $model->id,
//                        'icon_id' => \Arr::get($questionContent, 'asset_bundle_block.icon_id'),
//                        'icon_url' => \Arr::get($questionContent, 'asset_bundle_block.icon.file_path_url', ''),
//                        'background_id' => \Arr::get($questionContent, 'asset_bundle_block.background_id'),
//                        'background_url' => \Arr::get($questionContent, 'asset_bundle_block.background.file_path_url', ''),
//                        'prefab_name' => \Arr::get($questionContent, 'asset_bundle_block.prefab_name'),
//                        'description' => \Arr::get($questionContent, 'asset_bundle_block.description'),
//                        'version' => \Arr::get($questionContent, 'asset_bundle_block.version'),
//                        'ios_url' => \Arr::get($questionContent, 'asset_bundle_block.ios.file_path_url'),
//                        'android_url' => \Arr::get($questionContent, 'asset_bundle_block.android.file_path_url'),
//                        'webgl_url' => \Arr::get($questionContent, 'asset_bundle_block.webgl.file_path_url'),
//                        'animations' => $animations,
//                        'config_file_name' => '',
//                    ];
//                }
            }
        }

        $templateCode = $model->platform ? $model->platform->code : '';
        $platformCode = $model->platform && $model->platform->parent ? $model->platform->parent->code : '';
        $templateName = $model->platform ? $model->platform->name : '';
        $platformName = $model->platform && $model->platform->parent ? $model->platform->parent->name : '';

        $topic = null;
        if ($model->topic_id) {
            $topic = $model->topic;
        }

//        if (!empty($model->targetLanguages)) {
//            foreach ($model->targetLanguages as &$val) {
//                $val['part_label'] = TargetLanguage::PARTS[$val['part']];
//                if ($val->pivot) {
//                    unset($val->pivot);
//                }
//            }
//        }
//
//        $objectives = [];
//        if (!empty($model->learningObjectiveIds)) {
//            foreach ($model->learningObjectiveIds as $objectiveId) {
//                $loId = $objectiveId->learning_objective_id;
//
//                $loCache = new LearningObjective();
//                $loCache->id = $loId;
//
//                $lo = $loCache->getCacheData();
//                $lo = $lo ? json_decode($lo, true) : null;
//
//                $objectives[] = $lo;
//            }
//        }

        return [
            'id' => $model->id,
            'platform_code' => intval($platformCode),
            'template_code' => intval($templateCode),
            'platform_name' => $platformName,
            'template_name' => $templateName,
            'platform_id' => $model->platform_id,
            'thumbnail' => $model->thumbnail_url,
//            'sync_id' => $model->sync_id,
            'title' => $model->title,
            'name' => $model->name,
            'description' => $model->description,
            'tag' => '',
            'metadata_version' => $model->metadata_version . "",
            'response_interaction_type' => $response_interaction_type . '',
            'question_content' => $content,
            'topic_id' => $model->topic_id ?? null,
            'topic' => $topic,
//            'old_question_id' => $model->old_question_id ?? null,
            'level' => $model->level ?? null,
            'index' => $index,
            'position' => $model->pivot?->position,
//            'target_language' => $model->targetLanguages ?? [],
            'skill_verb_id' => $model->skill_verb_id,
            'skill_verb' => $model->skillVerb ?? [],
            'part_id' => $model->part_id,
//            'appearance_time' => $appearanceTime,
//            'ranking_time' => $rankingTime,
            'answers' => AnswerResource::collection($answers)->toArray($request),
//            'learning_objectives' => $objectives
        ];
    }


    private function resourceAttributeNew($model, $request)
    {
        $answers = $questionContent = [];
        $dataAttribute = self::solveKey($model, $request);

        if (!empty($dataAttribute['answers'])) {
            $answers = $dataAttribute['answers'];
            unset($dataAttribute['answers']);
        }

        if (!empty($dataAttribute['question_content'])) {
            $questionContent = $dataAttribute['question_content'];
            unset($dataAttribute['question_content']);
        }

        $videoId = Arr::get($questionContent, 'video.id', null);

        if (!empty($questionContent['all_type_timestamp']) && $videoId) {
            $videoTimeTamps = VideoTimeProperty::query()->where('file_id', $videoId)->select('id')->get();
            $videoTimeTamps && $questionContent['video_timestamps'] = array_column($videoTimeTamps->toArray(), 'id');
        }

        $response_interaction_type = $model->response_interaction_type
            ? \Arr::get(Question::ITR_LIST_INTEGER, $model->response_interaction_type, '') : '';

        $index = '';
        if (isset($model->index)) {
            $index = $model->index;
        } elseif (isset($model->pivot->index)) {
            $index = $model->pivot->index;
        }

        $appearanceTime = '';
        if (!empty($model->appearanceTime)) {
            $appearanceTime = $model->appearanceTime;
        } elseif (!empty($model->pivot->appearanceTime)) {
            $appearanceTime = $model->pivot->appearanceTime;
        }


        $rankingTime = '';
        if (!empty($model->rankingTime)) {
            $rankingTime = $model->rankingTime;
        } elseif (!empty($model->pivot->rankingTime)) {
            $rankingTime = $model->pivot->rankingTime;
        }

        $templateCode = $model->platform ? $model->platform->code : '';
        $platformCode = $model->platform && $model->platform->parent ? $model->platform->parent->code : '';
        $templateName = $model->platform ? $model->platform->name : '';
        $platformName = $model->platform && $model->platform->parent ? $model->platform->parent->name : '';


        if (!empty($model->targetLanguages)) {
            foreach ($model->targetLanguages as &$val) {
                $val['part'] = TargetLanguage::PARTS[$val['part']];
                if ($val->pivot) {
                    unset($val->pivot);
                }
            }
        }

        $dataFill = [];

        // map api_name
        $attr = $model->platform ? $model->platform->detachAttrOptions() : [];

        $data_apiName = [];
        foreach ($attr as &$val) {
            if (!empty($val['api_name'])) {
                $data_apiName[$val['key']] = $val['api_name'];
            }

            if (!empty($val['components'])) {
                self::mapApiName($val['components'], $data_apiName);
            }
        }

        Helper::recursiveFind($dataAttribute,['position','time_answer','person']);

        return [
            'id' => $model->id,
            'platform_code' => intval($platformCode),
            'template_code' => intval($templateCode),
            'platform_name' => $platformName,
            'template_name' => $templateName,
            'sync_id' => $model->sync_id,
            'platform_id' => $model->platform_id,
            'thumbnail' => $model->thumbnail_url,
            'title' => $model->title,
            'name' => $model->name,
            'description' => $model->description,
            'tag' => '',
            'metadata_version' => $model->metadata_version . "",
            'response_interaction_type' => $response_interaction_type . '',
            'question_content' => $questionContent,
            'topic_id' => $model->topic_id ?? null,
            'level' => $model->level ?? null,
            'index' => $index,
            'target_language' => $model->targetLanguages ?? [],
            'appearance_time' => $appearanceTime,
            'ranking_time' => $rankingTime,
            'answers' => AnswerResource::collection($answers)->toArray($request),
            'attribute_others' => $dataAttribute
        ];
    }

    public function mapApiName($data, &$data_apiName)
    {
        foreach ($data as $vl) {
            if (!empty($vl['api_name'])) {
                $data_apiName[$vl['key']] = $vl['api_name'];
            }

            if (!empty($vl['components'])) {
                self::mapApiName($vl['components'], $data_apiName);
            }
        }
    }


    public function solveKey($model, $request)
    {

        $attrWithParent = $model->attributes->groupBy('group_parent')->toArray();

        $dataFill = $model->detachDataAttribute($attrWithParent, true);

        $question_content = $question_answers = $attributes = [];
        foreach ($dataFill as $key => $value) {
            if ($key === 'question_content') {
                $value['video']['id']['video_timestamps'] = Arr::get($value, 'video_timestamps');
                $animations = Arr::get($value, 'asset_bundle_block.animations', []);
                $assetBundleBlock = [];

                $value['asset_bundle_block'] = $model->repairAssetBundle(Arr::get($value, 'asset_bundle_block'));
                \Arr::get($value, 'title') && Arr::set($question_content, 'title', ['value' => \Arr::get($value, 'title')]);
                \Arr::get($value, 'text') && Arr::set($question_content, 'text', ['value' => \Arr::get($value, 'text')]);
                \Arr::get($value, 'explanation') && Arr::set($question_content, 'explanation', ['value' => \Arr::get($value, 'explanation')]);
                \Arr::get($value, 'description') && Arr::set($question_content, 'description', ['value' => \Arr::get($value, 'description')]);
                \Arr::get($value, 'video') && Arr::set($question_content, 'video', VideoResource::make(\Arr::get($value, 'video.id'))->toArray($request));
                Arr::set($question_content, 'all_type_timestamp', !empty($value['all_type_timestamp']) ? true : false);
//                \Arr::get($value,'video_timestamps') && Arr::set($question_content, 'video_timestamps', TimestampResource::make(Arr::get($value,'video_timestamps',[]))->toArray($request));
                \Arr::get($value, 'image') && Arr::set($question_content, 'image', ImageResource::make(\Arr::get($value, 'image.id'))->toArray($request));
                \Arr::get($value, 'audio') && Arr::set($question_content, 'audio', AudioResource::make(\Arr::get($value, 'audio.id'))->toArray($request));
                \Arr::get($value, 'document') && Arr::set($question_content, 'document', DocumentResource::make(\Arr::get($value, 'document.id'))->toArray($request));


                \Arr::get($value, 'asset_bundle_block.prefab_name') && Arr::set($assetBundleBlock, 'prefab_name', Arr::get($value, 'asset_bundle_block.prefab_name', ''));
                \Arr::get($value, 'asset_bundle_block.version') && Arr::set($assetBundleBlock, 'version', Arr::get($value, 'asset_bundle_block.version', ''));
                \Arr::get($value, 'asset_bundle_block.description') && Arr::set($assetBundleBlock, 'description', Arr::get($value, 'asset_bundle_block.description', ''));
                \Arr::get($value, 'asset_bundle_block.ios_id') && Arr::set($assetBundleBlock, 'ios_url', Arr::get($value, 'asset_bundle_block.ios_id.file_path_url', ''));
                \Arr::get($value, 'asset_bundle_block.android_id') && Arr::set($assetBundleBlock, 'android_url', Arr::get($value, 'asset_bundle_block.android_id.file_path_url', ''));
                \Arr::get($value, 'asset_bundle_block.webgl_id') && Arr::set($assetBundleBlock, 'webgl_url', Arr::get($value, 'asset_bundle_block.webgl_id.file_path_url', ''));
                \Arr::get($value, 'asset_bundle_block.background_id') && Arr::set($assetBundleBlock, 'background_url', Arr::get($value, 'asset_bundle_block.background_id.file_path_url', ''));
                \Arr::get($value, 'asset_bundle_block.background_id') && Arr::set($assetBundleBlock, 'background_id', Arr::get($value, 'asset_bundle_block.background_id.id', ''));
                \Arr::get($value, 'asset_bundle_block.icon_id') && Arr::set($assetBundleBlock, 'icon_url', Arr::get($value, 'asset_bundle_block.icon_id.file_path_url', ''));
                \Arr::get($value, 'asset_bundle_block.icon_id') && Arr::set($assetBundleBlock, 'icon_id', Arr::get($value, 'asset_bundle_block.icon_id.id', ''));

                $assetBundleBlock && $question_content['asset_bundle_block'] = $assetBundleBlock;
                $question_content['asset_bundle_block']['id'] = $model->id;
                $question_content['asset_bundle_block']['animations'] = array_map(function ($val) {

                    return [
                        'file_id' => Arr::get($val, 'file_id.id'),
                        'url' => Arr::get($val, 'file_id.url'),
                        'file_data' => Arr::get($val, 'file_id'),
                        'position' => [
                            'x' => Arr::get($val, 'position.x'),
                            'y' => Arr::get($val, 'position.y')
                        ]
                    ];
                }, $animations);

                $question_content['config_file_name'] = '';
                $attributes['question_content'] = $question_content;

            } elseif ($key === 'answers') {
                foreach ($value as $val) {
                    Arr::set($question_answers, 'id', Arr::get($val, 'id.id', null));
                    Arr::set($question_answers, 'text', ['value' => Arr::get($val, 'text', '')]);
                    Arr::set($question_answers, 'image', ImageResource::make(\Arr::get($val, 'image.id'))->toArray($request));
                    Arr::set($question_answers, 'audio', AudioResource::make(\Arr::get($val, 'audio.id'))->toArray($request));
                    Arr::set($question_answers, 'right_response', Arr::get($val, 'right_response', ''));
                    Arr::set($question_answers, 'animation', [
                        'url' => Arr::get($val, 'animation.id.url'),
                        'id' => Arr::get($val, 'animation.id.id'),
                        'position' => [
                            'x' => Arr::get($val, 'animation.position.x'),
                            'y' => Arr::get($val, 'animation.position.y'),
                        ],
                        'file_path' => Arr::get($val, 'animation.id.file_path'),
                        'name' => Arr::get($val, 'animation.id.name'),
                        'type' => Arr::get($val, 'animation.id.type'),
                        'file_path_url' => Arr::get($val, 'animation.id.file_path_url'),
                        'icon_file_path_url' => Arr::get($val, 'animation.id.icon_file_path_url'),
                    ]);
                    $attributes['answers'][] = $question_answers;
                }
            } elseif (!is_array($value)) {
                $attributes[$key] = $value;
            } else {

                $attributes[$key] = $value;
            }
        }
        return $attributes;
    }

}

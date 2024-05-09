<?php

namespace App\Models;

use App\Helpers\Helper;
use App\Http\Services\FileService;
use App\Traits\Cacheable;
use Eloquent as Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use phpDocumentor\Reflection\Types\Object_;
use stdClass;


class QuestionPlatform extends Model
{
    use SoftDeletes, Cacheable;

    use HasFactory;

    public $table = 'question_platforms';

    protected $dates = ['deleted_at'];

    protected $attributes = [
        'is_active' => true
    ];

    public $fillable = [
        'name',
        'code',
        'parent_id',
        'image_id',
        'is_active',
        'media_types',
        'attribute_options',
        'use_new_platform',
        'doc_link'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'code' => 'string',
        'parent_id' => 'integer',
        'image_id' => 'integer',
        'is_active' => 'boolean',
        'media_types' =>'string',
        'doc_link' =>'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'code' => 'required|integer',
        'doc_link' => 'required',
        'parent_id' => 'nullable',
        'image_id' => 'nullable',
        'is_active' => 'required'
    ];

    const SYNC_QUESTION_CODE = [
        13
    ];


    public function description(): Attribute
    {
        return Attribute::make(
            set: fn($value) => $value ?? ''
        );
    }

    public function parentId(): Attribute
    {
        return Attribute::make(
            set: fn($value) => strtolower($value) === 'root' ? null : $value
        );
    }

    public function getImageUrlAttribute()
    {
        $cache = $this->getCache(File::class, 'image', $this->image_id);
        if ($cache) {
            return Helper::makeResourceUrl($cache['file_path']);
        }

        if (!$this->image) {
            return config('cdn.default_image');
        }

        return Helper::makeResourceUrl($this->image->file_path);
    }

    public function mediaTypes()
    {
        return $this->media_types ?? [];
    }

    public function getParentNameAttribute()
    {
        return $this->parent ? $this->parent->name : __("ROOT");
    }


    public function getAttributeOptions() {
       return $this->attribute_options;
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function image()
    {
        return $this->belongsTo(File::class, 'image_id')->select([
            'id', 'file_path', 'name', 'type'
        ]);
    }


    public function detachAttrOptions() {

        $attribute_options = $this->attribute_options ?? [];
        $attribute_options && $attribute_options = json_decode($attribute_options,true);
        if (!empty($this->parent)) {

            $parentOptions = $this->parent->attribute_options;
            $parentOptions = json_decode($parentOptions,true);

            $dataSubOptions = $dataAfterOptions = [];

            foreach ($attribute_options as $key => $val) {
                if (!empty($val['parent'])) {
                    $dataSubOptions[$val['parent']][] = $val;
                    unset($attribute_options[$key]);
                }elseif (!empty($val['after'])) {
                    $dataAfterOptions[$val['after']][] = $val;
                    unset($attribute_options[$key]);
                }
            }

            if ($dataSubOptions || $dataAfterOptions) {
                foreach ($parentOptions as $key => &$value) {

                    if (!empty($value['components'])) {
                        foreach ($value['components'] as $k => &$val) {

                            // Kiểm tra nếu attr con có gán parent thì gán ngược lại vào attribute cha

                            if (!empty($val['components']) && !empty($dataSubOptions[$val['key']])) {
                                if (count($dataSubOptions[$val['key']]) === 1) {
                                    $val['components'][] = $dataSubOptions[$val['key']][0];
                                }else {
                                    $val['components'] = array_merge_recursive($val['components'],array_filter($dataSubOptions[$val['key']],function ($vl) {
                                        return $vl;
                                    }));
                                }
                            }


                            if (!empty($dataAfterOptions[$val['key']])) {
                                array_splice($parentOptions, $key+1, 0, ($dataAfterOptions[$val['key']]));
                            }
                        }
                    }
                    if (!empty($dataSubOptions[$value['key']])) {
                        if (count($dataSubOptions[$value['key']]) == 1) {
                            $value['components'][] = $dataSubOptions[$value['key']][0];
                        }else {
                            $value['components'] = array_merge_recursive($value['components'],array_filter($dataSubOptions[$value['key']],function ($vl) {
                                return $vl;
                            }));
                        }
                    }
                    if (!empty($dataAfterOptions[$value['key']])) {
                        // to do
                        array_splice($parentOptions, $key+1, 0, ($dataAfterOptions[$value['key']]));

                    }
                }
            }
            if ($parentOptions && $attribute_options) {
                return array_merge($parentOptions,$attribute_options);
            }elseif ($parentOptions) return $parentOptions;
            return $attribute_options;

        }
        return $attribute_options;
    }

}

<?php

namespace App\Http\Resources\API;

use App\Helpers\Helper;
use App\Models\LiveClass;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Traits\UsePagination;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redis;

class LiveClassResourceCollection extends ResourceCollection
{

    use UsePagination;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [];
        foreach ($this as $value) {
            $all_num_gifts = [];
            $num_gift = 0;
            $value['course'] && $all_num_gifts = Redis::lrange(config('app.key_cache_num_gift_liveClass') . $value['course'], 0, -1);
            if (count($all_num_gifts) > 0) {
                $all_num_gifts = Helper::reAssignKey($all_num_gifts, 'id');
                if (!empty($all_num_gifts[$value['id']])) {
                    $num_gift = \Arr::get($all_num_gifts[$value['id']], 'num_gift', 0);
                }
            }

            $data[] = [
                'id' => \Arr::get($value, 'id', ''),
                'name' => \Arr::get($value, 'name', ''),
                'image_path' => !empty($value['imagePath']) ? $value->resolveUrlFile(\Arr::get($value['imagePath'], 'id', ''), 'imagePath') : "",
                'description' => $value['description'] ?? '',
                'video_path' => !empty(\Arr::get($value['videoPath'], 'id')) ? $value->resolveUrlFile(\Arr::get($value['videoPath'], 'id'), 'videoPath') : "",
                'video_path2' => !empty(\Arr::get($value['videoPath2'], 'id')) ? $value->resolveUrlFile(\Arr::get($value['videoPath2'], 'id'), 'videoPath2') : "",
                'status' => \Arr::get($value, 'status', ''),
                'num_gift' => $num_gift,
                'course' => $value['course'] ?? '',
                'start_time_1st' => $value['start_time_1st'] ? Helper::format_date($value['start_time_1st']): '',
                'end_time_1st' => $value['end_time_1st'] ? Helper::format_date($value['end_time_1st']) : '',
                'start_time_2nd' => $value['start_time_2nd'] ? Helper::format_date($value['start_time_2nd']) : '',
                'end_time_2nd' => $value['end_time_2nd'] ? Helper::format_date($value['end_time_2nd']) : '',
                'processed' => true,
                'type' => $value['type']
            ];
        }

        return [
            'liveClasses' => $data,
            'pagination' => $this->pagination
        ];

    }
}

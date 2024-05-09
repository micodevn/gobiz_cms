<?php

namespace App\Http\Resources\API;

use App\Models\File;
use App\Models\VideoTimeProperty;
use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $resource = $this->resource;
        $type = \Arr::get($this, 'type');

        if (!empty($this['video_timestamps'])) {
            $videoTimeStamps = $this['video_timestamps'];
            if (count($videoTimeStamps) != count($videoTimeStamps, COUNT_RECURSIVE)) {
                $videoTimeStamps = array_column($videoTimeStamps, 'id');
            }
            $this['video_timestamps'] = VideoTimeProperty::query()->whereIn('id', $videoTimeStamps)->get();
        }

        if ($resource instanceof File) {
            $timestamps = $resource->videoTimestamps;
            $subtitles = $resource->videoSubtitles;
        } else {
            $timestamps = \Arr::get($this, 'video_timestamps', []);
            $subtitles = \Arr::get($this, 'video_subtitles', []);
        }

        $streamUrl = '';

        if ($type == File::TYPE_VIDEO || $type == File::TYPE_VIDEO_TIMESTAMP) {
            $path = \Arr::get($this, 'file_path');

            if (str_ends_with($path, '.m3u8')) {
                $streamUrl = $path;
            } else {
                if (str_starts_with($path, '/uploads')) {
                    $path = str_replace('/uploads', '', $path);
                }
                if (str_starts_with($path, 'https://static.edupia.vn/video')) {
                    $path = str_replace('https://static.edupia.vn', '', $path);
                }
                $link = '/srv/storage/origin' . $path;
                $str = md5($link . 'master');
                $streamUrl = 'https://master-hls.edupia.vn/hls/' . $str . '/master.m3u8';
                if (str_starts_with($path, '/videos/') || str_starts_with($path, '/common/') || str_starts_with($path, 'https://static.edupia.vn/dungchung')) {
                    $streamUrl = null;
                }
            }
        }

        return [
            'url' => \Arr::get($this, 'url'),
            'stream_url' => $streamUrl,
            'icon_url' => \Arr::get($this, 'icon_url'),
            'description' => \Arr::get($this, 'description'),
            'timestamps' => TimestampResource::collection($timestamps),
            'subtitles' => SubtitleResource::collection($subtitles),
        ];
    }
}

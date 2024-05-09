<?php
namespace App\Http\Services;

use App\Http\Services\Service as BaseService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class CurlInitCustom extends BaseService
{

    protected $initConnect;
    protected $cacheData = [];
    protected $formatted = null;

    public function __construct()
    {
        $this->initConnect = new \GuzzleHttp\Client([
            'verify' => false
        ]);
    }

    public function getListTopicC1Math($url, $method = 'GET', $data_options = [],$customFormatType = null)
    {
        try {
            if (Arr::has($this->cacheData, md5($url))) {
                return Arr::get($this->cacheData, md5($url));
            }

            $response = $this->initConnect->request($method, $url, $data_options);
            $response = json_decode($response->getBody(), true);
            if (empty($response['data']['content'])) return [];
            $data = [];
            foreach ($response['data']['content'] as $key => $val) {
                if ($customFormatType) {
                    $data[Arr::get($val, 'id')] = '['.Arr::get($val, 'id').'] '.Arr::get($val, 'name');
                }else {
                    $data[Arr::get($val, 'id')] = Arr::get($val, 'name');
                }
            }
            $this->formatted = $response['data']['content'];

            $this->cacheData[md5($url)] = $data;

            return $data;
        } catch (\Exception $e) {
            Log::channel('curl_init')->info($e->getMessage());
            return [];
        }
    }

    public function getTopicById($id)
    {
        if (!$this->formatted) {
            $this->getListTopicC1Math(config('app.edupia_math_domain') . '/topic/active', 'GET', [], true);
        }

        foreach ($this->formatted as $topic) {
            if (Arr::get($topic, 'id') == $id) {
                return $topic;
            }
        }

        return [];
    }
}

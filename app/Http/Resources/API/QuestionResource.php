<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Services\CustomSpecialQuestionResourceService;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {

        $useNewTypePlatform = $this->platform->use_new_platform ?? false;

        /*
         * testing switch cho nó gọn
         */
        $questionResourceService = new CustomSpecialQuestionResourceService();
        return $questionResourceService->switchResourceQuestion($this, $request, $useNewTypePlatform);
    }
}

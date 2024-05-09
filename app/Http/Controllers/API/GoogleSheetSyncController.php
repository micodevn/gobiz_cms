<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Services\GoogleSheetApiService;
use Illuminate\Http\Request;

class GoogleSheetSyncController extends Controller
{
    protected GoogleSheetApiService $ggService;

    public function __construct(GoogleSheetApiService $ggService)
    {
        $this->ggService = $ggService;
    }

    public function syncData(Request $request)
    {
        $data = $request->only('document_id', 'model');
        $documentId = \Arr::get($data, 'document_id');
        $model = \Arr::get($data, 'model');

        $this->ggService->setDocumentId($documentId);
        $this->ggService->syncModel($model);
    }
}

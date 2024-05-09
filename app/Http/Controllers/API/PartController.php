<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Modules\AdaptiveLearning\Entities\TargetLanguage;
use Illuminate\Http\Request;

class PartController extends Controller
{

    public function list(Request $request)
    {
        return TargetLanguage::PARTS;
    }

}

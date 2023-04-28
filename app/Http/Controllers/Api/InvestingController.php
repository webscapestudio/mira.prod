<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Investment;
use App\Http\Resources\InvestmentResource;

class InvestingController extends Controller
{
    public function index()
    {
        $investing = InvestmentResource::collection(Investment::get());
        if(!$investing->isEmpty()):
            return response()->json(...$investing);
        else:
            return response()->json([
                'error'=>'not found',
            ],404);
        endif;
    }
}

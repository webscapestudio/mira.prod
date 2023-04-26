<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InvestStrategies;
use App\Http\Resources\InvestStrategiesResource;

class InvestStrategiesController extends Controller
{
    public function index()
    {
        $invest_strategies =InvestStrategiesResource::collection(InvestStrategies::all());
        if(!$invest_strategies->isEmpty()):
            return response()->json($invest_strategies);
        else:
            return response()->json([
                'massage'=>'not found',
            ],404);
        endif;
    }
}

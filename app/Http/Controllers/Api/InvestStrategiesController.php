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
        return response()->json(...$invest_strategies);
    }
}

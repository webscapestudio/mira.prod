<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\InvestAdvantagesResource;
use App\Models\InvestAdvantages;

class InvestAdvantagesController extends Controller
{
    public function index()
    {
        $invest_advantages =InvestAdvantagesResource::collection(InvestAdvantages::all());
        if(!$invest_advantages->isEmpty()):
            return response()->json($invest_advantages);
        else:
            return response()->json([
                'massage'=>'not found',
            ],404);
        endif;
    }
}

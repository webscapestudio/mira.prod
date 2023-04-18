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
        return response()->json($invest_advantages);
    }
}

<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Resources\AdvantagesResource;
use App\Models\Advantages;
class AdvantagesController extends Controller
{
    public function index()
    {
        $advantages = AdvantagesResource::collection(Advantages::orderBy('sortdd', 'ASC')->get());
        if(!$advantages->isEmpty()):
            return response()->json($advantages);
        else:
            return response()->json([
                'error'=>'not found',
            ],404);
        endif;

    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Partners;
use App\Http\Resources\PartnersResource;

class PartnersController extends Controller
{
    public function index()
    {
        $partners = PartnersResource::collection(Partners::orderBy('sortdd', 'ASC')->get());
        if(!$partners->isEmpty()):
            return response()->json($partners);
        else:
            return response()->json([
                'massage'=>'not found',
            ],404);
        endif;
    }
}

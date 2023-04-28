<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Manifesto;
use App\Http\Resources\ManifestoResource;

class ManifestoController extends Controller
{
    public function index()
    {
        $manifesto = ManifestoResource::collection(Manifesto::get());
        if(!$manifesto->isEmpty()):
            return response()->json(...$manifesto);
        else:
            return response()->json([
                'error'=>'not found',
            ],404);
        endif;
    }
}

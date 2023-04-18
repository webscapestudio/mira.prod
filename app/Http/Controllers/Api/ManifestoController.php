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
        return response()->json(...$manifesto);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banners;
use App\Http\Resources\BannersResource;

class BannersController extends Controller
{
    public function index()
    {
        $banners = BannersResource::collection(Banners::orderBy('sortdd', 'ASC')->get());
        return response()->json($banners);
    }
}

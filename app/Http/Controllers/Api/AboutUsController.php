<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Http\Resources\AboutUsResource;
class AboutUsController extends Controller
{
    public function index()
    {
        $about_us =  AboutUsResource::collection(AboutUs::orderBy('sortdd', 'ASC')->get());
        if(!$about_us->isEmpty()):
            return response()->json($about_us);
        else:
            return response()->json([
                'error'=>'not found',
            ],404);
        endif;

    }
}

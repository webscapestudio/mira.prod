<?php

namespace App\Http\Controllers\Api\Pages;

use App\Http\Controllers\Controller;
use App\Http\Resources\PageResource;
use App\Models\Pages;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $page_main = PageResource::collection(Pages::where('id', 1)->get());
        return response()->json([
            'page_investitions' => $page_main,
        ]);
    }
}

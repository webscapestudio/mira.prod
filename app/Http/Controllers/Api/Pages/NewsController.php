<?php

namespace App\Http\Controllers\Api\Pages;

use App\Http\Controllers\Controller;
use App\Http\Resources\PageResource;
use App\Models\Pages;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $page_news = PageResource::collection(Pages::where('id', 5)->get());
        return response()->json([
            'page_news' => $page_news,
        ]);
    }
}
 
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Http\Resources\NewsResource;
use App\Http\Resources\NewsSingleResource;

class NewsController extends Controller
{
    
    public function index()
    {
        $news = NewsResource::collection(News::orderBy('sortdd', 'ASC')->paginate(10));
        if(!$news->isEmpty()):
            return response()->json($news->response()->getData(true));
        else:
            return response()->json([
                'massage'=>'not found',
            ],404);
        endif;
    }
    public function show($slug)
    {
        $news = NewsSingleResource::collection(News::where('slug',$slug)->get());
        if(!$news->isEmpty()):
            return response()->json(...$news);
        else:
            return response()->json([
                'massage'=>'not found',
            ],404);
        endif;
    }
}

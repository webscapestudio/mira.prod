<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\History;
use App\Http\Resources\HistoryResource;

class HistoryController extends Controller
{
    public function index()
    {
        $history = HistoryResource::collection(History::orderBy('year', 'ASC')->get());
        if(!$history->isEmpty()):
            return response()->json($history);
        else:
            return response()->json([
                'error'=>'not found',
            ],404);
        endif;
    }
}

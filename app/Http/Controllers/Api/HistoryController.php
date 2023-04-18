<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\History;
use App\Http\Resources\HistoryResource;

class HistoryController extends Controller
{
    public function index()
    {
        $history = HistoryResource::collection(History::orderBy('sortdd', 'ASC')->get());
        return response()->json($history);
    }
}

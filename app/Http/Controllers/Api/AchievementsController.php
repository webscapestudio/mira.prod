<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Achievements;
use App\Http\Resources\AchievementsResource;

class AchievementsController extends Controller
{
    public function index()
    {
        $achievements = AchievementsResource::collection(Achievements::orderBy('sortdd', 'ASC')->get());
        if(!$achievements->isEmpty()):
            return response()->json($achievements);
        else:
            return response()->json([
                'massage'=>'not found',
            ],404);
        endif;

    }
}

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
        return response()->json($achievements);
    }
}

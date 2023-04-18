<?php

namespace App\Http\Controllers\Api\Projects;

use App\Http\Controllers\Controller;
use App\Http\Resources\Projects\ProjectProgressPointsResource;
use App\Models\Project;
use App\Models\ProjectProgressPoint;
use Illuminate\Http\Request;

class ProjectProgressPointsController extends Controller
{
    public function index($project_slug)
    {
        $project = Project::where('slug', $project_slug)->first();
        $points =  ProjectProgressPointsResource::collection(ProjectProgressPoint::orderBy('sortdd', 'ASC')->where('project_progress_pointable_id',  $project->id)->get());
        return response()->json($points);
    }
}

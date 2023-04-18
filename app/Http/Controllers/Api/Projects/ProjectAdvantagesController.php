<?php

namespace App\Http\Controllers\Api\Projects;

use App\Http\Controllers\Controller;
use App\Http\Resources\Projects\ProjectAdvantagesResource;
use App\Models\Project;
use App\Models\ProjectAdvantage;
use Illuminate\Http\Request;

class ProjectAdvantagesController extends Controller
{
    public function index($project_slug)
    {
        $project = Project::where('slug', $project_slug)->first();
        $advantages =  ProjectAdvantagesResource::collection(ProjectAdvantage::orderBy('sortdd', 'ASC')->where('project_advantageable_id',  $project->id)->get());
        return response()->json($advantages);
    }
}

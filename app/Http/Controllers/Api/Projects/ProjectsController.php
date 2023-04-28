<?php

namespace App\Http\Controllers\Api\Projects;

use App\Http\Controllers\Controller;
use App\Http\Resources\Projects\ProjectResource;
use App\Http\Resources\Projects\ProjectsResource;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects =  ProjectsResource::collection(Project::orderBy('sortdd', 'ASC')->get());
        return response()->json($projects);
    }
    public function show($slug)
    {
        $project = ProjectResource::collection(Project::where('slug',$slug)->get());
    if(!$project->isEmpty()):
        return response()->json(...$project);
    else:
        return response()->json([
            'error'=>'not found',
        ],404);
    endif;
    }

}

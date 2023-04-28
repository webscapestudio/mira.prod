<?php

namespace App\Http\Controllers\Api\Projects;

use App\Http\Controllers\Controller;
use App\Http\Resources\Projects\ProjectMainInformationResource;
use App\Models\Project;
use App\Models\ProjectMain;
use Illuminate\Http\Request;

class ProjectMainInformationController extends Controller
{
    public function index($project_slug)
    {
        
        $project = Project::where('slug', $project_slug)->first();
        if($project):
        $main_info =  ProjectMainInformationResource::collection(ProjectMain::orderBy('sortdd', 'ASC')->where('project_mainable_id',  $project->id)->get());
        return response()->json($main_info);
        else:
            return response()->json([
                'error'=>'not found',
            ],404);
        endif;
    }
}

<?php

namespace App\Http\Controllers\Api\Projects;

use App\Http\Controllers\Controller;
use App\Http\Resources\Projects\ProjectUnitResource;
use App\Http\Resources\Projects\ProjectUnitsResource;
use App\Models\Project;
use App\Models\ProjectUnit;
use Illuminate\Http\Request;

class ProjectUnitsController extends Controller
{
    public function index($project_slug)
    {  
        $project = Project::where('slug', $project_slug)->first();
        if($project):
            $units =  ProjectUnitsResource::collection(ProjectUnit::orderBy('sortdd', 'ASC')->where('project_unitable_id',  $project->id)->get());
            return response()->json($units);
            else:
                return response()->json([
                    'massage'=>'not found',
                ],404);
            endif;
    }
    public function show($slug,$id)
    {

        $project = Project::where('slug', $slug)->first();
        if($project):
            $unit = ProjectUnitResource::collection($project->project_units()->where('id',$id)->get());
            if(!$unit->isEmpty()):
                return response()->json(...$unit);
            else:
                return response()->json([
                    'massage'=>'not found',
                ],404);
            endif;

            else:
                return response()->json([
                    'massage'=>'not found',
                ],404);
            endif;

    }

}

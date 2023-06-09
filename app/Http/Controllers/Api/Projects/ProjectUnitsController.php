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
    public function index($project_slug,Request $request)
    {  

        $project = Project::where('slug', $project_slug)->first();
        if($project):
            $units =  ProjectUnitsResource::collection(ProjectUnit::orderBy('price', 'ASC')->where('project_unitable_id',  $project->id)->get());
            if ($search_type = $request->type and $search_bedrooms_quantity= $request->bedrooms_quantity) :
                $units = ProjectUnitsResource::collection(ProjectUnit::orderBy('price', 'ASC')
                    ->where('type', 'LIKE', "%{$search_type}%")
                    ->where('bedrooms_quantity', 'LIKE', "%{$search_bedrooms_quantity}%")
                    ->where('project_unitable_id',  $project->id)
                    ->get());
                    return response()->json($units);
            endif;
            if ($search = $request->type) :
                $units = ProjectUnitsResource::collection(ProjectUnit::orderBy('price', 'ASC')
                    ->where('type', 'LIKE', "%{$search}%")
                    ->where('project_unitable_id',  $project->id)
                    ->get());
                    return response()->json($units);
            endif;
            if ($search = $request->bedrooms_quantity) :
                $units = ProjectUnitsResource::collection(ProjectUnit::orderBy('price', 'ASC')
                    ->where('bedrooms_quantity', 'LIKE', "%{$search}%")
                    ->where('project_unitable_id',  $project->id)
                    ->get());
                    return response()->json($units);
            endif;

            return response()->json($units);
            else:
                return response()->json([
                    'error'=>'not found',
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
                    'error'=>'not found',
                ],404);
            endif;

            else:
                return response()->json([
                    'error'=>'not found',
                ],404);
            endif;

    }

}

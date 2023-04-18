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
        $units =  ProjectUnitsResource::collection(ProjectUnit::orderBy('sortdd', 'ASC')->where('project_unitable_id',  $project->id)->get());
        return response()->json($units);
    }
    public function show($slug,$id)
    {
        $unit = ProjectUnitResource::collection(ProjectUnit::where('id',$id)->get());
        return response()->json(...$unit);
    }

}

<?php

namespace App\Http\Controllers\Api\Projects;

use App\Http\Controllers\Controller;
use App\Http\Resources\Projects\ProjectLocationResource;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectLocationController extends Controller
{
    public function index($slug)
    {
        $main_info =  ProjectLocationResource::collection(Project::collection(Project::where('slug',  $slug)->get());
        return response()->json(...$main_info);
    }
}

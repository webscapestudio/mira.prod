<?php

namespace App\Http\Controllers\Api\Projects;

use App\Http\Controllers\Controller;
use App\Http\Resources\Projects\ProjectUspResource;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectUspController extends Controller
{
    public function index()
    {
        $usp =  ProjectUspResource::collection(Project::get());
        return response()->json(...$usp);
    }
}

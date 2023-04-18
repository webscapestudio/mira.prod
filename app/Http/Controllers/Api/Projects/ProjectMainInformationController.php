<?php

namespace App\Http\Controllers\Api\Projects;

use App\Http\Controllers\Controller;
use App\Http\Resources\Projects\ProjectMainInformationResource;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectMainInformationController extends Controller
{
    public function index()
    {
        $main_info =  ProjectMainInformationResource::collection(Project::get());
        return response()->json(...$main_info);
    }
}

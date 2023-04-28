<?php

namespace App\Http\Controllers\Api\Projects;

use App\Http\Controllers\Controller;
use App\Http\Resources\Projects\ProjectPicturesResource;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectPicturesController extends Controller
{
    public function index($slug)
    {
        $pictures =  ProjectPicturesResource::collection(Project::where('slug', $slug)->get());

        if(!$pictures->isEmpty()):
            return response()->json(...$pictures);
        else:
            return response()->json([
                'error'=>'not found',
            ],404);
        endif;
        }
    
}

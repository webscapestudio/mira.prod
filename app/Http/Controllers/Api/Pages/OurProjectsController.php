<?php

namespace App\Http\Controllers\Api\Pages;

use App\Http\Controllers\Controller;
use App\Http\Resources\PageResource;
use App\Models\Pages;
use Illuminate\Http\Request;

class OurProjectsController extends Controller
{
    public function index()
    {
        $page_projects = PageResource::collection(Pages::where('id', 3)->get());
        return response()->json([
            'page_projects' => $page_projects,
        ]);
    }
}

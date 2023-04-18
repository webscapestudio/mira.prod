<?php

namespace App\Http\Controllers\Api\Pages;

use App\Http\Controllers\Controller;
use App\Http\Resources\PageResource;
use App\Models\Pages;
use Illuminate\Http\Request;

class WorkWithUsController extends Controller
{
    public function index()
    {
        $page_vacancies = PageResource::collection(Pages::where('id', 4)->get());
        return response()->json([
            'page_vacancies' => $page_vacancies,
        ]);
    }
}

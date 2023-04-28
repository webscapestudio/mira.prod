<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VacanciesResource;
use App\Models\Vacancies;
use Illuminate\Http\Request;

class VacanciesController extends Controller
{
    public function index()
    {
        $vacancies = VacanciesResource::collection(Vacancies::orderBy('sortdd', 'ASC')->get());
        if(!$vacancies->isEmpty()):
            return response()->json($vacancies);
        else:
            return response()->json([
                'error'=>'not found',
            ],404);
        endif;
    }
}

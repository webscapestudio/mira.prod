<?php

use App\Http\Controllers\Api\AboutUsController;
use App\Http\Controllers\Api\AchievementsController;
use App\Http\Controllers\Api\BannersController;
use App\Http\Controllers\Api\GeneralRequestsController;
use App\Http\Controllers\Api\ResumeRequestsController;
use App\Http\Controllers\Api\AdvantagesController;
use App\Http\Controllers\Api\HistoryController;
use App\Http\Controllers\Api\ManifestoController;
use App\Http\Controllers\Api\PartnersController;
use App\Http\Controllers\Api\InvestingController;
use App\Http\Controllers\Api\InvestAdvantagesController;
use App\Http\Controllers\Api\InvestStrategiesController;
use App\Http\Controllers\Api\ContactsController;
use App\Http\Controllers\Api\NewsController as ApiNewsController;
use App\Http\Controllers\Api\NewsSingleController;
use App\Http\Controllers\Api\Pages\MainController;
use App\Http\Controllers\Api\Pages\InvestitionsController;
use App\Http\Controllers\Api\Pages\NewsController;
use App\Http\Controllers\Api\Pages\OurProjectsController;
use App\Http\Controllers\Api\Pages\WorkWithUsController;
use App\Http\Controllers\Api\Projects\ProjectAdvantagesController;
use App\Http\Controllers\Api\Projects\ProjectLocationController;
use App\Http\Controllers\Api\Projects\ProjectMainInformationController;
use App\Http\Controllers\Api\Projects\ProjectPicturesController;
use App\Http\Controllers\Api\Projects\ProjectProgressPointsController;
use App\Http\Controllers\Api\Projects\ProjectsController;
use App\Http\Controllers\Api\Projects\ProjectUnitsController;
use App\Http\Controllers\Api\Projects\ProjectUspController;
use App\Http\Controllers\Api\VacanciesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware("auth:sanctum")->get("/user", function (Request $request) {
    return $request->user();
});

Route::apiResources([
    'general_request' => GeneralRequestsController::class,
    'resume_request' => ResumeRequestsController::class,
    'banners' => BannersController::class,
    'achievements' => AchievementsController::class,
    'about' => AboutUsController::class,
    'advantages' => AdvantagesController::class,
    'history' => HistoryController::class,
    'manifesto' => ManifestoController::class,
    'partners' => PartnersController::class,
    'investments/main' => InvestingController::class,
    'investments/advantages' => InvestAdvantagesController::class,
    'investments/strategies' => InvestStrategiesController::class,
    'news' => ApiNewsController::class,
    'vacancies' => VacanciesController::class,
    'contacts' => ContactsController::class,
    'page/main' => MainController::class,
    'page/investments' => InvestitionsController::class,
    'page/our-projects' => OurProjectsController::class,
    'page/work-with-us' => WorkWithUsController::class,
    'page/news' => NewsController::class,
    'projects' => ProjectsController::class,
    'projects/{project_slug}/pictures' => ProjectPicturesController::class,
    'projects/{project_slug}/main_information' => ProjectMainInformationController::class,
    'projects/{project_slug}/advantages' => ProjectAdvantagesController::class,
    'projects/{project_slug}/progress_points' => ProjectProgressPointsController::class,
    'projects/{project_slug}/location' => ProjectLocationController::class,
    'projects/{project_slug}/usp' => ProjectUspController::class,
    'projects/{unit_id}/units' => ProjectUnitsController::class,
    'projects/{unit_id}/units/{project_slug}' => ProjectUnitsController::class,

]);
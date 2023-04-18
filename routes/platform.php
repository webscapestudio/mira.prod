<?php

declare(strict_types=1);

use App\Orchid\Screens\AboutUs\AboutAchievementsCreateScreen;
use App\Orchid\Screens\AboutUs\AboutAchievementsEditScreen;
use App\Orchid\Screens\AboutUs\AboutUsEditScreen;
use App\Orchid\Screens\AboutUs\AboutUsListScreen;
use App\Orchid\Screens\Achievements\AchievementsEditScreen;
use App\Orchid\Screens\Achievements\AchievementsListScreen;
use App\Orchid\Screens\Achievements\AchievementsScreen;
use App\Orchid\Screens\Advantages\AdvantagesEditScreen;
use App\Orchid\Screens\Advantages\AdvantagesList;
use App\Orchid\Screens\Banners\BannersEdit;
use App\Orchid\Screens\Banners\BannersList;
use App\Orchid\Screens\Contacts\ContactsEditScreen;
use App\Orchid\Screens\Contacts\SocialsCreateScreen;
use App\Orchid\Screens\Contacts\SocialsEditScreen;
use App\Orchid\Screens\Gallery\GalleryListScreen;
use App\Orchid\Screens\History\HistoryEditScreen;
use App\Orchid\Screens\History\HistoryListScreen;
use App\Orchid\Screens\Investments\Advantages\AdvantagesEditScreen as AdvantagesAdvantagesEditScreen;
use App\Orchid\Screens\Investments\Advantages\AdvantagesListScreen;
use App\Orchid\Screens\Investments\InvestmentEditScreen;
use App\Orchid\Screens\Investments\Strategies\StrategiesEditScreen;
use App\Orchid\Screens\Investments\Strategies\StrategiesListScreen;
use App\Orchid\Screens\Manifesto\ManifestoEditScreen;
use App\Orchid\Screens\News\NewsEditScreen;
use App\Orchid\Screens\News\NewsListScreen;
use App\Orchid\Screens\PagesEditScreen;
use App\Orchid\Screens\PagesScreen;
use App\Orchid\Screens\Partners\PartnersEditScreen;
use App\Orchid\Screens\Partners\PartnersListScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Projects\Advantages\AdvantagesCreateScreen as ProjectsAdvantagesAdvantagesCreateScreen;
use App\Orchid\Screens\Projects\Advantages\AdvantagesEditScreen as ProjectsAdvantagesAdvantagesEditScreen;
use App\Orchid\Screens\Projects\ProgressPoints\PointCreateScreen;
use App\Orchid\Screens\Projects\ProgressPoints\PointEditScreen;
use App\Orchid\Screens\Projects\ProjectsEditScreen;
use App\Orchid\Screens\Projects\ProjectsListScreen;
use App\Orchid\Screens\Projects\Units\UnitsCreateScreen;
use App\Orchid\Screens\Projects\Units\UnitsEditScreen;
use App\Orchid\Screens\Requests\GeneralRequestsListScreen;
use App\Orchid\Screens\Requests\ResumeRequestsListScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use App\Orchid\Screens\Vacancies\VacanciesEditScreen;
use App\Orchid\Screens\Vacancies\VacanciesListScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Pages
Route::screen("pages", PagesScreen::class)
    ->name('platform.pages')
    ->breadcrumbs(
        fn (Trail $trail) => $trail->parent('platform.index')->push('Pages')
    );
Route::screen('pages/{id}/edit', PagesEditScreen::class)
    ->name('platform.pages.edit');
// Gallery
Route::screen("gallery", GalleryListScreen::class)
    ->name('platform.gallery.list')
    ->breadcrumbs(
        fn (Trail $trail) => $trail->parent('platform.index')->push('Gallery')
    );
// Banners
Route::screen("banners", BannersList::class)
    ->name('platform.banners.list')
    ->breadcrumbs(
        fn (Trail $trail) => $trail->parent('platform.index')->push('Banners')
    );
Route::screen("banners/create", BannersEdit::class)
    ->name('platform.banners.create')
    ->breadcrumbs(
        fn (Trail $trail) => $trail->parent('platform.banners.list')->push('Create')
    );
Route::screen('banners/{banner}/edit', BannersEdit::class)
    ->name('platform.banners.edit')
    ->breadcrumbs(
        fn (Trail $trail) => $trail->parent('platform.banners.list')->push('Edit')
    );


// Achievements
Route::screen('achievements', AchievementsScreen::class)
    ->name('platform.achievements.list')
    ->breadcrumbs(
        fn (Trail $trail) => $trail->parent('platform.index')->push('Achievements')
    );
Route::screen('achievements/create', AchievementsEditScreen::class)
    ->name('platform.achievements.create')
    ->breadcrumbs(
        fn (Trail $trail) => $trail->parent('platform.achievements.list')->push('Create')
    );

Route::screen('achievements/{id}/edit', AchievementsEditScreen::class)
    ->name('platform.achievements.edit')
    ->breadcrumbs(
        fn (Trail $trail) => $trail->parent('platform.achievements.list')->push('Edit')
    );

// AboutUs
Route::group(['namespace' => 'AboutUs', 'prefix' => 'about-us'], function () {
    Route::screen('/all', AboutUsListScreen::class)
        ->name('platform.about-us.list')
        ->breadcrumbs(
            fn (Trail $trail) => $trail->parent('platform.index')->push('About Us')
        );;
    Route::screen('/create', AboutUsEditScreen::class)
        ->name('platform.about-us.create')
        ->breadcrumbs(
            fn (Trail $trail) => $trail->parent('platform.about-us.list')->push('Create')
        );
    Route::screen('/{id_about_us}/edit', AboutUsEditScreen::class)
        ->name('platform.about-us.edit')
        ->breadcrumbs(
            fn (Trail $trail) => $trail->parent('platform.about-us.list')->push('Edit')
        );
    Route::group(['prefix' => '/{id}'], function () {
        Route::screen('about_achievement/{id_about_us}/edit', AboutAchievementsEditScreen::class)
            ->name('platform.about_achievements.edit')
            ->breadcrumbs(
                fn (Trail $trail) => $trail->parent('platform.about-us.list')->push('Achievement Edit')
            );
        Route::screen('about_achievement/create', AboutAchievementsCreateScreen::class)
            ->name('platform.about_achievements.create')
            ->breadcrumbs(
                fn (Trail $trail) => $trail->parent('platform.about-us.list')->push('Achievement Create')
            );
    });
});

//Advantages
Route::screen('advantages', AdvantagesList::class)
    ->name('platform.advantages.list')
    ->breadcrumbs(
        fn (Trail $trail) => $trail->parent('platform.index')->push('Advantages')
    );
Route::screen('advantages/create', AdvantagesEditScreen::class)
    ->name('platform.advantages.create')
    ->breadcrumbs(
        fn (Trail $trail) => $trail->parent('platform.advantages.list')->push('Create')
    );
Route::screen('advantages/{id}/edit', AdvantagesEditScreen::class)
    ->name('platform.advantages.edit')
    ->breadcrumbs(
        fn (Trail $trail) => $trail->parent('platform.advantages.list')->push('Edit')
    );


// History
Route::screen('history', HistoryListScreen::class)
    ->name('platform.history.list')
    ->breadcrumbs(
        fn (Trail $trail) => $trail->parent('platform.index')->push('History')
    );
Route::screen('history/create', HistoryEditScreen::class)
    ->name('platform.history.create')
    ->breadcrumbs(
        fn (Trail $trail) => $trail->parent('platform.history.list')->push('Create')
    );
Route::screen('history/{id}/edit', HistoryEditScreen::class)
    ->name('platform.history.edit')
    ->breadcrumbs(
        fn (Trail $trail) => $trail->parent('platform.history.list')->push('Edit')
    );;


// Manifesto
Route::screen('manifestos/{id}/edit', ManifestoEditScreen::class)
    ->name('platform.manifestos.edit')
    ->breadcrumbs(
        fn (Trail $trail) => $trail->parent('platform.index')->push('Manifesto')
    );


// Partners
Route::screen('partners', PartnersListScreen::class)
    ->name('platform.partners.list')
    ->breadcrumbs(
        fn (Trail $trail) => $trail->parent('platform.index')->push('Partners')
    );
Route::screen('partners/create', PartnersEditScreen::class)
    ->name('platform.partners.create')
    ->breadcrumbs(
        fn (Trail $trail) => $trail->parent('platform.partners.list')->push('Create')
    );
Route::screen('partners/{id}/edit', PartnersEditScreen::class)
    ->name('platform.partners.edit')
    ->breadcrumbs(
        fn (Trail $trail) => $trail->parent('platform.partners.list')->push('Edit')
    );

// Contacts
Route::screen('contacts/{id}/edit', ContactsEditScreen::class)
    ->name('platform.contacts.edit')
    ->breadcrumbs(
        fn (Trail $trail) => $trail->parent('platform.index')->push('Сontacts')
    );
Route::screen('contacts/social/create', SocialsCreateScreen::class)
    ->name('platform.social.create')
    ->breadcrumbs(
        fn (Trail $trail) => $trail->parent('platform.contacts.edit')->push('Social Media Edit')
    );
Route::screen('contacts/social/{id}/edit', SocialsEditScreen::class)
    ->name('platform.social.edit')
    ->breadcrumbs(
        fn (Trail $trail) => $trail->parent('platform.contacts.edit')->push('Social Media Create')
    );


// Investments
Route::screen('investments/{id}/edit', InvestmentEditScreen::class)
    ->name('platform.investments.edit')
    ->breadcrumbs(
        fn (Trail $trail) => $trail->parent('platform.index')->push('Investment')
    );

Route::screen('investments/invest_advantages', AdvantagesListScreen::class)
    ->name('platform.invest_advantages.list')
    ->breadcrumbs(
        fn (Trail $trail) => $trail->parent('platform.index')->push('Investment Advantages')
    );
Route::screen('investments/invest_advantages/create', AdvantagesAdvantagesEditScreen::class)
    ->name('platform.invest_advantages.create')
    ->breadcrumbs(
        fn (Trail $trail) => $trail->parent('platform.invest_advantages.list')->push('Create')
    );
Route::screen('investments/{id}/invest_advantages/edit', AdvantagesAdvantagesEditScreen::class)
    ->name('platform.invest_advantages.edit')
    ->breadcrumbs(
        fn (Trail $trail) => $trail->parent('platform.invest_advantages.list')->push('Edit')
    );

Route::screen('investments/invest_strategies', StrategiesListScreen::class)
    ->name('platform.invest_strategies.list')
    ->breadcrumbs(
        fn (Trail $trail) => $trail->parent('platform.index')->push('Investment Strategies')
    );
Route::screen('investments/invest_strategies/create', StrategiesEditScreen::class)
    ->name('platform.invest_strategies.create')
    ->breadcrumbs(
        fn (Trail $trail) => $trail->parent('platform.invest_strategies.list')->push('Create')
    );
Route::screen('investments/{id}/invest_strategies/edit', StrategiesEditScreen::class)
    ->name('platform.invest_strategies.edit')
    ->breadcrumbs(
        fn (Trail $trail) => $trail->parent('platform.invest_strategies.list')->push('Edit')
    );

// Vacancies
Route::screen('vacancies', VacanciesListScreen::class)
    ->name('platform.vacancies.list')
    ->breadcrumbs(
        fn (Trail $trail) => $trail->parent('platform.index')->push('Vacancies')
    );
Route::screen('vacancy/create', VacanciesEditScreen::class)
    ->name('platform.vacancies.create')
    ->breadcrumbs(
        fn (Trail $trail) => $trail->parent('platform.vacancies.list')->push('Create')
    );
Route::screen('vacancy/{id}/edit', VacanciesEditScreen::class)
    ->name('platform.vacancies.edit')
    ->breadcrumbs(
        fn (Trail $trail) => $trail->parent('platform.vacancies.list')->push('Edit')
    );

// News
Route::screen('news', NewsListScreen::class)
    ->name('platform.news.list')
    ->breadcrumbs(
        fn (Trail $trail) => $trail->parent('platform.index')->push('News')
    );
Route::screen('news/create', NewsEditScreen::class)
    ->name('platform.news.create')
    ->breadcrumbs(
        fn (Trail $trail) => $trail->parent('platform.news.list')->push('Create')
    );
Route::screen('news/{id}/edit', NewsEditScreen::class)
    ->name('platform.news.edit')
    ->breadcrumbs(
        fn (Trail $trail) => $trail->parent('platform.news.list')->push('Edit')
    );

Route::screen('general_requests', GeneralRequestsListScreen::class)->name('platform.general_request.list');
Route::screen('resume_requests', ResumeRequestsListScreen::class)->name('platform.resume_request.list');

//Projects


    Route::group(['namespace' => 'Projet', 'prefix' => 'projects'], function () {
        Route::screen('/all', ProjectsListScreen::class)
    ->name('platform.project.list')
    ->breadcrumbs(
        fn (Trail $trail) => $trail->parent('platform.index')->push('Projects')
    );
    Route::screen('/create', ProjectsEditScreen::class)
    ->name('platform.project.create')
    ->breadcrumbs(
        fn (Trail $trail) => $trail->parent('platform.project.list')->push('Create')
    );
    Route::screen('/{id_project}/edit', ProjectsEditScreen::class)
    ->name('platform.project.edit')
    ->breadcrumbs(
        fn (Trail $trail) => $trail->parent('platform.project.list')->push('Edit')
    );

        Route::group(['prefix' => '/{id}'], function () {
            Route::screen('project_advantage/{id_project}/edit', ProjectsAdvantagesAdvantagesEditScreen::class)
                ->name('platform.project_advantage.edit')
                ->breadcrumbs(
                    fn (Trail $trail) => $trail->parent('platform.project.list')->push('Advantage Edit')
                );
            Route::screen('project_advantage/create', ProjectsAdvantagesAdvantagesCreateScreen::class)
                ->name('platform.project_advantage.create')
                ->breadcrumbs(
                    fn (Trail $trail) => $trail->parent('platform.project.list')->push('Advantage Create')
                );
        });
        Route::group(['prefix' => '/{id}'], function () {
            Route::screen('project_progress_point/{id_project}/edit', PointEditScreen::class)
                ->name('platform.project_progress_point.edit')
                ->breadcrumbs(
                    fn (Trail $trail) => $trail->parent('platform.project.list')->push('Point Edit')
                );
            Route::screen('project_progress_point/create', PointCreateScreen::class)
                ->name('platform.project_progress_point.create')
                ->breadcrumbs(
                    fn (Trail $trail) => $trail->parent('platform.project.list')->push('Point Create')
                );
        });
        Route::group(['prefix' => '/{id}'], function () {
            Route::screen('project_unit/{id_project}/edit', UnitsEditScreen::class)
                ->name('platform.project_unit.edit')
                ->breadcrumbs(
                    fn (Trail $trail) => $trail->parent('platform.project.list')->push('Unit Edit')
                );
            Route::screen('project_unit/create', UnitsCreateScreen::class)
                ->name('platform.project_unit.create')
                ->breadcrumbs(
                    fn (Trail $trail) => $trail->parent('platform.project.list')->push('Unit Create')
                );
        });
    });



// Main
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Profile'), route('platform.profile')));

// Platform > System > Users > User
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(fn (Trail $trail, $user) => $trail
        ->parent('platform.systems.users')
        ->push($user->name, route('platform.systems.users.edit', $user)));

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.users')
        ->push(__('Create'), route('platform.systems.users.create')));

// Platform > System > Users
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Users'), route('platform.systems.users')));

// Platform > System > Roles > Role
Route::screen('roles/{role}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(fn (Trail $trail, $role) => $trail
        ->parent('platform.systems.roles')
        ->push($role->name, route('platform.systems.roles.edit', $role)));

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.roles')
        ->push(__('Create'), route('platform.systems.roles.create')));

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Roles'), route('platform.systems.roles')));

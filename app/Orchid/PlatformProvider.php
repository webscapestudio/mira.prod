<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * @return Menu[]
     */

    public function registerMainMenu(): array
    {
        return [
            // Menu::make('')
            // // Menu::make('Example screen')
            // //     ->icon('monitor')
            // //     ->route('platform.example')
            // //     ->title('Navigation')
            // //     ->badge(fn () => 6),

            Menu::make('Pages')
                ->icon('monitor')
                ->route('platform.pages'),

            Menu::make('Blocks')
                ->icon('code')
                ->list([

                    Menu::make('Banners')
                        ->route('platform.banners.list'),
                    Menu::make('Achievements')
                        ->route('platform.achievements.list'),
                    Menu::make('About Us')
                        ->route('platform.about-us.list'),
                    Menu::make('Advantages')
                        ->route('platform.advantages.list'),
                    Menu::make('History')
                        ->route('platform.history.list'),
                    Menu::make('Manifesto')
                        ->route('platform.manifestos.edit', '1'),
                    Menu::make('Partners')
                        ->route('platform.partners.list'),
                    Menu::make('Contacts')
                        ->route('platform.contacts.edit', '1'),

                ]),

            Menu::make('Investitions')
                ->icon('chart')
                ->list([
                    Menu::make('Main page')->route('platform.investments.edit', '1'),
                    Menu::make('Advantages')->route('platform.invest_advantages.list'),
                    Menu::make('Strategies')->route('platform.invest_strategies.list'),
                ]),


            Menu::make('News')
                ->icon('speech')->route('platform.news.list'),
            Menu::make('Vacancies')->icon('note')->route('platform.vacancies.list'),

            Menu::make('Gallery')
                ->icon('picture') 
                ->route('platform.gallery.list'),


            Menu::make('Projects')
                ->icon('building') 
                ->route('platform.project.list'),




            // Menu::make('Requests')
            //     ->icon('envelope')
            //     ->list([
            //         Menu::make('General request')->route('platform.general_request.list'),
            //         Menu::make('Resume request')->route('platform.resume_request.list')
            //     ]),



            // Menu::make('Advanced Elements')
            //     ->icon('briefcase')
            //     ->route('platform.example.advanced'),

            // Menu::make('Text Editors')
            //     ->icon('list')
            //     ->route('platform.example.editors'),

            // Menu::make('Overview layouts')
            //     ->title('Layouts')
            //     ->icon('layers')
            //     ->route('platform.example.layouts'),

            // Menu::make('Chart tools')
            //     ->icon('bar-chart')
            //     ->route('platform.example.charts'),

            // Menu::make('Cards')
            //     ->icon('grid')
            //     ->route('platform.example.cards')
            //     ->divider(),

            // Menu::make('Documentation')
            //     ->title('Docs')
            //     ->icon('docs')
            //     ->url('https://orchid.software/en/docs'),

            // Menu::make('Changelog')
            //     ->icon('shuffle')
            //     ->url('https://github.com/orchidsoftware/platform/blob/master/CHANGELOG.md')
            //     ->target('_blank')
            //     ->badge(fn () => Dashboard::version(), Color::DARK()),

            // Menu::make(__('Users'))
            //     ->icon('user')
            //     ->route('platform.systems.users')
            //     ->permission('platform.systems.users')
            //     ->title(__('Access rights')),

            // Menu::make(__('Roles'))
            //     ->icon('lock')
            //     ->route('platform.systems.roles')
            //     ->permission('platform.systems.roles'),
        ];
    }

    /**
     * @return Menu[]
     */
    public function registerProfileMenu(): array
    {
        return [
            Menu::make(__('Profile'))
                ->route('platform.profile')
                ->icon('user'),
        ];
    }

    /**
     * @return ItemPermission[]
     */
    public function registerPermissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
        ];
    }
}

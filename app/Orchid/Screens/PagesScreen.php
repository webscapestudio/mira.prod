<?php

namespace App\Orchid\Screens;

use App\Models\Pages;
use App\Orchid\Layouts\Pages\PagesListLayout;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;

class PagesScreen extends Screen
{

    public $pages;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Pages $pages): iterable
    {
        return [
            'pages' => Pages::all()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Pages';
    }
 
    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            PagesListLayout::class
        ];
    }
}

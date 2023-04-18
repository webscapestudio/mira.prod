<?php

namespace App\Orchid\Screens;

use App\Models\Pages;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PagesEditScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Pages $pages): iterable
    {
        return [
            'pages' => $pages
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Page Edit';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Save'))
            ->icon('check')
            ->method('createOrUpdate'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::rows([
                Input::make('pages.title')->title('Title')->type('text')->required(),
                Input::make('pages.slug')->title('Slug')->type('text')->required(),
                TextArea::make('pages.description')->title('Description')->type('text')->required(),
            ]),
        ];
    }
    public function createOrUpdate(Pages $pages, Request $request)
    {
        $pages->fill($request->get('pages'))->save();
        return redirect()->route('platform.pages');
        Toast::info(__('Successfully saved'));
    }
}

<?php

namespace App\Orchid\Screens\History;

use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class HistoryEditScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(History $history): iterable
    {
        return [
            'history' => $history
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        if (Route::currentRouteName() === 'platform.history.create') :
            return 'Create';
        else :
            return 'Edit';
        endif;
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
                Input::make('history.year')->title('Year')->type('number')->required(),
                Input::make('history.title')->title('Title')->type('text')->required(),
                TextArea::make('history.description')->title('Description')->rows(5)->type('text')->required(),
                Picture::make('history.image_desc')->title('Image desktop')->acceptedFiles('image/*,application/pdf,.psd')->required(),
                Picture::make('history.image_mob')->title('Image desktop')->acceptedFiles('image/*,application/pdf,.psd')->required(),
            ]),


        ];
    }

    public function createOrUpdate(History $history, Request $request)
    {
        $history->fill($request->get('history'))->save();
        if($history->sortdd == null):
            $history->update([
                'sortdd'=>$history->id
            ]);
            endif;
        Toast::info(__('Successfully saved'));
        return redirect()->route('platform.history.list');
    }
}

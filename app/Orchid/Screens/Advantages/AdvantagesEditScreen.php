<?php

namespace App\Orchid\Screens\Advantages;

use App\Models\Advantages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class AdvantagesEditScreen extends Screen
{ 
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Advantages $advantage): iterable
    {
        return [
            'advantage' => $advantage
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        if (Route::currentRouteName() === 'platform.advantages.create') :
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
                Input::make('advantage.title')->title('Title')->type('text')->required(),
                Input::make('advantage.description')->title('Description')->type('text')->required(),
                Picture::make('advantage.image_desc')->title('Image (desktop)')->required()->acceptedFiles('image/*,application/pdf,.psd'),
                Picture::make('advantage.image_mob')->title('Image (mobile)')->required()->acceptedFiles('image/*,application/pdf,.psd'),
                Input::make('advantage.sort')->title('Sort(Number)')->type('number')->required(),
            ]),
        ];
    }
    public function createOrUpdate(Advantages $advantage, Request $request)
    {
        $advantage->fill($request->get('advantage'))->save();
        if($advantage->sortdd == null):
            $advantage->update([
                'sortdd'=>$advantage->id
            ]);
            endif;
        Toast::info(__('Successfully saved'));
        return redirect()->route('platform.advantages.list');
    }
}

<?php

namespace App\Orchid\Screens\Achievements;

use App\Models\Achievements;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route; 

class AchievementsEditScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Achievements $achievement): iterable
    {
        return [
            'achievement' => $achievement
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        if (Route::currentRouteName() === 'platform.achievements.create') :
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
                Input::make('achievement.number')->title('Number')->type('number')->required(),
                Input::make('achievement.addition')->title('Number text')->type('text')->required(),
                Input::make('achievement.description')->title('Description')->type('text')->required(),
            ]),
        ];
    }


    public function createOrUpdate(Achievements $achievement, Request $request)
    {
        $achievement->fill($request->get('achievement'))->save();
        if($achievement->sortdd == null):
            $achievement->update([
                'sortdd'=>$achievement->id
            ]);
            endif;
        Toast::info(__('Successfully saved'));
        return redirect()->route('platform.achievements.list');
    }
}

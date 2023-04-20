<?php

namespace App\Orchid\Screens\AboutUs;

use App\Models\AboutAchievements;
use App\Models\AboutUs;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class AboutAchievementsCreateScreen extends Screen
{
   /**
     * @var AboutUs
     */
    public $about_us;
    /**
   /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(AboutUs $about_us): iterable
    {
        return [
            'about_us' => $about_us,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null 
     */
    public function name(): ?string
    {
        return 'Create';
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
            ->method('createAboutAchievements'),
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
                Input::make('number')->required()->title('Number'),
                Input::make('addition')->required()->title('Addition'),
                TextArea::make('description')->required()->title('Description')->rows(5),
        ]),

        ];
    }


    public function createAboutAchievements($about_us, Request $request)
    {
        $request->validate([
            'number' => 'required|integer|max:9999',
        ]);
        $about_achievement = [
            'number' => $request['number'],
            'addition' => $request['addition'],
            'description' => $request['description']
        ];
        $about_us = AboutUs::find($about_us);
        $about_us->about_achievement()->create($about_achievement)->save();
        Toast::info(__('Successfully saved'));
        return redirect()->route('platform.about-us.edit', $about_us->id);
    }

}
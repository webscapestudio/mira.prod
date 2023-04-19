<?php

namespace App\Orchid\Screens\AboutUs;

use App\Models\AboutAchievements;
use App\Models\AboutUs;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class AboutAchievementsEditScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(AboutAchievements $about_achievement): iterable
    {
        return [
            'about_achievement' => $about_achievement,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Edit';
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
            ->method('updateAboutAchievements'),
        ];
    }

    /**asdasdasda
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [

            Layout::rows([
                Input::make('about_achievement.number')->required()->title('Title'),
                Input::make('about_achievement.addition')->required()->title('Short Title'),
                Input::make('about_achievement.description')->required()->title('Url'),
                Input::make('about_achievement.id')->type('hidden'),
                         ]),
        ];
    }
    public function updateAboutAchievements($about_achievement_id,$about_us_id,Request $request)
    {
        $about_achievement = AboutAchievements::find($about_achievement_id);
        $data = [
            'number' => $request->about_achievement['number'],
            'addition' => $request->about_achievement['addition'],
            'description' => $request->about_achievement['description']
        ];
        $about_achievement ->update($data);
        Toast::info(__('Successfully saved'));
        return redirect()->route('platform.about-us.edit', [
            'id_about_us'=>$about_us_id
        ]);
    }
}

<?php

namespace App\Orchid\Screens\Achievements;

use App\Models\Achievements;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;

use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Toast; 

class AchievementsScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'achievements' => Achievements::orderBy('sortdd', 'ASC')->filters()->paginate(10)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Achievements';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Add')->icon('plus')->route('platform.achievements.create')
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
            Layout::table('achievements', [
                TD::make('number', "Number")->width('100px')->sort()->filter(TD::FILTER_NUMERIC),
                TD::make('addition', "Addition")->width('120px')->sort(),
                TD::make('description', "Description")->width('grow')->sort(),
                TD::make(__('Actions'))
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(fn (Achievements $achievement) => DropDown::make()
                        ->icon('options-vertical')
                        ->list([

                            Link::make(__('Edit'))
                                ->route('platform.achievements.edit', $achievement->id)
                                ->icon('pencil'),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->confirm(__('Are you sure you want to delete the entry?'))
                                ->method('remove', [
                                    'id' => $achievement->id,
                                ]),
                                Button::make(__('Up'))
                                ->icon('arrow-up')
                                ->method('up_position', [
                                    'id' => $achievement->id,
                                ]),
                            Button::make(__('Down'))
                                ->icon('arrow-down')
                                ->method('down_position', [
                                    'id' => $achievement->id,
                                ]),
                        ])),
            ])
        ];
    }

    public function remove(Request $request): void
    {
        Achievements::findOrFail($request->get('id'))->delete();
        Toast::info(__('Successfully removed'));
    }

    public function up_position($id): void
    {
        $achievement_all = Achievements::orderBy('sortdd', 'ASC')->get();
        $achievement = Achievements::find($id);
        $prev_achievement = Achievements::where('sortdd', '<', $achievement->sortdd)
            ->latest('sortdd')
            ->first();

        if ($achievement_all->first() == $achievement) :
            Toast::error(__('Position is first'));
        else :
            $difference = $achievement->sortdd - $prev_achievement->sortdd;

            $prev_achievement->update(['sortdd'=>$prev_achievement->sortdd + $difference]);
            $achievement->update(['sortdd'=>$achievement->sortdd - $difference]);
            Toast::info(__('Successfully'));
        endif;

    }
    public function down_position($id): void
    {
        $achievement_all = Achievements::orderBy('sortdd', 'ASC')->get();
        $achievement = Achievements::find($id);
        $next_achievement = Achievements::where('sortdd', '>', $achievement->sortdd)
            ->oldest('sortdd')
            ->first();

        if ($achievement_all->last() == $achievement) :
            Toast::error(__('Position is latest'));
        else :
            $difference =$next_achievement->sortdd - $achievement->sortdd;

            $next_achievement->update(['sortdd'=>$next_achievement->sortdd - $difference]);
            $achievement->update(['sortdd'=>$achievement->sortdd + $difference]);
            Toast::info(__('Successfully'));
        endif;
    }
}

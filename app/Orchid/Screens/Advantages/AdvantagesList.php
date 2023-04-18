<?php

namespace App\Orchid\Screens\Advantages;

use App\Models\Advantages;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Actions\DropDown;

class AdvantagesList extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array 
     */
    public function query(): iterable
    {
        return [
            "advantages" => Advantages::orderBy('sortdd', 'ASC')->filters()->paginate(10)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Advantages';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Add')->icon('plus')->route('platform.advantages.create')
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
            Layout::table('advantages', [
                TD::make('image_desc', 'Image')->width('80px')
                    ->render(function ($advantage) {
                        return "<img  class='mw-80 d-block img-fluid rounded-1 w-80' src='$advantage->image_desc' />";
                    }),
                TD::make('title', 'Title')->width('180px')->sort()->filter(TD::FILTER_TEXT),
                TD::make('sort', 'Order')->align(TD::ALIGN_CENTER)->width('100px'),
                TD::make('description', 'Description')->width('grow')->sort(),
                TD::make('created_at', 'Created')->width('160px')->render(function ($date) {
                    return $date->created_at->diffForHumans();
                }),
                TD::make(__('Actions'))
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(fn (Advantages $advantage) => DropDown::make()
                        ->icon('options-vertical')
                        ->list([

                            Link::make(__('Edit'))
                                ->route('platform.advantages.edit', $advantage->id)
                                ->icon('pencil'),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->confirm(__('Are you sure you want to delete the entry?'))
                                ->method('delete', [
                                    'id' => $advantage->id,
                                ]),
                                Button::make(__('Up'))
                                ->icon('arrow-up')
                                ->method('up_position', [
                                    'id' => $advantage->id,
                                ]),
                            Button::make(__('Down'))
                                ->icon('arrow-down')
                                ->method('down_position', [
                                    'id' => $advantage->id,
                                ]),
                        ])),
            ])
        ];
    }

    public function delete(Request $request): void
    {
        Advantages::findOrFail($request->get('id'))->delete();
        Toast::info('Successfully deleted');
    }

    public function up_position($id): void
    {
        $advantage_all = Advantages::orderBy('sortdd', 'ASC')->get();
        $advantage = Advantages::find($id);
        $prev_advantage = Advantages::where('sortdd', '<', $advantage->sortdd)
            ->latest('sortdd')
            ->first();

        if ($advantage_all->first() == $advantage) :
            Toast::error(__('Position is first'));
        else :
            $difference = $advantage->sortdd - $prev_advantage->sortdd;

            $prev_advantage->update(['sortdd'=>$prev_advantage->sortdd + $difference]);
            $advantage->update(['sortdd'=>$advantage->sortdd - $difference]);
            Toast::info(__('Successfully'));
        endif;

    }
    public function down_position($id): void
    {
        $advantage_all = Advantages::orderBy('sortdd', 'ASC')->get();
        $advantage = Advantages::find($id);
        $next_advantage = Advantages::where('sortdd', '>', $advantage->sortdd)
            ->oldest('sortdd')
            ->first();

        if ($advantage_all->last() == $advantage) :
            Toast::error(__('Position is latest'));
        else :
            $difference =$next_advantage->sortdd - $advantage->sortdd;

            $next_advantage->update(['sortdd'=>$next_advantage->sortdd - $difference]);
            $advantage->update(['sortdd'=>$advantage->sortdd + $difference]);
            Toast::info(__('Successfully'));
        endif;
    }
}

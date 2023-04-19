<?php

namespace App\Orchid\Screens\History;

use App\Models\History;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class HistoryListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'history' => History::orderBy('sortdd', 'ASC')->filters()->paginate(10)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'History';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [Link::make('Add')->icon('plus')->route('platform.history.create')];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::table('history', [
                TD::make('image_desc', 'Image')->width('100')
                    ->render(function ($history) {
                        return "<img  class='mw-100 d-block img-fluid rounded-1 w-100' src='$history->image_desc' />";
                    }),
                    TD::make('year', 'Year')->width('180px')->sort(),
                TD::make('title', 'Title')->width('180px')->sort()->filter(TD::FILTER_TEXT),
                TD::make('description', 'Description')->width('grow')->sort(),
                TD::make('created_at', 'Created')->width('160px')->render(function ($date) {
                    return $date->created_at->diffForHumans();
                }),
                TD::make(__('Actions'))->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(fn (History $history) => DropDown::make()
                        ->icon('options-vertical')
                        ->list([

                            Link::make(__('Edit'))
                                ->route('platform.history.edit', $history->id)
                                ->icon('pencil'),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->confirm(__('Are you sure you want to delete the entry?'))
                                ->method('delete', [
                                    'id' => $history->id,
                                ]),
                                Button::make(__('Up'))
                                ->icon('arrow-up')
                                ->method('up_position', [
                                    'id' => $history->id,
                                ]),
                            Button::make(__('Down'))
                                ->icon('arrow-down')
                                ->method('down_position', [
                                    'id' => $history->id,
                                ]),
                        ])),
            ])
        ];
    }

    public function delete(Request $request): void
    {
        History::findOrFail($request->get('id'))->delete();
        Toast::info('Successfully deleted');
    }


    public function up_position($id): void
    {
        $history_all = History::orderBy('sortdd', 'ASC')->get();
        $history = History::find($id);
        $prev_history = History::where('sortdd', '<', $history->sortdd)
            ->latest('sortdd')
            ->first();

        if ($history_all->first() == $history) :
            Toast::error(__('Position is first'));
        else :
            $difference = $history->sortdd - $prev_history->sortdd;

            $prev_history->update(['sortdd'=>$prev_history->sortdd + $difference]);
            $history->update(['sortdd'=>$history->sortdd - $difference]);
            Toast::info(__('Successfully'));
        endif;

    }
    public function down_position($id): void
    {
        $history_all = History::orderBy('sortdd', 'ASC')->get();
        $history = History::find($id);
        $next_history = History::where('sortdd', '>', $history->sortdd)
            ->oldest('sortdd')
            ->first();

        if ($history_all->last() == $history) :
            Toast::error(__('Position is latest'));
        else :
            $difference =$next_history->sortdd - $history->sortdd;

            $next_history->update(['sortdd'=>$next_history->sortdd - $difference]);
            $history->update(['sortdd'=>$history->sortdd + $difference]);
            Toast::info(__('Successfully'));
        endif;
    }
}

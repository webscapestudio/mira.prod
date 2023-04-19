<?php

namespace App\Orchid\Screens\Vacancies;

use App\Models\Vacancies;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class VacanciesListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'vacancies' => Vacancies::orderBy('sortdd', 'ASC')->filters()->paginate(10)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Vacancies';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Add')->icon('plus')->route('platform.vacancies.create')
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
            Layout::table('vacancies', [
                TD::make('image_desc', 'Image')->width('100')
                    ->render(function ($vacancie) {
                        return "<img  class='mw-100 d-block img-fluid rounded-1 w-100' src='$vacancie->image_desc' />";
                    }),
                TD::make('title', 'Title')->sort()->filter(TD::FILTER_TEXT),
                TD::make('created_at', 'Created')->width('160px')->render(function ($date) {
                    return $date->created_at->diffForHumans();
                }),
                TD::make(__('Actions'))
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(fn (Vacancies $vacancie) => DropDown::make()
                        ->icon('options-vertical')
                        ->list([

                            Link::make(__('Edit'))
                                ->route('platform.vacancies.edit', $vacancie->id)
                                ->icon('pencil'),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->confirm(__('Are you sure you want to delete the entry?'))
                                ->method('remove', [
                                    'id' => $vacancie->id,
                                ]),
                                Button::make(__('Up'))
                                ->icon('arrow-up')
                                ->method('up_position', [
                                    'id' => $vacancie->id,
                                ]),
                            Button::make(__('Down'))
                                ->icon('arrow-down')
                                ->method('down_position', [
                                    'id' => $vacancie->id,
                                ]),
                        ])),
            ])
        ];
    }
    public function remove(Request $request): void
    {
        Vacancies::findOrFail($request->get('id'))->delete();
        Toast::info(__('Successfully removed'));
    }
    public function up_position($id): void
    {
        $vacancie_all = Vacancies::orderBy('sortdd', 'ASC')->get();
        $vacancie = Vacancies::find($id);
        $prev_vacancie = Vacancies::where('sortdd', '<', $vacancie->sortdd)
            ->latest('sortdd')
            ->first();

        if ($vacancie_all->first() == $vacancie) :
            Toast::error(__('Position is first'));
        else :
            $difference = $vacancie->sortdd - $prev_vacancie->sortdd;

            $prev_vacancie->update(['sortdd'=>$prev_vacancie->sortdd + $difference]);
            $vacancie->update(['sortdd'=>$vacancie->sortdd - $difference]);
            Toast::info(__('Successfully'));
        endif;

    }
    public function down_position($id): void
    {
        $vacancie_all = Vacancies::orderBy('sortdd', 'ASC')->get();
        $vacancie = Vacancies::find($id);
        $next_vacancie = Vacancies::where('sortdd', '>', $vacancie->sortdd)
            ->oldest('sortdd')
            ->first();

        if ($vacancie_all->last() == $vacancie) :
            Toast::error(__('Position is latest'));
        else :
            $difference =$next_vacancie->sortdd - $vacancie->sortdd;

            $next_vacancie->update(['sortdd'=>$next_vacancie->sortdd - $difference]);
            $vacancie->update(['sortdd'=>$vacancie->sortdd + $difference]);
            Toast::info(__('Successfully'));
        endif;
    }
}

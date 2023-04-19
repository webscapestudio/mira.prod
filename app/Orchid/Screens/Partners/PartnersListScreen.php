<?php

namespace App\Orchid\Screens\Partners;

use App\Models\Partners;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PartnersListScreen extends Screen
{
    /** 
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'partners' => Partners::orderBy('sortdd', 'ASC')->filters()->paginate(10)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Partners';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [Link::make('Add')->icon('plus')->route('platform.partners.create')];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::table('partners', [
                TD::make('logo', 'Logo')->width('100')
                    ->render(function ($partner) {
                        return "<img  class='mw-100 d-block img-fluid rounded-1 w-100' src='$partner->logo' />";
                    }),
                TD::make('title', 'Title')->sort()->filter(TD::FILTER_TEXT),
                TD::make('description', 'Description')->sort(),

                TD::make('created_at', 'Created')->width('160px')->render(function ($date) {
                    return $date->created_at->diffForHumans();
                }),
                TD::make(__('Actions'))
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(fn (Partners $partner) => DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            Link::make(__('Edit'))
                                ->route('platform.partners.edit', $partner->id)
                                ->icon('pencil'),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->confirm(__('Are you sure you want to delete the entry?'))
                                ->method('remove', [
                                    'id' => $partner->id,
                                ]),
                                Button::make(__('Up'))
                                ->icon('arrow-up')
                                ->method('up_position', [
                                    'id' => $partner->id,
                                ]),
                            Button::make(__('Down'))
                                ->icon('arrow-down')
                                ->method('down_position', [
                                    'id' => $partner->id,
                                ]),
                        ])),
            ])
        ];
    }
    public function remove(Request $request): void
    {
        Partners::findOrFail($request->get('id'))->delete();
        Toast::info(__('Successfully removed'));
    }


    public function up_position($id): void
    {
        $partner_all = Partners::orderBy('sortdd', 'ASC')->get();
        $partner = Partners::find($id);
        $prev_partner = Partners::where('sortdd', '<', $partner->sortdd)
            ->latest('sortdd')
            ->first();

        if ($partner_all->first() == $partner) :
            Toast::error(__('Position is first'));
        else :
            $difference = $partner->sortdd - $prev_partner->sortdd;

            $prev_partner->update(['sortdd'=>$prev_partner->sortdd + $difference]);
            $partner->update(['sortdd'=>$partner->sortdd - $difference]);
            Toast::info(__('Successfully'));
        endif;

    }
    public function down_position($id): void
    {
        $partner_all = Partners::orderBy('sortdd', 'ASC')->get();
        $partner = Partners::find($id);
        $next_partner = Partners::where('sortdd', '>', $partner->sortdd)
            ->oldest('sortdd')
            ->first();

        if ($partner_all->last() == $partner) :
            Toast::error(__('Position is latest'));
        else :
            $difference =$next_partner->sortdd - $partner->sortdd;

            $next_partner->update(['sortdd'=>$next_partner->sortdd - $difference]);
            $partner->update(['sortdd'=>$partner->sortdd + $difference]);
            
            Toast::info(__('Successfully'));
        endif;
    }
}

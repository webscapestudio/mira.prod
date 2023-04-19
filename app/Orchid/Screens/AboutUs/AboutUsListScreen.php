<?php

namespace App\Orchid\Screens\AboutUs;

use App\Models\AboutUs;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class AboutUsListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'about_us' => AboutUs::orderBy('sortdd', 'ASC')->filters()->paginate(10)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'About Us';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Add')->icon('plus')->route('platform.about-us.create')
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
            Layout::table('about_us', [
                TD::make('image_desc', 'Image')->width('80px')
                    ->render(function ($about_us) {
                        return "<img  class='mw-80 d-block img-fluid rounded-1 w-80' src='$about_us->image_desc' />";
                    }),
                TD::make('title', 'Title')->width('180px')->sort()->filter(TD::FILTER_TEXT),
                TD::make('description', 'Description')->width('grow')->sort(),
                TD::make('created_at', 'Created')->width('160px')->render(function ($date) {
                    return $date->created_at->diffForHumans();
                }),
                TD::make(__('Actions'))
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(fn (AboutUs $about_us) => DropDown::make()
                        ->icon('options-vertical')
                        ->list([

                            Link::make(__('Edit'))
                                ->route('platform.about-us.edit', [
                                    'id_about_us'=>$about_us->id
                                ])
                                ->icon('pencil'),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->confirm(__('Are you sure you want to delete the entry?'))
                                ->method('delete', [
                                    'id' => $about_us->id,
                                ]),
                                Button::make(__('Up'))
                                ->icon('arrow-up')
                                ->method('up_position', [
                                    'id' => $about_us->id,
                                ]),
                            Button::make(__('Down'))
                                ->icon('arrow-down')
                                ->method('down_position', [
                                    'id' => $about_us->id,
                                ]),
                        ])),
                        ])
        ];
    }

    public function delete(Request $request): void
    {
        foreach(AboutUs::findOrFail($request->get('id'))->about_achievement->all() as $about_achievement):
            $about_achievement->delete();
        endforeach;
        AboutUs::findOrFail($request->get('id'))->delete();
        Toast::info('Successfully deleted');
    }

    public function up_position($id): void
    {
        $about_us_all = AboutUs::orderBy('sortdd', 'ASC')->get();
        $about_us = AboutUs::find($id);
        $prev_about_us = AboutUs::where('sortdd', '<', $about_us->sortdd)
            ->latest('sortdd')
            ->first();

        if ($about_us_all->first() == $about_us) :
            Toast::error(__('Position is first'));
        else :
            $difference = $about_us->sortdd - $prev_about_us->sortdd;

            $prev_about_us->update(['sortdd'=>$prev_about_us->sortdd + $difference]);
            $about_us->update(['sortdd'=>$about_us->sortdd - $difference]);
            Toast::info(__('Successfully'));
        endif;

    }
    public function down_position($id): void
    {
        $about_us_all = AboutUs::orderBy('sortdd', 'ASC')->get();
        $about_us = AboutUs::find($id);
        $next_about_us = AboutUs::where('sortdd', '>', $about_us->sortdd)
            ->oldest('sortdd')
            ->first();

        if ($about_us_all->last() == $about_us) :
            Toast::error(__('Position is latest'));
        else :
            $difference =$next_about_us->sortdd - $about_us->sortdd;

            $next_about_us->update(['sortdd'=>$next_about_us->sortdd - $difference]);
            $about_us->update(['sortdd'=>$about_us->sortdd + $difference]);
            Toast::info(__('Successfully'));
        endif;
    }
}

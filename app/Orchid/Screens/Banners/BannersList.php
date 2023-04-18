<?php

namespace App\Orchid\Screens\Banners;

use App\Models\Banners;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Illuminate\Http\Request;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class BannersList extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */ 
    public function query(): iterable
    {
        return ['banners' => Banners::orderBy('sortdd', 'ASC')->filters()->paginate(10)];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string 
    {
        return 'Banners';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Add banner')->icon('plus')->route('platform.banners.create')
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
            Layout::table('banners', [
                TD::make('image_desc', 'Banner')->width('100')
                    ->render(function ($banner) {
                        return "<img  class='mw-100 d-block img-fluid rounded-1 w-100' src='$banner->image_desc' />";
                    }),
                TD::make('title_first', 'Title first')->sort()->filter(TD::FILTER_TEXT),
                TD::make('title_second', 'Title second')->sort(),
                TD::make('created_at', 'Created')->width('160px')->render(function ($date) {
                    return $date->created_at->diffForHumans();
                }),
                TD::make(__('Actions'))
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(fn (Banners $banner) => DropDown::make()
                        ->icon('options-vertical')
                        ->list([

                            Link::make(__('Edit'))
                                ->route('platform.banners.edit', $banner->id)
                                ->icon('pencil'),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->confirm(__('Are you sure you want to delete the entry?'))
                                ->method('remove', [
                                    'id' => $banner->id,
                                ]),
                                Button::make(__('Up'))
                                ->icon('arrow-up')
                                ->method('up_position', [
                                    'id' => $banner->id,
                                ]),
                            Button::make(__('Down'))
                                ->icon('arrow-down')
                                ->method('down_position', [
                                    'id' => $banner->id,
                                ]),
                        ])),
            ])
        ];
    }
    public function remove(Request $request): void
    {
        Banners::findOrFail($request->get('id'))->delete();
        Toast::info(__('Successfully removed'));
    }

    public function up_position($id): void
    {
        $banner_all = Banners::orderBy('sortdd', 'ASC')->get();
        $banner = Banners::find($id);
        $prev_banner = Banners::where('sortdd', '<', $banner->sortdd)
            ->latest('sortdd')
            ->first();

        if ($banner_all->first() == $banner) :
            Toast::error(__('Position is first'));
        else :
            $difference = $banner->sortdd - $prev_banner->sortdd;

            $prev_banner->update(['sortdd'=>$prev_banner->sortdd + $difference]);
            $banner->update(['sortdd'=>$banner->sortdd - $difference]);
            Toast::info(__('Successfully'));
        endif;

    }
    public function down_position($id): void
    {
        $banner_all = Banners::orderBy('sortdd', 'ASC')->get();
        $banner = Banners::find($id);
        $next_banner = Banners::where('sortdd', '>', $banner->sortdd)
            ->oldest('sortdd')
            ->first();

        if ($banner_all->last() == $banner) :
            Toast::error(__('Position is latest'));
        else :
            $difference =$next_banner->sortdd - $banner->sortdd;

            $next_banner->update(['sortdd'=>$next_banner->sortdd - $difference]);
            $banner->update(['sortdd'=>$banner->sortdd + $difference]);
            Toast::info(__('Successfully'));
        endif;
    }
}

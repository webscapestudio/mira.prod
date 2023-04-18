<?php

namespace App\Orchid\Screens\News;

use App\Models\News;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class NewsListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'news' => News::orderBy('sortdd', 'ASC')->filters()->paginate(10)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'News';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Add')->icon('plus')->route('platform.news.create')
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
            Layout::table('news', [

                TD::make('image_desc', 'Image')->width('100')
                    ->render(function ($new) {
                        return "<img  class='mw-100 d-block img-fluid rounded-1 w-100' src='$new->image_desc' />";
                    }),
                TD::make('title', 'Title')->sort()->filter(TD::FILTER_TEXT),
                TD::make('created_at', 'Created')->width('160px')->render(function ($date) {
                    return $date->created_at->diffForHumans();
                }),
                TD::make(__('Actions'))
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(fn (News $new) => DropDown::make()
                        ->icon('options-vertical')
                        ->list([

                            Link::make(__('Edit'))
                                ->route('platform.news.edit', $new->id)
                                ->icon('pencil'),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->confirm(__('Are you sure you want to delete the entry?'))
                                ->method('remove', [
                                    'id' => $new->id,
                                ]),
                            Button::make(__('Up'))
                                ->icon('arrow-up')
                                ->method('up_position', [
                                    'id' => $new->id,
                                ]),
                            Button::make(__('Down'))
                                ->icon('arrow-down')
                                ->method('down_position', [
                                    'id' => $new->id,
                                ]),
                        ])),
            ])
        ];
    }
    public function remove(Request $request): void
    {
        News::findOrFail($request->get('id'))->delete();
        Toast::info(__('Successfully removed'));
    }
    public function up_position($id): void
    {
        $news_all = News::orderBy('sortdd', 'ASC')->get();
        $news = News::find($id);
        $prev_news = News::where('sortdd', '<', $news->sortdd)
            ->latest('sortdd')
            ->first();

        if ($news_all->first() == $news) :
            Toast::error(__('Position is first'));
        else :
            $difference = $news->sortdd - $prev_news->sortdd;

            $prev_news->update(['sortdd'=>$prev_news->sortdd + $difference]);
            $news->update(['sortdd'=>$news->sortdd - $difference]);
            Toast::info(__('Successfully'));
        endif;

    }
    public function down_position($id): void
    {
        $news_all = News::orderBy('sortdd', 'ASC')->get();
        $news = News::find($id);
        $next_news = News::where('sortdd', '>', $news->sortdd)
            ->oldest('sortdd')
            ->first();

        if ($news_all->last() == $news) :
            Toast::error(__('Position is latest'));
        else :
            $difference =$next_news->sortdd - $news->sortdd;

            $next_news->update(['sortdd'=>$next_news->sortdd - $difference]);
            $news->update(['sortdd'=>$news->sortdd + $difference]);
            Toast::info(__('Successfully'));
        endif;
    }
}

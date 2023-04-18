<?php

namespace App\Orchid\Screens\Gallery;

use Illuminate\Http\Request;
use Orchid\Attachment\Models\Attachment;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Toast;

class GalleryListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'attachments' => Attachment::filters()->paginate(10)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Gallery';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::table('attachments', [
                TD::make('path', 'Image')->width('100')
                    ->render(function ($attachment) {
                        return "<img  class='mw-100 d-block img-fluid rounded-1 w-100' src='/storage/$attachment->path$attachment->name.$attachment->extension' />";
                    }),
                TD::make('original_name', 'Name')->width('grow')
                    ->render(function ($attachment) {
                        return "$attachment->original_name";
                    })->sort()->filter(TD::FILTER_TEXT),

                TD::make('created_at', 'Uploaded')->width('160px')->render(function ($date) {
                    return $date->created_at->diffForHumans();
                }),
                TD::make(('Actions'))
                    // ->align(TD::ALIGN_RIGHT)
                    ->width('100px')
                    ->render(fn (Attachment $attachment) => DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            Button::make(('Delete'))
                                ->icon('trash')
                                ->confirm(__('Are you sure you want to delete the entry?'))
                                ->method('remove', [
                                    'id' => $attachment->id,
                                ]),
                        ])),
            ])
        ];
    }
    public function remove(Request $request): void
    {
        Attachment::findOrFail($request->get('id'))->delete();
        Toast::info(__('Successfully removed'));
    }
}

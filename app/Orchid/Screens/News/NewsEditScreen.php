<?php

namespace App\Orchid\Screens\News;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class NewsEditScreen extends Screen
{
    /** 
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(News $new): iterable
    {
        return [
            'new' => $new
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        if (Route::currentRouteName() === 'platform.news.create') :
            return 'Create';
        else :
            return 'Edit';
        endif;
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
            ->method('createOrUpdate'),
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
            Layout::rows([
                Input::make('new.title')->title('Title')->type('text')->required(),
                Quill::make('new.content')->title('Content')->required(),
                Picture::make('new.image_desc')->title('Image')->required()->acceptedFiles('image/*,application/pdf,.psd'),
            ])
        ];
    }
    public function createOrUpdate(News $new, Request $request)
    {
        $new->fill($request->get('new'))->save();
        if($new->sortdd == null):
        $new->update([
            'sortdd'=>$new->id
        ]);
        endif;
        Toast::info(__('Successfully saved'));
        return redirect()->route('platform.news.list');
    }
}

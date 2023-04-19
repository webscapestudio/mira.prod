<?php

namespace App\Orchid\Screens\Manifesto;

use App\Models\Manifesto;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ManifestoEditScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Manifesto $manifesto): iterable
    {
        return [
            'manifesto' => $manifesto
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Manifesto';
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
                Input::make('manifesto.title')->title('Title')->type('text')->required(),
                TextArea::make('manifesto.description')->title('Description')->type('text')->required(),
                Input::make('manifesto.image_desc_title')->title('Desktop image title')->type('text')->required(),
                Picture::make('manifesto.image_desc')->title('Image desktop')->acceptedFiles('image/*,application/pdf,.psd')->required(),
                Input::make('manifesto.image_mob_title')->title('Mobile image title')->type('text')->required(),
                Picture::make('manifesto.image_mob')->title('Image mobile')->acceptedFiles('image/*,application/pdf,.psd')->required(),
            ]),
        ];
    }
    public function createOrUpdate(Manifesto $manifesto, Request $request)
    {
        $manifesto->fill($request->get('manifesto'))->save();
        Toast::info(__('Successfully saved'));
        return redirect()->route('platform.manifestos.edit','1');
    }
}

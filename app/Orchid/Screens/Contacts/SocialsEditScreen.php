<?php

namespace App\Orchid\Screens\Contacts;

use App\Models\Contacts;
use App\Models\Social;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class SocialsEditScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Social $social): iterable
    {
        return [
            'social' => $social,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Edit';
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
            ->method('updateSocial'),
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
                Input::make('social.title')->required()->title('Title'),
                Input::make('social.short_title')->required()->title('Short Title'),
                Input::make('social.url')->required()->title('Url'),
        ])->title('Edit Social'),
        ];
    }
    public function updateSocial($social_id, Request $request)
    {
        $social = Social::find($social_id);
        $data = [
            'title' => $request->social['title'],
            'short_title' => $request->social['short_title'],
            'url' => $request->social['url']
        ];
        $social->update($data);
        return redirect()->route('platform.contacts.edit','1');
        Toast::info(__('Successfully saved'));
    }
}

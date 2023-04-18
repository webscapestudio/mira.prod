<?php

namespace App\Orchid\Screens\Partners;

use App\Models\Partners;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PartnersEditScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Partners $partner): iterable
    {
        return [
            'partner' => $partner
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        if (Route::currentRouteName() === 'platform.partners.create') :
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
        return [Button::make(__('Save'))
            ->icon('check')
            ->method('createOrUpdate'),];
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
                Input::make('partner.title')
                    ->title('Title')
                    ->type('text')
                    ->required(),
                TextArea::make('partner.description')->title('Description')->required(),
                Picture::make('partner.logo')->title('Logo')->required()->acceptedFiles('image/*,application/pdf,.psd'),
                Upload::make('partner.attachment')->title('Photo')->required()->acceptedFiles('image/*,application/pdf,.psd'),
            ])
        ];
    }

    public function createOrUpdate(Partners $partner, Request $request)
    {
        $partner->fill($request->get('partner'))->save();
    
        $partner->attachment()->syncWithoutDetaching(
            $request->input('partner.attachment', [])
        );
        if($partner->sortdd == null):
            $partner->update([
                'sortdd'=>$partner->id
            ]);
            endif;
    
        Toast::info(__('Successfully saved'));
        return redirect()->route('platform.partners.list');
    }
}

<?php

namespace App\Orchid\Screens\Banners;

use App\Models\Banners;
use App\Models\User;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class BannersEdit extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Banners $banner): iterable
    {
        return [
            'banner' => $banner
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        if (Route::currentRouteName() === 'platform.banners.create') :
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
                Input::make('banner.title_first')
                    ->title('Title first')
                    ->type('text')
                    ->required(),
                Input::make('banner.title_second')->title('Title second')->type('text')->required(),
                Picture::make('banner.image_desc')->title('Image (desktop)')->required()->acceptedFiles('image/*,application/pdf,.psd'),
                Picture::make('banner.image_mob')->title('Image (mobile)')->required()->acceptedFiles('image/*,application/pdf,.psd'),
                Input::make('banner.project')
                ->title('Project') 
                ->type('text')
                ->required(),
            ])
        ];
    }

    public function createOrUpdate(Banners $banner, Request $request)
    {
        $banner->fill($request->get('banner'))->save();
        if($banner->sortdd == null):
            $banner->update([
                'sortdd'=>$banner->id
            ]);
            endif;
        Toast::info(__('Successfully saved'));
        return redirect()->route('platform.banners.list');
    }
}

<?php

namespace App\Orchid\Screens\AboutUs;

use App\Models\AboutAchievements;
use App\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class AboutUsEditScreen extends Screen
{
    /**
     * @var AboutUs
     */
    public $about_us;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(AboutUs $about_us): iterable
    {
        return [
            'about_us' => $about_us,
            'about_achievements' => AboutAchievements::where('about_achievementable_id',  $about_us->id)->filters()->paginate(10),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        if (Route::currentRouteName() === 'platform.about-us.create') :
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
        if (Route::currentRouteName() === 'platform.about-us.create') :
            return [
                Button::make(__('Save'))
                    ->icon('check')
                    ->method('createOrUpdate'),
            ];
        else :
            return [
                Link::make(__('Add new Achievement'))
                    ->icon('check')
                    ->route('platform.about_achievements.create', $this->about_us->id),

                Button::make(__('Save'))
                    ->icon('check')
                    ->method('createOrUpdate'),
            ];
        endif;
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
                Input::make('about_us.title')->title('Title')->type('text')->required(),
                TextArea::make('about_us.description')->title('Description')->type('text')->required(),
                Select::make('about_us.text_size')
                    ->options([
                        'big'   => 'Big',
                        'small' => 'Small',
                    ])->title('Text size')->required(),
                Picture::make('about_us.image_desc')->title('Image desktop')->acceptedFiles('image/*,application/pdf,.psd')->required(),
                Picture::make('about_us.image_mob')->title('Image mobile')->acceptedFiles('image/*,application/pdf,.psd')->required(),
            ]),

            Layout::table('about_achievements', [
                TD::make('number', 'Number')->width('180px')->sort()->filter(TD::FILTER_NUMERIC),
                TD::make('addition', 'Addition')->width('grow')->sort(),
                TD::make('description', 'Description')->width('grow')->sort(),
                TD::make('created_at', 'Created')->width('160px')->render(function ($date) {
                    return $date->created_at->diffForHumans();
                }),

                TD::make(__('Actions'))
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(fn (AboutAchievements $about_achievement) => DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            Link::make(__('Edit'))
                                ->icon('pencil')
                                ->route('platform.about_achievements.edit', [
                                    'id_about_us' =>$this->about_us->id,
                                    'id' => $about_achievement->id
                                ]),
                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->confirm(__('Are you sure you want to delete the entry?'))
                                ->method('deleteAchievement', [
                                    'id' => $about_achievement->id,
                                ]),
                        ])),
            ]),
        ];
    }

    public function deleteAchievement(Request $request): void
    {
        AboutAchievements::findOrFail($request->get('id'))->delete();
        Toast::info('Successfully deleted');
    }
    public function createOrUpdate(AboutUs $about_us, Request $request)
    {
        $about_us->fill($request->get('about_us'))->save();
        if($about_us->sortdd == null):
            $about_us->update([
                'sortdd'=>$about_us->id
            ]);
            endif;
        Toast::info(__('Successfully saved'));
        return redirect()->route('platform.about-us.list');
    }
    
}

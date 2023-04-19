<?php

namespace App\Orchid\Screens\Contacts;

use App\Models\Contacts;
use App\Models\Social;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ContactsEditScreen extends Screen
{

   /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Contacts $contact): iterable
    {
       
        return [
            'contact' => $contact,
            'socials' => Social::filters()->paginate(10),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null 
     */
    public function name(): ?string
    {
        return 'Contacts';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Add new Social Media'))
            ->icon('check')
            ->route('platform.social.create'),
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
                Input::make('contact.address')->title('Address')->type('text')->required(),
                Input::make('contact.email')->title('Email')->type('text')->required(),
                Input::make('contact.phone')->title('Phone')->type('text')->required()
            ]),
            Layout::table('socials', [
                TD::make('title', 'title')->width('180px')->sort()->filter(TD::FILTER_TEXT),
                TD::make('short_title', 'short_title')->width('grow')->sort(),
                TD::make('url', 'url')->width('grow')->sort(),
                TD::make('created_at', 'Created')->width('160px')->render(function ($date) {
                    return $date->created_at->diffForHumans();
                }),
                TD::make(__('Actions'))
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(fn (Social $social) => DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            Link::make(__('Edit'))
                            ->icon('pencil')
                            ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                            ->route('platform.social.edit', [
                                'id' => $social->id,
                            ]),
                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                                ->method('deleteSocial', [
                                    'id' => $social->id,
                                ]),
                        ])),
                    ]),

        ];
    }

    public function deleteSocial(Request $request): void
    {
        Social::findOrFail($request->get('id'))->delete();
        Toast::info('Successfully deleted');
    }
    public function createOrUpdate(Contacts $contact, Request $request)
    { 
        $contact->fill($request->get('contact'))->save();
        Toast::info(__('Successfully saved'));
        return redirect()->back();
      
    }
        
}

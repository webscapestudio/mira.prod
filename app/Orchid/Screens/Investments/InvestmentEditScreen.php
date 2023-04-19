<?php

namespace App\Orchid\Screens\Investments;

use App\Models\Investment;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class InvestmentEditScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Investment $investment): iterable
    {
        return [
            'investment' => $investment
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Investment';
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
            ->method('update'),
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
                Input::make('investment.title')->title('Title')->type('text')->required(),
                TextArea::make('investment.description')->title('Description')->type('text')->required(),
                Picture::make('investment.image_desc')->title('Image')->acceptedFiles('image/*,application/pdf,.psd')->required(),
            ]),
        ];
    }
    public function update(Investment $investment, Request $request)
    {
        $investment->fill($request->get('investment'))->update();
        Toast::info(__('Successfully saved'));
        return redirect()->back();
    }
}

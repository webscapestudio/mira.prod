<?php

namespace App\Orchid\Screens\Investments\Strategies;

use App\Models\Investment;
use App\Models\InvestStrategies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class StrategiesEditScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(InvestStrategies $invest_strategie): iterable
    {
        return [
            'invest_strategie' => $invest_strategie,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        if (Route::currentRouteName() === 'platform.invest_strategies.create') :
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
                Input::make('invest_strategie.title')->required()->title('Title'),
                Input::make('invest_strategie.description')->required()->title('Description'),
        ])->title('Сreate Strategy'),
        ];
    }
    public function createOrUpdate(InvestStrategies $invest_strategie, Request $request)
    {
        $data = [
            'title' => $request->invest_strategie['title'],
            'description' => $request->invest_strategie['description'],
        ];
        $investment = Investment::find('1');
        if(!$invest_strategie->id == null):
        $investment->invest_strategie()->where('id', $invest_strategie->id)->update($data);
        else:
            $investment->invest_strategie()->create($data)->save();
        endif;
        Toast::info(__('Successfully saved'));
        return redirect()->route('platform.invest_strategies.list');
    }
}

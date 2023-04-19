<?php

namespace App\Orchid\Screens\Investments\Advantages;

use App\Models\InvestAdvantages;
use App\Models\Investment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class AdvantagesEditScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(InvestAdvantages $invest_advantage): iterable
    {
        return [
            'invest_advantage' => $invest_advantage,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        if (Route::currentRouteName() === 'platform.invest_advantages.create') :
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
                Input::make('invest_advantage.title')->required()->title('Title'),
                Input::make('invest_advantage.description')->required()->title('Description'),
        ])->title('Сreate Advantage'),
        ]; 
    }
    public function createOrUpdate(InvestAdvantages $invest_advantage, Request $request)
    {
        $data = [
            'title' => $request->invest_advantage['title'],
            'description' => $request->invest_advantage['description'],
        ];
        $investment = Investment::find('1');
        if(!$invest_advantage->id == null):
        $investment->invest_advantage()->where('id', $invest_advantage->id)->update($data);
        else:
            $investment->invest_advantage()->create($data)->save();
        endif;
        Toast::info(__('Successfully saved'));
        return redirect()->route('platform.invest_advantages.list');
    }
}

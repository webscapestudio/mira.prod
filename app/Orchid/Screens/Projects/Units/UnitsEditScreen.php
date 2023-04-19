<?php

namespace App\Orchid\Screens\Projects\Units;

use App\Models\ProjectUnit;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class UnitsEditScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(ProjectUnit $project_unit): iterable
    {
        return [
            'project_unit' => $project_unit,
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
            ->method('updateProjectUnit'),
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
                Input::make('project_unit.address')->title('Address')->type('text'),
                Select::make('project_unit.type')
                        ->options([
                                'studio'   => 'Studio',
                                'apartment' => 'Apartment',
                                'villa'   => 'Villa',
                                'townhouse' => 'Townhouse',
                                'penthouse'   => 'Penthouse',
                                'duplex' => 'Duplex'
                        ])
                        ->title('Select Type'),
                Input::make('project_unit.series')->title('Series')->type('text'),
                Input::make('project_unit.price')->title('Price')->type('number')->required(),
                Input::make('project_unit.area')->title('Area')->type('text')->required(),
                Input::make('project_unit.bedrooms_quantity')->title('bedrooms(quantity)')->type('text'),
                Input::make('project_unit.bathrooms_quantity')->title('bathrooms(quantity)')->type('text')->required(),
                Input::make('project_unit.floor')->title('Floor')->type('number'),
                Input::make('project_unit.view')->title('Area')->type('text'),
                Upload::make('project_unit.attachment')->title('Pictures')->required()->acceptedFiles('image/*,application/pdf,.psd'),
        ]),
        ];
    }
    public function updateProjectUnit($project_unit_id,$id_project,Request $request)
    {
        $project_unit = ProjectUnit::find($project_unit_id);
        $data = [
            'address' => $request->project_unit['address'],
            'type' => $request->project_unit['type'],
            'series' => $request->project_unit['series'],
            'price' => $request->project_unit['price'],
            'area' => $request->project_unit['area'],
            'bedrooms_quantity' => $request->project_unit['bedrooms_quantity'],
            'bathrooms_quantity' => $request->project_unit['bathrooms_quantity'],
            'floor' => $request->project_unit['floor'],
            'view' => $request->project_unit['view']
        ];

        $project_unit ->update($data);
        $project_unit->attachment()->syncWithoutDetaching(
            $request->input('project_unit.attachment', [])
        );
        Toast::info(__('Successfully saved'));
        return redirect()->route('platform.project.edit', [
            'id_project'=>$id_project
        ]);
    }
}

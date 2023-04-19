<?php

namespace App\Orchid\Screens\Projects\Units;

use App\Models\Project;
use App\Models\ProjectUnit;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class UnitsCreateScreen extends Screen
{
               /**
     * @var AboutUs
     */
    public $project;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Project $project): iterable
    {
        return [
            'project' => $project,
        ];
    }  

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Create';
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
            ->method('createProjectUnit'),
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
                Input::make('address')->title('Address')->type('text'),
                Select::make('type')
                        ->options([
                                'studio'   => 'Studio',
                                'apartment' => 'Apartment',
                                'villa'   => 'Villa',
                                'townhouse' => 'Townhouse',
                                'penthouse'   => 'Penthouse',
                                'duplex' => 'Duplex'
                        ])
                        ->title('Select Type'),
                Input::make('series')->title('Series')->type('text'),
                Input::make('price')->title('Price')->type('number')->required(),
                Input::make('area')->title('Area')->type('text')->required(),
                Input::make('bedrooms_quantity')->title('bedrooms(quantity)')->type('text'),
                Input::make('bathrooms_quantity')->title('bathrooms(quantity)')->type('text')->required(),
                Input::make('floor')->title('Floor')->type('number'),
                Input::make('view')->title('Area')->type('text'),
                Upload::make('attachment')->title('Pictures')->required()->acceptedFiles('image/*,application/pdf,.psd'),
        ]),
        ];
    }

    public function createProjectUnit($project, Request $request)
    {

        $data = [
            'address' => $request['address'],
            'type' => $request['type'],
            'series' => $request['series'],
            'price' => $request['price'],
            'area' => $request['area'],
            'bedrooms_quantity' => $request['bedrooms_quantity'],
            'bathrooms_quantity' => $request['bathrooms_quantity'],
            'floor' => $request['floor'],
            'view' => $request['view']
        ];
        $project = Project::find($project);
        if($project->project_units()->create($data)->save() == true):
        ProjectUnit::orderby('id', 'desc')->first()->attachment()->syncWithoutDetaching(
            $request->input('attachment', [])
        );
        endif;
        $project_unit = ProjectUnit::orderby('id', 'desc')->first();
        if ($project_unit->sortdd == null) :
            $project_unit->update([
                'sortdd' => $project_unit->id
            ]);
        endif;
        Toast::info(__('Successfully saved'));
        return redirect()->route('platform.project.edit', $project->id);
    }
}

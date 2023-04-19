<?php

namespace App\Orchid\Screens\Projects\Advantages;

use App\Models\ProjectAdvantage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
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
    public function query(ProjectAdvantage $project_advantage): iterable
    {
        return [
            'project_advantage' => $project_advantage,
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
            ->method('updateProjectAdvantage'),
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
                Input::make('project_advantage.title')->required()->title('Title'),
                Input::make('project_advantage.description')->required()->title('Description'),
                Picture::make('project_advantage.image_pa')->required()->title('Image')->acceptedFiles('image/*,application/pdf,.psd'),
                         ]),
        ];
    }
    public function updateProjectAdvantage($project_advantage_id,$id_project,Request $request)
    {
        $project_advantage = ProjectAdvantage::find($project_advantage_id);
        $data = [
            'title' => $request->project_advantage['title'],
            'description' => $request->project_advantage['description'],
            'image_pa' => $request->project_advantage['image_pa']
        ];

        $project_advantage ->update($data);
        Toast::info(__('Successfully saved'));
        return redirect()->route('platform.project.edit', [
            'id_project'=>$id_project
        ]);
    }
}

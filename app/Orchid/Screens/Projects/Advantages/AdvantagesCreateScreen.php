<?php

namespace App\Orchid\Screens\Projects\Advantages;

use App\Models\Project;
use App\Models\ProjectAdvantage;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class AdvantagesCreateScreen extends Screen
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
            ->method('createProjectAdvantage'),
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
                Input::make('title')->required()->title('Title'),
                TextArea::make('description')->required()->title('Description'),
                Picture::make('image_pa')->title('Image')->acceptedFiles('image/*,application/pdf,.psd'),
        ]),
        ];
    }
    public function createProjectAdvantage($project, Request $request)
    {

        $project_advantage = [
            'title' => $request['title'],
            'description' => $request['description'],
            'image_pa' => $request['image_pa']
        ];
        $project = Project::find($project);
        $project->project_advantages()->create($project_advantage)->save();
        Toast::info(__('Successfully saved'));
        return redirect()->route('platform.project.edit', $project->id);
    }
}

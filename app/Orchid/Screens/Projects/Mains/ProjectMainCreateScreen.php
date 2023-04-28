<?php

namespace App\Orchid\Screens\Projects\Mains;

use Orchid\Screen\Screen;
use App\Models\ProjectMain;
use App\Models\Project;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ProjectMainCreateScreen extends Screen
{
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
            ->method('createProjectMain'),
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
                Input::make('title_main')->title('Title')->type('text')->required(),
                TextArea::make('description_main')->title('Description')->required()->rows(5),
            ]),
        ];
    }
    public function createProjectMain($project, Request $request)
    {

        $data = [
            'title_main' => $request['title_main'],
            'description_main' => $request['description_main'],
        ];
        $project = Project::find($project);
        $project->project_mains()->create($data)->save();
        $project_main = ProjectMain::orderby('id', 'desc')->first();
        if ($project_main->sortdd == null) :
            $project_main->update([
                'sortdd' => $project_main->id
            ]);
        endif;
        Toast::info(__('Successfully saved'));
        return redirect()->route('platform.project.edit', $project->id);
    }
}

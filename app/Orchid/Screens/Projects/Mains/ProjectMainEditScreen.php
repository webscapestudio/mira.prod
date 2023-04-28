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
class ProjectMainEditScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query( ProjectMain $project_main): iterable
    {
        return [
            'project_main' => $project_main,
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
            ->method('updateProjectMain'),
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
                    Input::make('project_main.title_main')->title('Title')->type('text')->required(),
                    TextArea::make('project_main.description_main')->title('Description')->required()->rows(5),
                ]),

        ];
    }
    public function updateProjectMain($project_main_id,$id_project,Request $request)
    {
        $project_main = ProjectMain::find($project_main_id);
        $data = [
            'title_main' => $request->project_main['title_main'],
            'description_main' => $request->project_main['description_main'],
        ];

        $project_main ->update($data);
        Toast::info(__('Successfully saved'));
        return redirect()->route('platform.project.edit', [
            'id_project'=>$id_project
        ]);
    }
}


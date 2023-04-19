<?php

namespace App\Orchid\Screens\Projects\ProgressPoints;

use App\Models\Project;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PointCreateScreen extends Screen
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
            ->method('createProgressPoint'),
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
                Input::make('date')->title('Date')->type('date')->required(),
                Input::make('title')->required()->title('Title'),
                TextArea::make('description')->required()->title('Description'),
                Picture::make('image_preview')->required()->title('Image Preview')->acceptedFiles('image/*,application/pdf,.psd'),
                Picture::make('image_main')->title('Image Main')->acceptedFiles('image/*,application/pdf,.psd'),
                Input::make('video')->title('Video(Id)'),
                TextArea::make('media_description')->title('Description Media'),
        ]),
        ];
    }
    public function createProgressPoint($project, Request $request)
    {

        $project_progress_points = [
            'date' => $request['date'],
            'title' => $request['title'],
            'description' => $request['description'],
            'image_preview' => $request['image_preview'],
            'image_main' => $request['image_main'],
            'video' => $request['video'],
            'media_description' => $request['media_description'],

        ];
        $project = Project::find($project);
        $project->project_progress_points()->create($project_progress_points)->save();
        Toast::info(__('Successfully saved'));
        return redirect()->route('platform.project.edit', $project->id);
    }
}

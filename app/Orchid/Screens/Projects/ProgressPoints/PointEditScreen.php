<?php

namespace App\Orchid\Screens\Projects\ProgressPoints;

use App\Models\ProjectProgressPoint;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PointEditScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(ProjectProgressPoint $project_progress_point): iterable
    {
        return [
            'project_progress_point' => $project_progress_point,
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
            ->method('updateProgressPoint'),
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
            Input::make('project_progress_point.date')->title('Date')->type('date')->required(),
            Input::make('project_progress_point.title')->required()->title('Title'),
            TextArea::make('project_progress_point.description')->required()->title('Description'),
            Picture::make('project_progress_point.image_preview')->required()->title('Image Preview')->acceptedFiles('image/*,application/pdf,.psd'),
            Picture::make('project_progress_point.image_main')->title('Image Main')->acceptedFiles('image/*,application/pdf,.psd'),
            Input::make('project_progress_point.video')->title('Video(Id)'),
            TextArea::make('project_progress_point.media_description')->title('Description Media'),
        ]),
        ];
    }
    public function updateProgressPoint($project_progress_point_id,$id_project,Request $request)
    {
        $project_progress_point = ProjectProgressPoint::find($project_progress_point_id);
        $data = [
            'date' => $request->project_progress_point['date'],
            'title' => $request->project_progress_point['title'],
            'description' => $request->project_progress_point['description'],
            'image_preview' => $request->project_progress_point['image_preview'],
            'image_main' => $request->project_progress_point['image_main'],
            'video' => $request->project_progress_point['video'],
            'media_description' => $request->project_progress_point['media_description']
        ];

        $project_progress_point ->update($data);
        Toast::info(__('Successfully saved'));
        return redirect()->route('platform.project.edit', [
            'id_project'=>$id_project
        ]);
    }
}

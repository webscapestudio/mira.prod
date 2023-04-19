<?php

namespace App\Orchid\Screens\Projects;

use App\Models\Project;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ProjectsListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'projects' => Project::orderBy('sortdd', 'ASC')->filters()->paginate(10)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Projects';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Add')->icon('plus')->route('platform.project.create')
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
            Layout::table('projects', [

                TD::make('image_desc', 'Image')->width('100')
                    ->render(function ($project) {
                        return "<img  class='mw-100 d-block img-fluid rounded-1 w-100' src='$project->image_main' />";
                    }),
                TD::make('title_first', 'Title')->sort()->filter(TD::FILTER_TEXT),
                TD::make('title_second', 'Title')->sort()->filter(TD::FILTER_TEXT),
                TD::make('created_at', 'Created')->width('160px')->render(function ($date) {
                    return $date->created_at->diffForHumans();
                }),
                TD::make(__('Actions'))
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(fn (Project $project) => DropDown::make()
                        ->icon('options-vertical')
                        ->list([

                            Link::make(__('Edit'))
                                ->route('platform.project.edit', $project->id)
                                ->icon('pencil'),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->confirm(__('Are you sure you want to delete the entry?'))
                                ->method('remove', [
                                    'id' => $project->id,
                                ]),
                            Button::make(__('Up'))
                                ->icon('arrow-up')
                                ->method('up_position', [
                                    'id' => $project->id,
                                ]),
                            Button::make(__('Down'))
                                ->icon('arrow-down')
                                ->method('down_position', [
                                    'id' => $project->id,
                                ]),
                        ])),
            ])
        ];
    }
    public function remove(Request $request): void
    {
        foreach(Project::findOrFail($request->get('id'))->project_advantages->all() as $advantage):
            $advantage->delete();
        endforeach;
        foreach(Project::findOrFail($request->get('id'))->project_progress_points->all() as $point):
            $point->delete();
        endforeach;
        foreach(Project::findOrFail($request->get('id'))->project_units->all() as $unit):
            $unit->delete();
        endforeach;
        Project::findOrFail($request->get('id'))->delete();
        Toast::info(__('Successfully removed'));
    }
    public function up_position($id): void
    {
        $project_all = Project::orderBy('sortdd', 'ASC')->get();
        $project = Project::find($id);
        $prev_project = Project::where('sortdd', '<', $project->sortdd)
            ->latest('sortdd')
            ->first();

        if ($project_all->first() == $project) :
            Toast::error(__('Position is first'));
        else :
            $difference = $project->sortdd - $prev_project->sortdd;

            $prev_project->update(['sortdd'=>$prev_project->sortdd + $difference]);
            $project->update(['sortdd'=>$project->sortdd - $difference]);
            Toast::info(__('Successfully'));
        endif;

    }
    public function down_position($id): void
    {
        $project_all = Project::orderBy('sortdd', 'ASC')->get();
        $project = Project::find($id);
        $next_project = Project::where('sortdd', '>', $project->sortdd)
            ->oldest('sortdd')
            ->first();

        if ($project_all->last() == $project) :
            Toast::error(__('Position is latest'));
        else :
            $difference =$next_project->sortdd - $project->sortdd;

            $next_project->update(['sortdd'=>$next_project->sortdd - $difference]);
            $project->update(['sortdd'=>$project->sortdd + $difference]);
            Toast::info(__('Successfully'));
        endif;
    }
}

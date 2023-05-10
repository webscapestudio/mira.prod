<?php

namespace App\Orchid\Screens\Projects;

use App\Models\Project;
use App\Models\ProjectAdvantage;
use App\Models\ProjectProgressPoint;
use App\Models\ProjectUnit;
use App\Models\ProjectMain;
use Faker\Provider\ar_EG\Text;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ProjectsEditScreen extends Screen
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
            'project_mains' =>  ProjectMain::orderBy('sortdd', 'ASC')->where('project_mainable_id',  $project->id)->filters()->paginate(10),
            'project_progress_points' =>  ProjectProgressPoint::orderBy('sortdd', 'ASC')->where('project_progress_pointable_id',  $project->id)->filters()->paginate(10),
            'project_advantages' =>  ProjectAdvantage::orderBy('sortdd', 'ASC')->where('project_advantageable_id',  $project->id)->filters()->paginate(10),
            'project_units' =>  ProjectUnit::orderBy('sortdd', 'ASC')->where('project_unitable_id',  $project->id)->filters()->paginate(10),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        if (Route::currentRouteName() === 'platform.project.create') :
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
        if (Route::currentRouteName() === 'platform.project.create') :
            return [
                Button::make(__('Save'))
                    ->icon('check')
                    ->method('createOrUpdate'),
            ];
        else :
            return [
                Link::make(__('Add new Main Information'))
                ->icon('check')
                ->route('platform.project_main.create', $this->project->id),

                Link::make(__('Add new Progress Points'))
                    ->icon('check')
                    ->route('platform.project_progress_point.create', $this->project->id),

                Link::make(__('Add new Advantage'))
                    ->icon('check')
                    ->route('platform.project_advantage.create', $this->project->id),

                Link::make(__('Add new Unit'))
                    ->icon('check')
                    ->route('platform.project_unit.create', $this->project->id),

                Button::make(__('Save'))
                    ->icon('check')
                    ->method('createOrUpdate'),
            ];
        endif;
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::tabs([
                'Project' => [
                    Layout::rows([
                        Input::make('project.slug')->title('Slug')->type('text')->required(),
                        Input::make('project.title_first')->title('Title / First partition')->type('text')->required(),
                        Input::make('project.title_second')->title('Title / Second partition')->type('text'),
                        Input::make('project.subtitle')->title('Subtitle')->type('text')->required(),
                        Quill::make('project.description')->title('Description')->required()->rows(5),
                        Picture::make('project.image_main')->title('Picture / Main')->required()->acceptedFiles('image/*,application/pdf,.psd'),
                        Picture::make('project.image_preview')->title('Picture / Preview')->required()->acceptedFiles('image/*,application/pdf,.psd'),
                        Picture::make('project.image_cover')->title('Picture / Cover')->required()->acceptedFiles('image/*,application/pdf,.psd'),
                        Picture::make('project.image_informational')->title('Picture / Informational')->required()->acceptedFiles('image/*,application/pdf,.psd'),
                        TextArea::make('project.pictures_description')->title('Pictures Description')->rows(5),
                        Input::make('project.price')->title('Price')->type('number')->required()->mask([
                            'mask' => '999 999 999',
                            'numericInput' => true
                           ]),
                        Input::make('project.units_title')->title('Units Title')->type('text')->required(),
                        Input::make('project.construction_date')->title('Construction Date')->type('date')->required(),
                        CheckBox::make('project.is_announcement')->title('Announcement')->sendTrueOrFalse(),
                        CheckBox::make('project.is_unique')->title('Unique')->sendTrueOrFalse(),
                    ]),
                ],

                'USP' => [
                    Layout::rows([
                        Input::make('project.title_usp')->title('Title')->type('text'),
                        Quill::make('project.description_usp')->title('Description')->rows(5),
                        Picture::make('project.logo_usp')->title('Logo')->acceptedFiles('image/*,application/pdf,.psd'),
                        Picture::make('project.image_first_usp')->title('Picture / First')->acceptedFiles('image/*,application/pdf,.psd'),
                        Picture::make('project.image_second_usp')->title('Picture / Second')->acceptedFiles('image/*,application/pdf,.psd'),
                    ]),
                ],
                'Location' => [
                    Layout::rows([
                        Input::make('project.address')->title('Address')->type('text')->required(),
                        Quill::make('project.description_location')->title('Description')->rows(5)->required(),
                        Input::make('project.coordinates_latitude')->title('Coordinates(latitude)')->type('text')->required(),
                        Input::make('project.coordinates_longitude')->title('Coordinates(longitude)')->type('text')->required(),
                        Picture::make('project.image_location')->title('Picture / Location')->acceptedFiles('image/*,application/pdf,.psd')->required(),
                    ]),
                ],
                'Pictures' => [
                    Layout::rows([
                        Upload::make('project.attachment')->title('Pictures')->required()->acceptedFiles('image/*,application/pdf,.psd'),
                    ]),
                ],
                'Main Information' => [
                Layout::table('project_mains', [
                    TD::make('title_main', 'Title')->sort()->filter(TD::FILTER_TEXT),
                    TD::make('description_main', 'Description'),
                    TD::make('created_at', 'Created')->width('160px')->render(function ($date) {
                        return $date->created_at->diffForHumans();
                    }),
                    TD::make(__('Actions'))
                        ->align(TD::ALIGN_CENTER)
                        ->width('100px')
                        ->render(fn (ProjectMain $project_main) => DropDown::make()
                            ->icon('options-vertical')
                            ->list([
                                Link::make(__('Edit'))
                                    ->icon('pencil')
                                ->route('platform.project_main.edit', [
                                    'id_project' =>$this->project->id,
                                    'id' => $project_main->id
                                ]),
                                Button::make(__('Delete'))
                                    ->icon('trash')
                                    ->confirm(__('Are you sure you want to delete the entry?'))
                                    ->method('deleteMain', [
                                        'id' => $project_main->id,
                                    ]),
                                    Button::make(__('Up'))
                                    ->icon('arrow-up')
                                    ->method('up_position_project_main', [
                                        'id' => $project_main->id,
                                    ]),
                                Button::make(__('Down'))
                                    ->icon('arrow-down')
                                    ->method('down_position_project_main', [
                                        'id' => $project_main->id,
                                    ]),
                            ])),
                ]),
            ],
                'Progress Points' => [
                    Layout::table('project_progress_points', [
                        TD::make('image_desc', 'Image')->width('100')
                            ->render(function ($point) {
                                return "<img  class='mw-100 d-block img-fluid rounded-1 w-100' src='$point->image_preview' />";
                            }),
                        TD::make('title', 'Title')->sort()->filter(TD::FILTER_TEXT),
                        TD::make('description', 'Description')->width('grow'),
                        TD::make('created_at', 'Created')->width('160px')->render(function ($date) {
                            return $date->created_at->diffForHumans();
                        }),
                        TD::make(__('Actions'))
                            ->align(TD::ALIGN_CENTER)
                            ->width('100px')
                            ->render(fn (ProjectProgressPoint $point) => DropDown::make()
                                ->icon('options-vertical')
                                ->list([
                                    Link::make(__('Edit'))
                                        ->icon('pencil')
                                    ->route('platform.project_progress_point.edit', [
                                        'id_project' =>$this->project->id,
                                        'id' => $point->id
                                    ]),
                                    Button::make(__('Delete'))
                                        ->icon('trash')
                                        ->confirm(__('Are you sure you want to delete the entry?'))
                                        ->method('deletePoint', [
                                            'id' => $point->id,
                                        ]),

                                ])),
                    ]),
                ],
                'Advantages' => [
                    Layout::table('project_advantages', [
                        TD::make('image_desc', 'Image')->width('100')
                            ->render(function ($advantage) {
                                return "<img  class='mw-100 d-block img-fluid rounded-1 w-100' src='$advantage->image_pa' />";
                            }),
                        TD::make('title', 'Title')->sort()->filter(TD::FILTER_TEXT),
                        TD::make('description', 'Description')->width('grow'),
                        TD::make('created_at', 'Created')->width('160px')->render(function ($date) {
                            return $date->created_at->diffForHumans();
                        }),
                        TD::make(__('Actions'))
                            ->align(TD::ALIGN_CENTER)
                            ->width('100px')
                            ->render(fn (ProjectAdvantage $advantage) => DropDown::make()
                                ->icon('options-vertical')
                                ->list([
                                    Link::make(__('Edit'))
                                        ->icon('pencil')
                                    ->route('platform.project_advantage.edit', [
                                        'id_project' =>$this->project->id,
                                        'id' => $advantage->id
                                    ]),
                                    Button::make(__('Delete'))
                                        ->icon('trash')
                                        ->confirm(__('Are you sure you want to delete the entry?'))
                                        ->method('deleteAdvantage', [
                                            'id' => $advantage->id,
                                        ]),
                                        Button::make(__('Up'))
                                        ->icon('arrow-up')
                                        ->method('up_position_advantage', [
                                            'id' => $advantage->id,
                                        ]),
                                    Button::make(__('Down'))
                                        ->icon('arrow-down')
                                        ->method('down_position_advantage', [
                                            'id' => $advantage->id,
                                        ]),
                                ])),
                    ]),
                ],
                'Units' => [
                    Layout::table('project_units', [
                        TD::make('id', 'ID'),
                        TD::make('type', 'Type')->sort(),
                        TD::make('price', 'Price')->sort()->filter(TD::FILTER_TEXT),
                        TD::make('floor', 'Floor')->sort()->filter(TD::FILTER_TEXT),
                        TD::make('series', 'Series')->sort()->filter(TD::FILTER_TEXT),
                        TD::make('bathrooms_quantity', 'Bathrooms(quantity)')->sort()->filter(TD::FILTER_TEXT),
                        TD::make('bedrooms_quantity', 'Bedrooms(quantity)')->sort()->filter(TD::FILTER_TEXT),
                        TD::make('view', 'View')->sort()->filter(TD::FILTER_TEXT),
                        TD::make('created_at', 'Created')->width('160px')->render(function ($date) {
                            return $date->created_at->diffForHumans();
                        }),
                        TD::make(__('Actions'))
                            ->align(TD::ALIGN_CENTER)
                            ->width('100px')
                            ->render(fn (ProjectUnit $unit) => DropDown::make()
                                ->icon('options-vertical')
                                ->list([
                                    Link::make(__('Edit'))
                                        ->icon('pencil')
                                    ->route('platform.project_unit.edit', [
                                        'id_project' =>$this->project->id,
                                        'id' => $unit->id
                                    ]),
                                    Button::make(__('Delete'))
                                        ->icon('trash')
                                        ->confirm(__('Are you sure you want to delete the entry?'))
                                        ->method('deleteUnit', [
                                            'id' => $unit->id,
                                        ]),
                                        Button::make(__('Up'))
                                        ->icon('arrow-up')
                                        ->method('up_position_unit', [
                                            'id' => $unit->id,
                                        ]),
                                    Button::make(__('Down'))
                                        ->icon('arrow-down')
                                        ->method('down_position_unit', [
                                            'id' => $unit->id,
                                        ]),
                                ])),
                    ]),
                ],
            ]),
        ];
    }

//Main methods
public function deleteMain(Request $request): void
{
    ProjectMain::findOrFail($request->get('id'))->delete();
    Toast::info('Successfully deleted');
}
public function up_position_project_main(Request $request): void
{
    $project_main_all = ProjectMain::orderBy('sortdd', 'ASC')->get();
    $project_main = ProjectMain::findOrFail($request->get('id'));
    $prev_project_main = ProjectMain::where('sortdd', '<', $project_main->sortdd)
        ->latest('sortdd')
        ->first();

    if ($project_main_all->first() == $project_main) :
        Toast::error(__('Position is first'));
    else :
        $difference = $project_main->sortdd - $prev_project_main->sortdd;

        $prev_project_main->update(['sortdd'=>$prev_project_main->sortdd + $difference]);
        $project_main->update(['sortdd'=>$project_main->sortdd - $difference]);
        Toast::info(__('Successfully'));
    endif;

}
public function down_position_project_main(Request $request): void
{
    $project_main_all = ProjectMain::orderBy('sortdd', 'ASC')->get();
    $project_main = ProjectMain::findOrFail($request->get('id'));
    $next_project_main = ProjectMain::where('sortdd', '>', $project_main->sortdd)
        ->oldest('sortdd')
        ->first();

    if ($project_main_all->last() == $project_main) :
        Toast::error(__('Position is latest'));
    else :
        $difference =$next_project_main->sortdd - $project_main->sortdd;

        $next_project_main->update(['sortdd'=>$next_project_main->sortdd - $difference]);
        $project_main->update(['sortdd'=>$project_main->sortdd + $difference]);
        Toast::info(__('Successfully'));
    endif;
}

//Point methods
    public function deletePoint(Request $request): void
    {
        ProjectProgressPoint::findOrFail($request->get('id'))->delete();
        Toast::info('Successfully deleted');
    }
   

//Advantage methods
    public function deleteAdvantage(Request $request): void
    {
        ProjectAdvantage::findOrFail($request->get('id'))->delete();
        Toast::info('Successfully deleted');
    }
    public function up_position_advantage(Request $request): void
    {
        $advantage_all = ProjectAdvantage::orderBy('sortdd', 'ASC')->get();
        $advantage = ProjectAdvantage::findOrFail($request->get('id'));
        $prev_advantage = ProjectAdvantage::where('sortdd', '<', $advantage->sortdd)
            ->latest('sortdd')
            ->first();

        if ($advantage_all->first() == $advantage) :
            Toast::error(__('Position is first'));
        else :
            $difference = $advantage->sortdd - $prev_advantage->sortdd;

            $prev_advantage->update(['sortdd'=>$prev_advantage->sortdd + $difference]);
            $advantage->update(['sortdd'=>$advantage->sortdd - $difference]);
            Toast::info(__('Successfully'));
        endif;

    }
    public function down_position_advantage(Request $request): void
    {
        $advantage_all = ProjectAdvantage::orderBy('sortdd', 'ASC')->get();
        $advantage = ProjectAdvantage::findOrFail($request->get('id'));
        $next_advantage = ProjectAdvantage::where('sortdd', '>', $advantage->sortdd)
            ->oldest('sortdd')
            ->first();

        if ($advantage_all->last() == $advantage) :
            Toast::error(__('Position is latest'));
        else :
            $difference =$next_advantage->sortdd - $advantage->sortdd;

            $next_advantage->update(['sortdd'=>$next_advantage->sortdd - $difference]);
            $advantage->update(['sortdd'=>$advantage->sortdd + $difference]);
            Toast::info(__('Successfully'));
        endif;
    }
//Unit methods
    public function deleteUnit(Request $request): void
    {
        ProjectUnit::findOrFail($request->get('id'))->delete();
        Toast::info('Successfully deleted');
    }
    public function up_position_unit(Request $request): void
    {
        $unit_all = ProjectUnit::orderBy('sortdd', 'ASC')->get();
        $unit =  ProjectUnit::findOrFail($request->get('id'));
        $prev_unit = ProjectUnit::where('sortdd', '<', $unit->sortdd)
            ->latest('sortdd')
            ->first();

        if ($unit_all->first() == $unit) :
            Toast::error(__('Position is first'));
        else :
            $difference = $unit->sortdd - $prev_unit->sortdd;

            $prev_unit->update(['sortdd'=>$prev_unit->sortdd + $difference]);
            $unit->update(['sortdd'=>$unit->sortdd - $difference]);
            Toast::info(__('Successfully'));
        endif;

    }
    public function down_position_unit(Request $request): void
    {
        $unit_all = ProjectUnit::orderBy('sortdd', 'ASC')->get();
        $unit = ProjectUnit::findOrFail($request->get('id'));
        $next_unit = ProjectUnit::where('sortdd', '>', $unit->sortdd)
            ->oldest('sortdd')
            ->first();

        if ($unit_all->last() == $unit) :
            Toast::error(__('Position is latest'));
        else :
            $difference =$next_unit->sortdd - $unit->sortdd;

            $next_unit->update(['sortdd'=>$next_unit->sortdd - $difference]);
            $unit->update(['sortdd'=>$unit->sortdd + $difference]);
            Toast::info(__('Successfully'));
        endif;
    }

//Project methods
    public function createOrUpdate(Project $project, Request $request)
    {
        $request->validate([
            'project.price' => 'required|integer|max:9999999999',
            'project.coordinates_latitude' => 'required|numeric|max:90',
            'project.coordinates_longitude' => 'required|numeric|max:180',
        ]);

        $project->fill($request->get('project'))->save();
        $project->attachment()->syncWithoutDetaching(
            $request->input('project.attachment', [])
        );
        if ($project->sortdd == null) :
            $project->update([
                'sortdd' => $project->id
            ]);
        endif;
        Toast::info(__('Successfully saved'));
        return redirect()->route('platform.project.list');
    }
}

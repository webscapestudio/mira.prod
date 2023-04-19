<?php

namespace App\Orchid\Layouts\Achievements;

use App\Models\Achievements;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class AchievementsListTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'achievements';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('number','Number')->sort(),
            TD::make('addition','Addition')->sort(),
            TD::make('description','Description')->filter(TD::FILTER_TEXT),
            TD::make('created_at','Created')->defaultHidden(),
            TD::make('updated_at','Updated')->defaultHidden(),
            TD::make('Edit')->render(function (Achievements $achievement) {
                return ModalToggle::make('Edit')
                ->modal('editAchievement')
                ->method('update')
                ->modalTitle('Edit achievement')
                ->asyncParameters([
                    'achievement' => $achievement->id
                ]);
            }),
            TD::make('Delete')->render(function (Achievements $achievement) {
                return ModalToggle::make('Delete')
                ->modal('deleteAchievement')
                ->method('delete')
                ->modalTitle('Delete achievement?')
                ->asyncParameters([
                    'achievement' => $achievement->id
                ]);
            }),
        ];
    }
}

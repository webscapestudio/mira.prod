<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class ProjectAdvantage extends Model
{
    use HasFactory, AsSource, Filterable;

    protected $fillable = [
         'title',
         'description',
         'image_pa',
         'sortdd'
    ];

    protected $allowedSorts = [
        'title'
    ];
    protected $allowedFilters = ['title'];


    public function project_advantageable()
    {
        return $this->morphTo();
    }
}

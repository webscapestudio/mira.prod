<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class ProjectProgressPoint extends Model
{
    use HasFactory, AsSource, Filterable;

    protected $fillable = [
         'date',
         'title',
         'description',
         'image_preview',
         'image_main',
         'video',
         'media_description',
         'sortdd'
    ];

    protected $allowedSorts = [
        'title'
    ];
    protected $allowedFilters = ['title'];


    public function project_progress_pointable()
    {
        return $this->morphTo();
    }
}

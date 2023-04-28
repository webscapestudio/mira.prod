<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;
class ProjectMain extends Model
{
    use HasFactory, AsSource, Filterable;

    protected $fillable = [
        'title_main',
        'description_main',
        'sortdd'
    ];
    protected $allowedSorts = [
        'title_main'
    ];
    protected $allowedFilters = ['title_main'];


    public function project_mainable()
    {
        return $this->morphTo();
    }
}

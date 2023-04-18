<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class News extends Model
{
    use HasFactory, AsSource, Sluggable,Filterable;
    protected $guarded = [];
    protected $fillable = ['slug','content','title','image_desc','is_last','sortdd'];

    protected $allowedSorts = [
        'title',
        'slug'
    ];
    protected $allowedFilters = ['title'];
    public function sluggable(): array
    {
        return ['slug' => ['source' => 'title']];
    }

}

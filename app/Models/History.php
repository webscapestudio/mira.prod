<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class History extends Model
{
    use HasFactory, AsSource,Filterable;
    protected $guarded = [];
    protected $fillable = ['year','title','image_desc','image_mob','description','sortdd'];

    protected $allowedSorts = [
        'year',
        'title',
        'description'
    ];
    protected $allowedFilters = ['title'];
}

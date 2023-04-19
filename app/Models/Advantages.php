<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Advantages extends Model
{
    use HasFactory, AsSource, Filterable;
    protected $guarded = [];
    protected $fillable = ['title', 'description', 'sort', 'image_desc', 'image_mob','sortdd'];
    protected $allowedFilters = ['title'];
    protected $allowedSorts = [
        'title',
        'description'
    ];
}

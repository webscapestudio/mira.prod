<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Vacancies extends Model
{
    use HasFactory, AsSource,Filterable;
 
    protected $guarded = [];
    protected $fillable = ['title','content','image_desc' ,'sortdd'];

    protected $allowedSorts = [
        'title',
        'content',
    ];
    protected $allowedFilters = ['title'];
}

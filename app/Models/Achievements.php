<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Achievements extends Model
{

    use HasFactory, AsSource, Filterable;
    protected $fillable = [
        'number',
        'addition',
        'description',
        'sortdd'
        
    ];
    protected $allowedSorts = ['number','addition','description'];
    protected $allowedFilters = ['number','description'];

}

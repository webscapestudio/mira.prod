<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class GeneralRequest extends Model
{
    use HasFactory, AsSource,Filterable;

   protected $fillable = [
        'name',
        'phone'
    ];

    protected $allowedSorts = [
        'name',
        'phone'
    ];
    protected $allowedFilters = [
        'name',
        'phone'
    ];
}

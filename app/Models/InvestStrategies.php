<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class InvestStrategies extends Model
{
    use HasFactory, AsSource, Filterable;

    protected $fillable = ['title','description'];

    protected $allowedSorts = [
        'title',
        'description'
    ];
    protected $allowedFilters = ['title'];
    public function invest_strategieable()
    {
        return $this->morphTo();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class AboutAchievements extends Model
{
    use HasFactory, AsSource, Filterable;

    protected $fillable = ['number','addition','description'];
    
    protected $allowedSorts = [
        'number',
        'addition',
        'description'
    ];
    protected $allowedFilters = ['number'];
    public function about_achievementable()
    {
        return $this->morphTo();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class AboutUs extends Model
{
    use HasFactory, AsSource, Filterable;
    
    protected $fillable = ['title', 'description', 'text_size', 'image_desc', 'image_mob','sortdd'];

    protected $allowedSorts = [
        'title',
        'description'
    ];
    protected $allowedFilters = ['title'];

    public function about_achievement()
    {
        return $this->morphMany(AboutAchievements::class, 'about_achievementable');
    }
}

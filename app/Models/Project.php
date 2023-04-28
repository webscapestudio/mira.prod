<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Project extends Model
{
    use HasFactory, AsSource,Attachable, Filterable;

    protected $fillable = [
        //project
        'slug',
        'title_first',
        'title_second',
        'subtitle',
        'description',
        'image_main',
        'image_cover',
        'image_informational',
        'image_preview',
        'pictures_description',
        'price',
        'units_title',
        'construction_date',
        'is_announcement',
        'is_unique',
        //sort position
        'sortdd',
        //usp
        'title_usp',
        'description_usp',
        'logo_usp',
        'image_first_usp',
        'image_second_usp',
         // location
         'address',
         'description_location',
         'coordinates_latitude',
         'coordinates_longitude',
         'image_location',
    ];

    protected $allowedSorts = [
        'title_first',
        'title_second'
    ];
    protected $allowedFilters = ['title_first','title_second'];

    public function project_units()
    {
        return $this->morphMany(ProjectUnit::class, 'project_unitable');
    }
    public function project_progress_points()
    {
        return $this->morphMany(ProjectProgressPoint::class, 'project_progress_pointable');
    }
    public function project_advantages()
    {
        return $this->morphMany(ProjectAdvantage::class, 'project_advantageable');
    }
    public function project_mains()
    {
        return $this->morphMany(ProjectMain::class, 'project_mainable');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class ProjectUnit extends Model
{
    use HasFactory, AsSource,Attachable, Filterable;

    protected $fillable = [

        'address',
        'type',
        'series',
        'price',
        'area',
        'bedrooms_quantity',
        'bathrooms_quantity',
        'floor',
        'view',
        'sortdd'
    ];

    protected $allowedSorts = [
        'address','price'
    ];
    protected $allowedFilters = ['address','price'];


    public function project_unitable()
    {
        return $this->morphTo();
    }
}

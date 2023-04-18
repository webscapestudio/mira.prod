<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Banners extends Model
{
    use HasFactory, AsSource, Attachable,Filterable;
    protected $guarded = [];
    protected $fillable = ['title_first', 'title_second', 'image_desc', 'image_mob','project','sortdd'];

    protected $allowedSorts = [
        'title_first',
        'title_second'
    ];
    protected $allowedFilters = ['title_first'];
}

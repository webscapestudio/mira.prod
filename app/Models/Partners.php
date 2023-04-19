<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Partners extends Model
{
    use HasFactory, AsSource, Attachable,Filterable;
    protected $table = 'partners';
    protected $fillable = ['title', 'description', 'logo','sortdd'];

    protected $allowedSorts = [
        'title',
        'description'
    ];
    protected $allowedFilters = ['title'];
}


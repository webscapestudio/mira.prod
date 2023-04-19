<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class ResumeRequest extends Model
{
    use HasFactory, AsSource,Filterable,Attachable;

    protected $fillable = [
         'name',
         'email',
         'phone',
         'comment',
         'attachment',
     ];
 
     protected $allowedSorts = [
        'name',
        'email',
        'phone',
     ];
     protected $allowedFilters = [
        'name',
        'email',
        'phone',
     ];
}

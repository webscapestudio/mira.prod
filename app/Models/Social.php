<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Social extends Model
{
    use HasFactory, AsSource,Filterable;

    protected $guarded = [];
    protected $fillable = ['title','short_title','url'];

    protected $allowedSorts = [
        'title',
        'short_title',
        'url'
    ];
    protected $allowedFilters = ['title'];
    public function socialable()
    {
        return $this->morphTo();
    }
}

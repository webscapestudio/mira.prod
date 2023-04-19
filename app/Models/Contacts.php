<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Contacts extends Model
{
    use HasFactory, AsSource;
    protected $guarded = false;
    public function social()
    {
        return $this->morphMany(Social::class, 'socialable');
    }
}

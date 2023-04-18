<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Investment extends Model
{
    use HasFactory, AsSource;
    protected $fillable = [
        'title',
        'description',
        'image_desc'
    ];
    public function invest_advantage()
    {
        return $this->morphMany(InvestAdvantages::class, 'invest_advantageable');
    }
    public function invest_strategie()
    {
        return $this->morphMany(InvestStrategies::class, 'invest_strategieable');
    }
}

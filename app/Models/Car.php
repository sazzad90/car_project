<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;
    protected $fillable = [
        'make',
        'model',
        'fuel_type',
        'drive',
        'cylinders',
        'transmission',
        'year',
        'min_city_mpg',
        'max_city_mpg',
        'min_hwy_mpg',
        'max_hwy_mpg',
        'min_comb_mpg',
        'max_comb_mpg',
    ];
    public function images()
    {
        return $this->hasMany(Image::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Food extends Model
{
    use HasFactory;
    protected $table = 'foods';

    protected $fillable = [
        'foodName',
        'foodCategory',
        'foodDescription',
        'foodPrice',
        'Image',
    ];

    public function packages()
    {
        return $this->hasMany(Package::class, 'food_id');
    }
}

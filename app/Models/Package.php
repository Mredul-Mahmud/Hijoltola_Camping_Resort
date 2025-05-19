<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'packageName',
        'packageRank',
        'packageDescription',
        'food_id',
        'guestNumber',
        'packagePrice',
    ];

    public function food()
    {
        return $this->belongsTo(Food::class, 'food_id');
    }
}

<?php

namespace App\Models;

use App\Models\Food;
use App\Models\Package;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    //
    use HasFactory;

    protected $fillable = ['user_id', 'package_id', 'food_id', 'totalGuest', 'reservationDate', 'price', 'message'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function food()
    {
        return $this->belongsTo(Food::class, 'food_id');
    }
}

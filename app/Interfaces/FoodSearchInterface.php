<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface FoodSearchInterface
{
    public function search(string $term): Collection;
}

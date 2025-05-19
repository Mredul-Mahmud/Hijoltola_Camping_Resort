<?php

namespace App\Services;

use App\Models\Food;
use App\DTOs\FoodDTO;
use App\Interfaces\BaseRepoInterface;
use App\Interfaces\FoodSearchInterface;
use Illuminate\Database\Eloquent\Collection;

class FoodService implements BaseRepoInterface, FoodSearchInterface
{
    public function all(): Collection
    {
        return Food::all();
    }

    public function find(int $id): ?Food
    {
        return Food::find($id);
    }

    public function create(array $data): Food
    {
        $dto = new FoodDTO($data);
        return Food::create($dto->toArray());
    }

    public function update(int $id, array $data): bool
{
    $dto = new FoodDTO($data);

    $food = Food::find($id);

    if (!$food) {
        return false;
    }

    return $food->update($dto->toArray());
}


    public function delete(int $id): bool
    {
        return Food::destroy($id) > 0;
    }

    public function search(string $term): Collection
    {
        return Food::where('foodName', 'like', "%$term%")
            ->orWhere('foodCategory', 'like', "%$term%")
            ->orWhere('foodDescription', 'like', "%$term%")
            ->orWhere('foodPrice', $term)
            ->get();
    }
}

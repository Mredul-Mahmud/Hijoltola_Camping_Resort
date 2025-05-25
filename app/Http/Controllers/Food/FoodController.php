<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DTOs\FoodDTO;
use App\Models\Food;
use App\Models\Package; 
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Interfaces\BaseRepoInterface;
use App\Interfaces\FoodSearchInterface;

class FoodController extends Controller
{
    protected BaseRepoInterface $foodRepo;
    protected FoodSearchInterface $foodSearch;

    public function __construct(BaseRepoInterface $foodRepo, FoodSearchInterface $foodSearch)
    {
        $this->foodRepo = $foodRepo;
        $this->foodSearch = $foodSearch;
    }

    public function foodList(): JsonResponse
    {
        $foods = $this->foodRepo->all();
        return response()->json(['All Foods' => $foods], 200);
    }

    public function addFood(Request $request): JsonResponse
    {
        $rules = [
            'foodName' => 'required|max:50|unique:foods,foodName',
            'foodCategory' => 'required|max:30',
            'foodDescription' => 'required|max:500',
            'foodPrice' => 'required|numeric|min:0',
            'Image' => 'nullable|string|max:255'
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }

        $dto = new FoodDTO($request->all());

        if ($this->foodRepo->create($dto->toArray())) {
            return response()->json(['message' => 'Food Added Successfully'], 200);
        }
    
        return response()->json(['message' => 'Failed to add Food'], 500);
    }

    // public function editFood(Request $request): JsonResponse
    // {
    //     $rules = [
    //         'id' => 'required|exists:foods,id',
    //         'foodName' => 'required|max:50|unique:foods,foodName,' . $request->id,
    //         'foodCategory' => 'required|max:30',
    //         'foodDescription' => 'required|max:200',
    //         'foodPrice' => 'required|numeric|min:0',
    //         'Image' => 'nullable|string|max:255'
    //     ];

    //     $validation = Validator::make($request->all(), $rules);

    //     if ($validation->fails()) {
    //         return response()->json(['errors' => $validation->errors()], 422);
    //     }

    //     $dto = new FoodDTO($request->all());

    //     if ($this->foodRepo->update($dto)) {
    //         return response()->json(['message' => 'Food Updated Successfully'], 200);
    //     }

    //     return response()->json(['message' => 'Food update failed'], 500);
    // }
    public function editFood(Request $request)
    {
        $dto = new FoodDTO($request->all());

        if (!$dto->id) {
            return response()->json(['error' => 'Food ID is required'], 400);
        }

        $food = Food::find($dto->id);

        if (!$food) {
            return response()->json(['error' => 'Package not found'], 404);
        }

        $food->foodName = $dto->foodName ?? $food->foodName;
        $food->foodCategory = $dto->foodCategory ?? $food->foodCategory;
        $food->foodDescription = $dto->foodDescription ?? $food->foodDescription;
        $food->foodPrice = $dto->foodPrice ?? $food->foodPrice;
        $food->Image = $dto->Image ?? $food->Image;


        $food->save();

        return response()->json([
            'message' => 'Food updated successfully',
            'data' => $food
        ]);
    }

    public function deleteFood($id): JsonResponse
    {
        if ($this->foodRepo->delete($id)) {
            return response()->json(['message' => 'Food deleted'], 200);
        }

        return response()->json(['message' => 'No food deleted'], 500);
    }

    public function searchFood($term): JsonResponse
    {
        $results = $this->foodSearch->search($term);

        if ($results->isEmpty()) {
            return response()->json(['message' => 'No food found'], 404);
        }

        return response()->json(['Foods Found' => $results], 200);
    }

    public function getFoodById($id): JsonResponse
    {
        $food = $this->foodRepo->find($id);

        if (!$food) {
            return response()->json(['message' => 'Food not found'], 404);
        }

        return response()->json(['Food' => $food], 200);
    }
}

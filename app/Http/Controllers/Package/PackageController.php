<?php
namespace App\Http\Controllers;

use App\Interfaces\BaseRepoInterface;
use App\Interfaces\PackageSearchInterface;
use App\DTOs\PackageDTO;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Package;
use App\Models\Food;

class PackageController extends Controller
{
    protected BaseRepoInterface $repo;
    protected PackageSearchInterface $search;

    public function __construct(BaseRepoInterface $repo, PackageSearchInterface $search)
    {
        $this->repo = $repo;
        $this->search = $search;
    }

    public function packageList(): JsonResponse
    {
        $packages = $this->repo->all();

        $data = collect($packages)->map(function ($package) {
            return [
                'id' => $package->id,
                'packageName' => $package->packageName,
                'packageRank' => $package->packageRank,
                'packageDescription' => $package->packageDescription,
                'guestNumber' => $package->guestNumber,
                'packagePrice' => $package->packagePrice,
                'foodName' => $package->food->foodName ?? null,
            ];
        });

        return response()->json(['All Packages' => $data], 200);
    }

    // public function addPackage(Request $request): JsonResponse
    // {
    //     $validated = $request->validate([
    //         'packageName' => 'required|string|max:255',
    //         'packageRank' => 'required|string|max:255',
    //         'packageDescription' => 'required|string',
    //         'guestNumber' => 'required|integer',
    //         'packagePrice' => 'required|numeric',
    //         'food_id' => 'required|exists:foods,id',
    //     ]);

    //     $dto = new PackageDTO($validated);
    //     $package = $this->repo->create($dto->toArray());

    //     return response()->json(['message' => 'Package added successfully', 'data' => $package], 201);
    // }

        // PackageController.php
public function addPackage(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'packageName' => 'required|string|max:255',
            'packageRank' => 'required|string|max:255',
            'packageDescription' => 'required|string',
            'guestNumber' => 'required|integer',
            'packagePrice' => 'required|numeric',
            'food_id' => 'required|exists:foods,id',
        ]);


        $dto = new PackageDTO($validated);
        $package = $this->repo->create($dto->toArray());

        $food = Food::find($dto->food_id);
        $foodName = $food ? $food->foodName : null;

        return response()->json([
            'message' => 'Package added successfully',
            'data' => $package,
            'foodName' => $foodName
        ], 201);
    }


    public function editPackage(Request $request)
    {
        $dto = new PackageDTO($request->all());

        if (!$dto->id) {
            return response()->json(['error' => 'Package ID is required'], 400);
        }

        $package = Package::find($dto->id);

        if (!$package) {
            return response()->json(['error' => 'Package not found'], 404);
        }

        $package->packageName = $dto->packageName ?? $package->packageName;
        $package->packageRank = $dto->packageRank ?? $package->packageRank;
        $package->packageDescription = $dto->packageDescription ?? $package->packageDescription;
        $package->guestNumber = $dto->guestNumber ?? $package->guestNumber;
        $package->packagePrice = $dto->packagePrice ?? $package->packagePrice;
        $package->food_id = $dto->food_id ?? $package->food_id;


        $package->save();

        return response()->json([
            'message' => 'Package updated successfully',
            'data' => $package
        ]);
    }

    public function findPackageById(int $id): JsonResponse
    {
        $package = $this->repo->find($id);

        if (!$package) {
            return response()->json(['message' => 'Package not found'], 404);
        }

        $data = [
            'id' => $package->id,
            'packageName' => $package->packageName,
            'packageRank' => $package->packageRank,
            'packageDescription' => $package->packageDescription,
            'guestNumber' => $package->guestNumber,
            'packagePrice' => $package->packagePrice,
            'foodName' => $package->food->foodName ?? null,
        ];

        return response()->json(['data' => $data], 200);
    }
    public function deletePackage(int $id): JsonResponse
    {
        $package = $this->repo->find($id);

        if (!$package) {
         return response()->json(['message' => 'Package not found'], 404);
        }

        $deleted = $this->repo->delete($id);

        if ($deleted) {
            return response()->json(['message' => 'Package deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Failed to delete package'], 500);
        }
    }


    public function searchPackage(string $term): JsonResponse
    {
        $result = $this->search->search($term);

        if ($result->isEmpty()) {
            return response()->json(['message' => 'No Package found'], 404);
        }

        return response()->json(['All Packages' => $result], 200);
    }
}




















//$rules = [
//         'id' => "required|exists:packages,id",
//         'packageName' => "required|max:30|unique:packages,packageName,".$request->id,
//         'packageRank' => "required|max:10",
//         'packageDescription' => "required|max:200",
//         'food_id' => "required|exists:foods,id",
//         'guestNumber' => "required|integer|min:1|max:20",
//         'packagePrice' => "required|numeric|min:1"
//     ];
//      //$imageName = null;
//         //         // if(isset($request->Image))
//         //         // {
//         //         //     $imageName = time().'.'.$request->Image->extension();//here i have changed name format for the uploaded picture. for this a new name will be generated for each new image depending on time(second)
//         //         //     $request->Image->move(public_path('images'), $imageName);
        
//         //         // }
//     $validation = Validator::make($request->all(), $rules);

//     if ($validation->fails()) {
//         return response()->json(['errors' => $validation->errors()], 422);
//     }

//     $dto = new PackageDTO($request->all());

//     $package = Package::find($dto->id);
//     $package->packageName = $dto->packageName;
//     $package->packageRank = $dto->packageRank;
//     $package->packageDescription = $dto->packageDescription;
//     $package->food_id = $dto->food_id;
//     $package->guestNumber = $dto->guestNumber;
//     $package->packagePrice = $dto->packagePrice;
//              // $package->Image = $imageName;
<?php

namespace App\Services;

use App\Models\Package;
use App\DTOs\PackageDTO;
use App\Interfaces\BaseRepoInterface;
use App\Interfaces\PackageSearchInterface;

class PackageService implements BaseRepoInterface, PackageSearchInterface
{
    public function all(): iterable
    {
        return Package::with('food')->get();
    }

    public function find(int $id): ?Package
    {
        return Package::find($id);
    }

    public function create(array $data): Package
    {
        $dto = new PackageDTO($data);
        return Package::create($dto->toArray());
    }

    public function update(int $id, array $data): bool
    {
        $dto = new PackageDTO($data);
        $package = Package::find($id);
        return $package ? $package->update($dto->toArray()) : false;
    }

    public function delete(int $id): bool
    {
        return Package::destroy($id) > 0;
    }

    public function search(string $term): iterable
    {
        return Package::where('packageName', 'like', "%$term%")
            ->orWhere('packageRank', '=', $term)
            ->orWhere('guestNumber', '=', $term)
            ->orWhere('packagePrice', '=', $term)
            ->get();
    }
}

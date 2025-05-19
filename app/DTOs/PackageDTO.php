<?php

namespace App\DTOs;

class PackageDTO
{
    public ?int $id;
    public string $packageName;
    public string $packageRank;
    public string $packageDescription;
    public int $guestNumber;
    public float $packagePrice;
    public int $food_id;

    public function __construct(array $data)
    {
        $this->id = isset($data['id']) ? (int)$data['id'] : null;
        $this->packageName = $data['packageName'];
        $this->packageRank = $data['packageRank'];
        $this->packageDescription = $data['packageDescription'];
        $this->guestNumber = $data['guestNumber'];
        $this->packagePrice = $data['packagePrice'];
        $this->food_id = $data['food_id'];
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'packageName' => $this->packageName,
            'packageRank' => $this->packageRank,
            'packageDescription' => $this->packageDescription,
            'guestNumber' => $this->guestNumber,
            'packagePrice' => $this->packagePrice,
            'food_id' => $this->food_id,
        ];
    }
    
}

<?php

namespace App\DTOs;

class FoodDTO
{
    public ?int $id;
    public string $foodName;
    public string $foodCategory;
    public string $foodDescription;
    public float $foodPrice;
    public ?string $Image;

    public function __construct(array $data)
    {
        $this->id = isset($data['id']) ? (int)$data['id'] : null;
        $this->foodName = $data['foodName'] ;
        $this->foodCategory = $data['foodCategory'] ;
        $this->foodDescription = $data['foodDescription'];
        $this->foodPrice = (float)$data['foodPrice'];
        $this->Image = $data['Image'] ?? null;
    }
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'foodName' => $this->foodName,
            'foodCategory' => $this->foodCategory,
            'foodDescription' => $this->foodDescription,
            'foodPrice' => $this->foodPrice,
            'Image' => $this->Image,
        ];
    }
}

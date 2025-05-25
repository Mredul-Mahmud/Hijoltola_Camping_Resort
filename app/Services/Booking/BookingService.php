<?php
namespace App\Services\Booking;

use App\Interfaces\Booking\BookingInterface;
use App\DTOs\Booking\BookingDTO;
use App\Models\Booking;

class BookingService implements BookingInterface
{
    public function registerBooking(BookingDTO $dto, int $user_id, int $package_id, ?int $food_id = null)
    {
        return Booking::create([
            'user_id' => $user_id,
            'package_id' => $package_id,
            'food_id' => $food_id,
            'totalGuest' => $dto->totalGuest,
            'reservationDate' => $dto->reservationDate,
            'price' => $this->calculatePrice($package_d, $food_d),
            'message' => $dto->message,
        ]);
    }

    private function calculatePrice(int $package_id, ?int $food_id): int
    {
        $packagePrice = \App\Models\Package::findOrFail($package_id)->price;
        $foodPrice = $food_id ? \App\Models\Food::findOrFail($food_id)->price : 0;

        return ($packagePrice + $foodPrice);
    }
}
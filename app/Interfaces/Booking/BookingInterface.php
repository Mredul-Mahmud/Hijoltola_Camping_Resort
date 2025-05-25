<?php
namespace App\Interfaces\Booking;

use App\DTOs\Booking\BookingDTO;

interface BookingInterface
{
    public function registerBooking(BookingDTO $dto, int $user_id, int $package_id, ?int $food_id = null);
}

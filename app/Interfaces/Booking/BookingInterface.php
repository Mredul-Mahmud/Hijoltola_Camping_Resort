<?php
namespace App\Interfaces\Booking;

use App\DTOs\Booking\BookingDTO;

interface BookingInterface
{
    public function registerBooking(BookingDTO $dto, int $user_id, int $package_id, ?int $food_id);
    public function editBooking(int $booking_id, BookingDTO $dto, ?int $food_id);
    public function deleteBooking(int $booking_id);
    public function bookingDetail(int $booking_id);
    public function allBooking();
    public function searchBooking(array $filters);
}

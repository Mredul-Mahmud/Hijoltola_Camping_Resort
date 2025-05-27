<?php
namespace App\Services\Booking;

use App\Models\Food;
use App\Models\Booking;
use App\Models\Package;
use App\DTOs\Booking\BookingDTO;
use App\Interfaces\Booking\BookingInterface;

class BookingService implements BookingInterface
{

    private function calculatePrice(int $package_id, ?int $food_id): int
    {
        $packagePrice = Package::findOrFail($package_id)->packagePrice;
        $foodPrice = $food_id ? Food::findOrFail($food_id)->foodPrice : 0;

        return ($packagePrice + $foodPrice);
    }

    public function registerBooking(BookingDTO $dto, int $user_id, int $package_id, ?int $food_id = null)
    {
        return Booking::create([
            'user_id' => $user_id,
            'package_id' => $package_id,
            'food_id' => $food_id,
            'totalGuest' => $dto->totalGuest,
            'reservationDate' => $dto->reservationDate,
            'price' => $this->calculatePrice($package_id, $food_id),
            'message' => $dto->message?? 'No message',
        ]);
    }

    public function editBooking(int $booking_id, BookingDTO $dto, ?int $food_id)
    {
        $booking = Booking::findOrFail($booking_id);
        $booking->update([
            'totalGuest' => $dto->totalGuest,
            'reservationDate' => $dto->reservationDate,
            'food_id' => $food_id,
            'price' => $this->calculatePrice($booking->package_id, $food_id),
            'message' => $dto->message ?? 'No message',
        ]);
        return $booking;
    }

    public function deleteBooking(int $booking_id)
    {
        $booking = Booking::findOrFail($booking_id);
        return $booking->delete();
    }

    public function bookingDetail(int $booking_id)
    {
        return Booking::with('package', 'food', 'user')->findOrFail($booking_id);

    }

    public function allBooking()
    {
        return Booking::with('package', 'food', 'user')->get();

    }

    public function searchBooking(array $filters)
    {
        $query = Booking::query();

        if (!empty($filters['reservationDate']))
        {
            $query->whereDate('reservationDate', $filters['reservationDate']);
        }

        if (!empty($filters['user_id']))
        {
            $query->where('user_id', $filters['user_id']);
        }

        if (!empty($filters['package_id'])) {
            $query->where('package_id', $filters['package_id']);
        }

        return $query->with('package', 'food', 'user')->get();
}


    
}
<?php

namespace App\Http\Controllers\Booking;

use Illuminate\Http\Request;
use App\DTOs\Booking\BookingDTO;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Booking\BookingService;
use App\Interfaces\Booking\BookingInterface;

class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function bookPackage(Request $request, $package_id)
    {
        $request->validate([
            //'package_id' => 'exists:packages,id',
            'totalGuest' => 'required|integer|min:1',
            'reservationDate' => 'required|date|after_or_equal:today',
            'message' => 'nullable|string',
            'food_id' => 'nullable|exists:foods,id',
        ]);

        $dto = new BookingDTO($request->all());
        $user_id = Auth::id();
        $food_id = $request->input('food_id');

        $booking = $this->bookingService->registerBooking($dto, $user_id, $package_id, $food_id);

        return response()->json([
            'message' => 'Booking registered successfully!',
            'data' => $booking
        ], 201);
    }

    public function editBooking(Request $request, $booking_id)
    {
        $request->validate([
            'totalGuest' => 'required|integer|min:1',
            'reservationDate' => 'required|date|after_or_equal:today',
            'message' => 'nullable|string',
            'food_id' => 'nullable|exists:foods,id',
        ]);

        $dto = new BookingDTO($request->all());
        $food_id = $request->input('food_id');

        $booking = $this->bookingService->editBooking($booking_id, $dto, $food_id);

        return response()->json([
            'message' => 'Booking updated successfully!',
            'data' => $booking
        ]);
    }

    public function deleteBooking($booking_id)
    {
        $this->bookingService->deleteBooking($booking_id);

        return response()->json(['message' => 'Booking deleted successfully!']);
    }

    public function bookingDetail($booking_id)
    {
        $booking = $this->bookingService->bookingDetail($booking_id);

        return response()->json(['data' => $booking]);
    }

    public function allBooking()
    {
        $bookings = $this->bookingService->allBooking();

        return response()->json(['data' => $bookings]);
    }

    public function searchBooking(Request $request)
    {
        $filters = $request->only(['reservationDate', 'user_id', 'package_id']);

        $results = $this->bookingService->searchBooking($filters);

        if ($results->isEmpty()) {
            return response()->json(['message' => 'No bookings found.'], 404);
        }

        return response()->json([
           // 'message' => 'Bookings retrieved successfully.',
            'data' => $results
        ]);
    }

}

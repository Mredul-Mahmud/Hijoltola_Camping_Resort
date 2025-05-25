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
            'package_id' => 'exists:packages,id',
            'totalGuest' => 'required|integer|min:1',
            'reservationDate' => 'required|date|after_or_equal:today',
            'message' => 'required|string',
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
}

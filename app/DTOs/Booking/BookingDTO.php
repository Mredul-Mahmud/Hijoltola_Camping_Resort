<?php

namespace App\DTOs\Booking;

class BookingDTO
{
   
    public int $totalGuest;
    public string $reservationDate;
    public ?string $message;

    public function __construct(array $data)
    {
       
        $this->totalGuest = $data['totalGuest'];
        $this->reservationDate = $data['reservationDate'];
        $this->message = $data['message'] ?? null;;
    }
}

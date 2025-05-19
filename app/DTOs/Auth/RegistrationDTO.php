<?php
namespace App\DTOs\Auth;

class RegistrationDTO
{
    public string $name;
    public string $email;
    public string $password;
    public string $phoneNumber;
    public string $address;
    public $image;

    public function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->phoneNumber = $data['phoneNumber'];
        $this->address = $data['address'];
        $this->image = $data['image'] ?? null;
    }
}


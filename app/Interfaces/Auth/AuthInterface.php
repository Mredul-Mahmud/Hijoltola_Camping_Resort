<?php
namespace App\Interfaces\Auth;

use App\DTOs\Auth\RegistrationDTO;
use App\DTOs\Auth\LoginDTO;
use Illuminate\Http\Request;

interface AuthInterface
{
    public function register(RegistrationDTO $dto): array;
    public function login(LoginDTO $dto): array;
    public function logout(Request $request): array;
    public function profile(Request $request): array;
}

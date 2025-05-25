<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DTOs\Auth\RegistrationDTO;
use App\DTOs\Auth\LoginDTO;
use App\Interfaces\Auth\AuthInterface;

class AuthController extends Controller
{
    protected AuthInterface $authService;

    public function __construct(AuthInterface $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:4',
            'phoneNumber' => 'required',
            'address' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $dto = new RegistrationDTO($request->all());
        return response()->json($this->authService->register($dto));
    }


    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $dto = new LoginDTO($request->all());
    $response = $this->authService->login($dto);

    $status = $response['status'] ?? 200;
    unset($response['status']);

    return response()->json($response, $status);
}

    public function logout(Request $request)
    {
        return response()->json($this->authService->logout($request));
    }

    public function profile(Request $request)
    {
        return response()->json($this->authService->profile($request));
    }
}
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
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $dto = new LoginDTO($validated);
        $response = $this->authService->login($dto);

        // Handle failed login
        if (isset($response['error'])) {
            return response()->json($response, $response['status']);
        }

        // Save email and token in cookies
        return response()->json([
            'message' => 'Login successful',
            'access_token' => $response['access_token'],
        ], 200)
        ->cookie('access_token', $response['access_token'], 60 * 24, null, null, false, true)
        ->cookie('user_email', $dto->email, 60 * 24, null, null, false, true);
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request);

        return response()->json([
            'message' => 'Logged out'
        ])->withCookie(Cookie::forget('access_token'))
          ->withCookie(Cookie::forget('user_email'));
    }

    public function profile(Request $request)
    {
        return response()->json($this->authService->profile($request));
    }


//     public function login(Request $request)
// {
//     $request->validate([
//         'email' => 'required|email',
//         'password' => 'required',
//     ]);

//     $dto = new LoginDTO($request->all());
//     $response = $this->authService->login($dto);

//     $status = $response['status'] ?? 200;
//     unset($response['status']);

//     return response()->json($response, $status);
// }

//     public function logout(Request $request)
//     {
//         return response()->json($this->authService->logout($request));
//     }

//     public function profile(Request $request)
//     {
//         return response()->json($this->authService->profile($request));
//     }
}
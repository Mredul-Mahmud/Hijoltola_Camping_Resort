<?php

namespace App\Services\Auth;

use App\DTOs\Auth\RegistrationDTO;
use App\DTOs\Auth\LoginDTO;
use App\Interfaces\Auth\AuthInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthInterface
{
    public function register(RegistrationDTO $dto): array
{
    $imageName = null;

    if ($dto->image && $dto->image instanceof \Illuminate\Http\UploadedFile) {
        $image = $dto->image;
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);
    }
    

    User::create([
        'name' => $dto->name,
        'email' => $dto->email,
        'password' => Hash::make($dto->password),
        'phoneNumber' => $dto->phoneNumber,
        'address' => $dto->address,
        'role' => 'user',
        'image' => $imageName,
    ]);

    return ['message' => 'User has successfully registered'];
}


    public function login(LoginDTO $dto): array
    {
        $user = User::where('email', $dto->email)->first();

        if (!$user || !Hash::check($dto->password, $user->password)) {
            return ['error' => 'Invalid credentials', 'status' => 401];
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'status' => 200
        ];
    }

    public function logout(Request $request): array
    {
        $request->user()->currentAccessToken()->delete();
        return ['message' => 'Logged out'];
    }

    public function profile(Request $request): array
    {
        return $request->user()->toArray();
    }
}

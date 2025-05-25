<?php

namespace App\Services\Auth;

use App\Interfaces\Auth\SocialAuthInterface;
use Laravel\Socialite\Contracts\User as ProviderUser;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\DTOs\Auth\GoogleAuthDTO;

class FacebookAuthService implements SocialAuthInterface
{
    public function handleProviderUser(ProviderUser $providerUser)
    {
        $dto = new GoogleAuthDTO([
            'name' => $providerUser->getName(),
            'email' => $providerUser->getEmail(),
        ]);

        $user = User::firstOrCreate(
            ['email' => $dto->email],
            [
                'name' => $dto->name,
                'email_verified_at' => now(),
                'password' => Hash::make(Str::random(24)),
                'role' => 'user',
            ]
        );

        $token = $user->createToken('facebook-login')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Interfaces\Auth\SocialAuthInterface;

class GoogleAuthController extends Controller
{
    protected $googleAuthService;

    public function __construct(SocialAuthInterface $googleAuthService)
    {
        $this->googleAuthService = $googleAuthService;
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')
        ->stateless()
        ->with(['prompt' => 'select_account'])
        ->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $response = $this->googleAuthService->handleProviderUser($googleUser);

            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to authenticate user.'], 500);
        }
    }
}

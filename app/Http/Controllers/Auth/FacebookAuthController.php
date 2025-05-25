<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Interfaces\Auth\SocialAuthInterface;

class FacebookAuthController extends Controller
{
    protected $facebookAuthService;

    public function __construct(SocialAuthInterface $facebookAuthService)
    {
        $this->facebookAuthService = $facebookAuthService;
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')
            ->with(['auth_type' => 'rerequest'])
            ->stateless()
            ->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->stateless()->user();
            $response = $this->facebookAuthService->handleProviderUser($facebookUser);

            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to authenticate user.'], 500);
        }
    }
}

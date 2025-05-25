<?php

namespace App\Interfaces\Auth;

use Laravel\Socialite\Contracts\User as ProviderUser;

interface SocialAuthInterface
{
    public function handleProviderUser(ProviderUser $providerUser);
}

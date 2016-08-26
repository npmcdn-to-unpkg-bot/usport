<?php

namespace App\Services;

use App\Models\SocialAccount;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAccountService
{
    public function createOrGetUser(ProviderUser $providerUser)
    {
        $account = SocialAccount::whereProvider('facebook')
            ->whereProviderUserId($providerUser->getId())
            ->first();

        if ($account) {
            return $account->user;
        } else {

            $account = new SocialAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => 'facebook'
            ]);

            $user = \App\User::whereEmail($providerUser->getEmail())->first();

            if (!$user) {

                $user = \App\User::create([
                    'email' => $providerUser->getEmail(),
                    'name' => $providerUser->getName(),
                ]);
            }

            $account->user()->associate($user);
            $account->save();

            return $user;

        }

    }

    /**
     * if existed  email 
     * @param  [Object] $userInfo [description]
     * @return [user]           [description]
     */
    public function createUser ($userData) {

        \Log::info('userData:' . json_encode($userData));
        // if facebook_id exist => update with new userData
        $account = \App\User::whereFbUserId($userData['fb_user_id'])->first();

        if ($account) {
            $userUpdate = \App\User::where('id', $account->id)->update($userData);
            \Log::info('update old user:' . json_encode($account));
            return $account;
        }

        // if fb_id not exist => create user
        try {
            $account = \App\User::create($userData);
            \Log::info("create new user:" . json_encode($account));
        } catch (Exception $e) {
            return false;
        }

        return $account;
    }
}
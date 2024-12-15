<?php

namespace App\Services;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthPurchasePremiumRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Http\Requests\AuthUpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService extends AbstractService
{
    public function login(AuthLoginRequest $request): string
    {
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $credentials['email'])->firstOrFail();

        if (! Hash::check($credentials['password'], $user->password)) {
            abort(401, 'Invalid credentials');
        }

        return $user->createToken('default')->plainTextToken;
    }

    public function register(AuthRegisterRequest $request): string
    {
        $user = User::create($request->toCreateData());

        return $user->createToken('default')->plainTextToken;

    }

    public function getUser(User $user): User
    {
        return $user->load('savedPodcasts', 'likedEpisodes');
    }

    public function updateUser(AuthUpdateUserRequest $request): User
    {
        $user = $request->user();

        $user->update($request->validated());

        return $user;
    }

    public function purchasePremium(AuthPurchasePremiumRequest $request): bool
    {
        $user = $request->user();

        $user->update(['premium_until' => now()->addMonth()]);

        return true;
    }
}

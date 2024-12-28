<?php

namespace App\Services;

use App\Enums\AdminRole;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthPurchasePremiumRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Http\Requests\AuthUpdateUserRequest;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthService extends AbstractService
{
    public function login(AuthLoginRequest $request): string
    {
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
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

        $data = array_filter($request->validated());

        if (isset($data['image'])) {
            $user->image_url ? Storage::disk('public')->delete($user->image_url) : null;
            $data['image_url'] = $data['image']->storeAs('images', "photo_{$user->id}.".$data['image']->extension(), 'public');
        }

        $user->update($data);

        return $user;
    }

    public function purchasePremium(AuthPurchasePremiumRequest $request): bool
    {
        $user = $request->user();

        $user->update(['premium_until' => now()->addMonth()]);

        return true;
    }

    public function request(array $data)
    {
        $data['password'] = bcrypt($data['password']);
        Admin::create([
            ...$data,
            'role' => AdminRole::REQUESTER,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthPurchasePremiumRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Http\Requests\AuthUpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Response as AppResponse;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}

    public function login(AuthLoginRequest $request): JsonResponse
    {
        $token = $this->authService->login($request);

        return AppResponse::success(['token' => $token]);
    }

    public function register(AuthRegisterRequest $request): JsonResponse
    {
        $token = $this->authService->register($request);

        return AppResponse::success(['token' => $token]);
    }

    public function getUser(Request $request): JsonResponse
    {
        $user = $this->authService->getUser($request->user());

        return AppResponse::success(new UserResource($user));
    }

    public function updateUser(AuthUpdateUserRequest $request): JsonResponse
    {
        $user = $this->authService->updateUser($request);

        return AppResponse::success(new UserResource($user));
    }

    public function purchasePremium(AuthPurchasePremiumRequest $request): JsonResponse
    {
        abort_if($request->user()->havePremium, 400, 'You already have premium');

        // Simulate payment failure
        abort_if($request->card_number === '4242424242424242', 400, 'Payment failed');

        $this->authService->purchasePremium($request);

        return AppResponse::success(['message' => 'Premium purchased successfully']);
    }
}

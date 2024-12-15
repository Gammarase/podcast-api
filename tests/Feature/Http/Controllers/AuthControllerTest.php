<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AuthController
 */
final class AuthControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function login_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AuthController::class,
            'login',
            \App\Http\Requests\AuthLoginRequest::class
        );
    }

    #[Test]
    public function login_behaves_as_expected(): void
    {
        $response = $this->get(route('auths.login'));
    }

    #[Test]
    public function register_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AuthController::class,
            'register',
            \App\Http\Requests\AuthRegisterRequest::class
        );
    }

    #[Test]
    public function register_behaves_as_expected(): void
    {
        $response = $this->get(route('auths.register'));
    }

    #[Test]
    public function getUser_behaves_as_expected(): void
    {
        $response = $this->get(route('auths.getUser'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }

    #[Test]
    public function updateUser_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AuthController::class,
            'updateUser',
            \App\Http\Requests\AuthUpdateUserRequest::class
        );
    }

    #[Test]
    public function updateUser_behaves_as_expected(): void
    {
        $response = $this->get(route('auths.updateUser'));

        $auth->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);
    }

    #[Test]
    public function purchasePremium_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AuthController::class,
            'purchasePremium',
            \App\Http\Requests\AuthPurchasePremiumRequest::class
        );
    }

    #[Test]
    public function purchasePremium_behaves_as_expected(): void
    {
        $response = $this->get(route('auths.purchasePremium'));
    }
}

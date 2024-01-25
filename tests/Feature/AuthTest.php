<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Http\Response;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /**
     * check the app api is active and accessible or not
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * check if user is logged-in before
     */
    public function test_login_should_get_error_if_user_was_logged_in_before(): void
    {
        $credentials = ['mobile' => $this->user->mobile, 'password' => 'password'];

        $this->json('POST', route('auth.login'), $credentials);

        $response = $this->json('POST', route('auth.login'), $credentials);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    /**
     * check if user credential is wrong
     */
    public function test_login_should_get_error_if_user_credentials_are_wrong(): void
    {
        $wrongCredentials = ['mobile' => $this->user->mobile, 'password' => 'password123'];

        $response = $this->json('POST', route('auth.login'), $wrongCredentials);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * check if user credential is ok and user get 200
     */
    public function test_login_should_be_done_successfully(): void
    {
        $wrongCredentials = ['mobile' => $this->user->mobile, 'password' => 'password'];

        $response = $this->json('POST', route('auth.login'), $wrongCredentials);

        $response->assertStatus(Response::HTTP_OK);
    }
    
}

<?php

namespace Tests\Feature\Authentication;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase;
    private $registration_route = '/register';
    private $home_route = '/';

    public function test_registration_page_loaded_successfully()
    {
        $response = $this->get($this->registration_route);
        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
        $response->assertSee('register');
    }

    public function test_guest_user_can_register_new_account_successfully()
    {
        // Arrange
        $userData = [
            'name' => 'ahmed',
            'email' => 'ahmed@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        // Act
        $response = $this->post($this->registration_route, $userData);

        // Assert
        $response->assertStatus(302);
        $response->assertRedirect($this->home_route);
        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', [
            'email' => 'ahmed@gmail.com'
        ]);
    }

    public function test_throw_validation_error_if_guest_user_did_not_confirm_password()
    {
        // Arrange
        $userData = [
            'name' => 'ahmed',
            'email' => 'ahmed@gmail.com',
            'password' => 'password',
        ];

        // Act
        $response = $this->post($this->registration_route, $userData);

        // Assert
        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'password' => 'The password confirmation does not match.'
        ]);
    }

    function test_throw_validation_error_if_user_did_not_add_email()
    {
        // Arrange
        $userData = [
            'name' => 'ahmed',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        // Act
        $response = $this->post($this->registration_route, $userData);

        // Assert
        $response->assertSessionHasErrors([
            'email' => 'The email field is required.'
        ]);
    }
}

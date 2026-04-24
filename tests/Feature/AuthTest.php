<?php

namespace Tests\Feature;

use App\Mail\SendPasswordResetLinkMail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_guest_user_can_access_login_page()
    {
        $response = $this->get('/login');
        $response->assertViewIs('auth.login');
    }

    public function test_user_with_correct_credentials_can_login()
    {
        $user = User::factory()->create([
            'name' => 'ahmedfaisal',
            'email' => 'ahmedfaisal@gmail.com',
            'password' => bcrypt('password'),
            'user_as' => 'admin',
        ]);

        $response = $this->post('/login', [
            'email' => 'ahmedfaisal@gmail.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);

        if ($user->user_as === 'admin') {
            $response->assertRedirectToRoute('filament.admin.pages.dashboard');
        } elseif ($user->user_as === 'teacher') {
            $response->assertRedirectToRoute('teacher.index');
        } else {
            $response->assertRedirectToRoute('student.index');
        }
    }

    public function test_user_cannot_login_with_invalid_password()
    {
        User::factory()->create([
            'name' => 'ahmedfaisal',
            'email' => 'ahmedfaisal@gmail.com',
            'password' => bcrypt('password'),
            'user_as' => 'admin',
        ]);

        $response = $this->post('/login', [
            'email' => 'ahmedfaisal@gmail.com',
            'password' => '123456789',
        ]);

        $this->assertGuest();
        $response->assertRedirectBack();
        $response->assertSessionHas(['error' => 'Invalid Incredientials !']);
    }

    public function test_authenticated_user_can_logout()
    {
        $user = User::factory()->create([
            'name' => 'ahmedfaisal',
            'email' => 'ahmedfaisal@gmail.com',
            'password' => bcrypt('password'),
            'user_as' => 'admin',
        ]);

        $this->actingAs($user);

        $response = $this->post('/logout');

        $this->assertGuest();
        $response->assertRedirectToRoute('index');
    }

    public function test_guest_user_cannot_logout()
    {
        $response = $this->post('/logout');

        $this->assertGuest();
        $response->assertRedirectToRoute('index');
    }

    public function test_user_can_access_forgot_password_page()
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
        $response->assertSee('form');
        $response->assertSeeTextInOrder(['Forgot Password', 'Email Address', 'Send Password Reset Link']);
    }

    public function test_user_can_change_password_with_existing_email()
    {
        Mail::fake();

        User::factory()->create([
            'name' => 'ahmedfaisal',
            'email' => 'ahmedfaisal@gmail.com',
            'password' => bcrypt('password'),
            'user_as' => 'admin',
        ]);

        $response = $this->post('/forgot-password', ['email' => 'ahmedfaisal@gmail.com']);
        $this->assertDatabaseCount('password_reset_tokens', 1);

        $this->assertDatabaseHas('users', [
            'email' => 'ahmedfaisal@gmail.com',
        ]);
        Mail::assertSent(SendPasswordResetLinkMail::class, 'ahmedfaisal@gmail.com');
        $response->assertRedirectBack();
        $response->assertSessionHas('success', 'We have sent you an email with the reset link');
    }

    public function test_user_cannot_change_password_with_empty_email()
    {
        $response = $this->post('/forgot-password', ['email' => '']);
        $response->assertRedirectBack();
        $response->assertSessionHasErrors(['email']);
    }

    public function test_user_can_access_reset_password_page_with_valid_token()
    {
        $token = 'dummy-token';
        $response = $this->get("/reset-password/$token");
        $response->assertStatus(200);
        $response->assertViewIs('auth.passwords.reset-password');
    }

    public function test_user_can_reset_password_with_valid_email_and_password_and_token()
    {
        $user = User::factory()->create([
            'email' => 'ahmedfaisal@gmail.com',
        ]);

        $token = Password::createToken($user);

        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => $user->email,
        ]);

        $response = $this->post('/reset-password', [
            'email' => $user->email,
            'password' => '123456789',
            'password_confirmation' => '123456789',
            'token' => $token,
        ]);

        $this->assertDatabaseMissing('password_reset_tokens', [
            'email' => $user->email,
        ]);

        $response->assertRedirectToRoute('index');
        $response->assertSessionHas('success', 'Password reset successfully, you can login now');

        $this->assertTrue(
            Hash::check('123456789', $user->fresh()->password)
        );
    }

    public function test_user_cannot_reset_password_with_invalid_email_or_password_or_token()
    {
        $user = User::factory()->create([
            'email' => 'ahmedfaisal@gmail.com',
        ]);

        $token = Password::createToken($user);

        $response = $this->post('/reset-password', [
            'email' => 'ahmed@gmail.com',
            'password' => '123456780',
            'password_confirmation' => '123456789',
            'token' => $token,
        ]);

        $response->assertSessionHasErrors(['email', 'password']);

    }
}

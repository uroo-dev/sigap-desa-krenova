<?php

namespace Tests\Feature;

use App\Enums\RoleName;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AuthAndRoleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);
    }

    public function test_role_seeder_creates_roles_and_default_admin(): void
    {
        foreach (RoleName::cases() as $role) {
            $this->assertTrue(Role::where('name', $role->value)->exists());
        }

        $admin = User::where('email', 'admin@sigap.test')->first();
        $this->assertNotNull($admin);
        $this->assertTrue($admin->hasVerifiedEmail());
        $this->assertTrue($admin->hasRole(RoleName::ADMIN->value));
    }

    public function test_register_creates_user_with_masyarakat_role(): void
    {
        $response = $this->post('/register', [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'no_hp' => '08123456789',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();

        $user = User::where('email', 'budi@example.com')->first();
        $this->assertNotNull($user);
        $this->assertTrue($user->hasRole(RoleName::MASYARAKAT->value));
        $this->assertTrue($user->is_active);
    }

    public function test_active_user_can_login_and_logout(): void
    {
        $user = User::factory()->create([
            'email' => 'warga@example.com',
            'password' => bcrypt('rahasia123'),
            'is_active' => true,
        ]);
        $user->assignRole(RoleName::MASYARAKAT->value);

        $loginResponse = $this->post('/login', [
            'email' => 'warga@example.com',
            'password' => 'rahasia123',
        ]);

        $loginResponse->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);

        $logoutResponse = $this->post('/logout');
        $logoutResponse->assertRedirect(route('home'));
        $this->assertGuest();
    }

    public function test_inactive_user_cannot_login(): void
    {
        $user = User::factory()->create([
            'email' => 'nonaktif@example.com',
            'password' => bcrypt('rahasia123'),
            'is_active' => false,
        ]);

        $response = $this->post('/login', [
            'email' => 'nonaktif@example.com',
            'password' => 'rahasia123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_google_redirect_shows_error_when_oauth_credentials_missing(): void
    {
        config()->set('services.google.client_id', null);
        config()->set('services.google.client_secret', null);

        $response = $this->get(route('auth.google'));

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error');
    }

    public function test_google_redirect_points_to_oauth_provider(): void
    {
        config()->set('services.google.client_id', 'test-client-id');
        config()->set('services.google.client_secret', 'test-client-secret');
        Socialite::fake('google');

        $response = $this->get(route('auth.google'));

        $response->assertRedirect('https://socialite.fake/google/authorize');
    }

    public function test_google_callback_creates_masyarakat_user_and_logs_in(): void
    {
        config()->set('services.google.client_id', 'test-client-id');
        config()->set('services.google.client_secret', 'test-client-secret');

        $socialiteUser = (new SocialiteUser)->map([
            'id' => 'google-12345',
            'name' => 'Siti Aminah',
            'email' => 'siti.aminah@gmail.com',
            'avatar' => 'https://example.com/avatar.jpg',
        ]);

        Socialite::fake('google', $socialiteUser);

        $response = $this->get(route('auth.google.callback'));

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('success');
        $this->assertAuthenticated();

        $user = User::where('google_id', 'google-12345')->first();
        $this->assertNotNull($user);
        $this->assertSame('siti.aminah@gmail.com', $user->email);
        $this->assertTrue($user->hasRole(RoleName::MASYARAKAT->value));
        $this->assertNotNull($user->email_verified_at);
    }

    public function test_google_callback_links_existing_email_and_blocks_inactive_user(): void
    {
        config()->set('services.google.client_id', 'test-client-id');
        config()->set('services.google.client_secret', 'test-client-secret');

        $existing = User::factory()->create([
            'email' => 'existing@gmail.com',
            'google_id' => null,
            'is_active' => false,
        ]);

        $socialiteUser = (new SocialiteUser)->map([
            'id' => 'google-99999',
            'name' => 'Existing User',
            'email' => 'existing@gmail.com',
            'avatar' => 'https://example.com/avatar2.jpg',
        ]);

        Socialite::fake('google', $socialiteUser);

        $response = $this->get(route('auth.google.callback'));

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();

        $existing->refresh();
        $this->assertSame('google-99999', $existing->google_id);
    }

    public function test_dashboard_redirects_admin_to_admin_dashboard(): void
    {
        $admin = User::where('email', 'admin@sigap.test')->firstOrFail();

        $response = $this->actingAs($admin)->get(route('dashboard'));

        $response->assertRedirect(route('admin.dashboard'));
    }
}

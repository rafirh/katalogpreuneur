<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_mahasiswa_can_register_with_ub_email(): void
    {
        $response = $this->post('/register', [
            'name' => 'Budi Santoso',
            'email' => 'budi@ub.ac.id',
            'whatsapp_number' => '081234567890',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('mahasiswa.dashboard'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'budi@ub.ac.id',
            'role' => User::ROLE_MAHASISWA,
        ]);
    }

    public function test_mahasiswa_cannot_register_with_non_ub_email(): void
    {
        $response = $this->from('/register')->post('/register', [
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'whatsapp_number' => '081234567890',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
        $this->assertDatabaseMissing('users', ['email' => 'budi@gmail.com']);
    }

    public function test_user_can_login(): void
    {
        $user = User::factory()->create([
            'email' => 'siti@ub.ac.id',
            'password' => Hash::make('rahasia123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'siti@ub.ac.id',
            'password' => 'rahasia123',
        ]);

        $response->assertRedirect(route('mahasiswa.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_admin_login_redirects_to_admin_dashboard(): void
    {
        $admin = User::factory()->admin()->create([
            'email' => 'admin@ub.ac.id',
            'password' => Hash::make('rahasia123'),
        ]);

        $this->post('/login', ['email' => 'admin@ub.ac.id', 'password' => 'rahasia123'])
            ->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($admin);
    }

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/logout')->assertRedirect(route('home'));

        $this->assertGuest();
    }
}

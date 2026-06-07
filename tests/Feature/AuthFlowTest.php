<?php

namespace Tests\Feature;

use App\Models\User;
use App\Http\Middleware\VerifyCsrfToken;
use App\Services\Auth\LoginService;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class AuthFlowTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(VerifyCsrfToken::class);
    }

    public function test_login_page_is_available(): void
    {
        $response = $this->get('/login');

        $response->assertOk();
        $response->assertSee('MediTurno');
        $response->assertSee('Correo electrónico');
    }

    public function test_active_user_can_login_and_view_dashboard(): void
    {
        $storedUser = new class
        {
            public string $email = 'admin@example.com';

            public function isActive(): bool
            {
                return true;
            }
        };

        $this->app->instance(LoginService::class, new class($storedUser) extends LoginService {
            public function __construct(private object $storedUser)
            {
            }

            public function findByEmail(string $email): ?object
            {
                return $email === $this->storedUser->email ? $this->storedUser : null;
            }

            public function attempt(array $credentials, bool $remember = false): bool
            {
                return true;
            }
        });

        $response = $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('dashboard'));
    }

    public function test_inactive_user_cannot_login(): void
    {
        $storedUser = new class
        {
            public string $email = 'inactive@example.com';

            public function isActive(): bool
            {
                return false;
            }
        };

        $this->app->instance(LoginService::class, new class($storedUser) extends LoginService {
            public function __construct(private object $storedUser)
            {
            }

            public function findByEmail(string $email): ?object
            {
                return $email === $this->storedUser->email ? $this->storedUser : null;
            }

            public function attempt(array $credentials, bool $remember = false): bool
            {
                return true;
            }
        });

        $response = $this->post('/login', [
            'email' => 'inactive@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('email');
    }

    public function test_logout_closes_the_session(): void
    {
        $user = new User([
            'id' => 1,
            'name' => 'Personal',
            'email' => 'personal@example.com',
            'role' => 'personal',
            'active' => true,
        ]);

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect(route('login'));
    }

    public function test_dashboard_requires_authentication(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect(route('login'));
    }

    public function test_inactive_user_is_forced_out_of_dashboard(): void
    {
        $user = new User([
            'id' => 2,
            'name' => 'Personal Inactivo',
            'email' => 'inactive-personal@example.com',
            'role' => 'personal',
            'active' => false,
        ]);

        $this->actingAs($user);

        $response = $this->get('/dashboard');

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error', 'Tu cuenta está desactivada.');
    }

    public function test_dashboard_shows_admin_content_for_admin_role(): void
    {
        $user = new User([
            'id' => 3,
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'active' => true,
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertOk();
        $response->assertSee('Panel administrativo');
        $response->assertSee('Usuarios');
        $response->assertSee('Configuración');
    }

    public function test_role_middleware_blocks_unallowed_roles(): void
    {
        Route::middleware(['auth', 'active', 'role:admin'])->get('/test-role-gate', fn () => 'ok');

        $user = new User([
            'id' => 4,
            'name' => 'Personal',
            'email' => 'personal-gate@example.com',
            'role' => 'personal',
            'active' => true,
        ]);

        $response = $this->actingAs($user)->get('/test-role-gate');

        $response->assertStatus(403);
    }
}

<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\UserController
 */
final class UserControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $users = User::factory()->count(3)->create();

        $response = $this->get(route('users.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\UserController::class,
            'store',
            \App\Http\Requests\UserControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $dni = fake()->word();
        $name = fake()->name();
        $email = fake()->safeEmail();
        $phone = fake()->phoneNumber();
        $password = fake()->password();
        $validated = fake()->boolean();
        $cvu = fake()->word();
        $pending_balance = fake()->randomFloat(/** decimal_attributes **/);

        $response = $this->post(route('users.store'), [
            'dni' => $dni,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'password' => $password,
            'validated' => $validated,
            'cvu' => $cvu,
            'pending_balance' => $pending_balance,
        ]);

        $users = User::query()
            ->where('dni', $dni)
            ->where('name', $name)
            ->where('email', $email)
            ->where('phone', $phone)
            ->where('password', $password)
            ->where('validated', $validated)
            ->where('cvu', $cvu)
            ->where('pending_balance', $pending_balance)
            ->get();
        $this->assertCount(1, $users);
        $user = $users->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $user = User::factory()->create();

        $response = $this->get(route('users.show', $user));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\UserController::class,
            'update',
            \App\Http\Requests\UserControllerUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $user = User::factory()->create();
        $dni = fake()->word();
        $name = fake()->name();
        $email = fake()->safeEmail();
        $phone = fake()->phoneNumber();
        $password = fake()->password();
        $validated = fake()->boolean();
        $cvu = fake()->word();
        $pending_balance = fake()->randomFloat(/** decimal_attributes **/);

        $response = $this->put(route('users.update', $user), [
            'dni' => $dni,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'password' => $password,
            'validated' => $validated,
            'cvu' => $cvu,
            'pending_balance' => $pending_balance,
        ]);

        $user->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($dni, $user->dni);
        $this->assertEquals($name, $user->name);
        $this->assertEquals($email, $user->email);
        $this->assertEquals($phone, $user->phone);
        $this->assertEquals($password, $user->password);
        $this->assertEquals($validated, $user->validated);
        $this->assertEquals($cvu, $user->cvu);
        $this->assertEquals($pending_balance, $user->pending_balance);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $user = User::factory()->create();

        $response = $this->delete(route('users.destroy', $user));

        $response->assertNoContent();

        $this->assertModelMissing($user);
    }
}

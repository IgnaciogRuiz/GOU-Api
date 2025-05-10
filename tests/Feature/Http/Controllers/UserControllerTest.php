<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\UserController
 */
final class UserControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    // Prueba que la ruta index devuelva un 200 y una estructura JSON válida
    #[Test]
    public function index_behaves_as_expected(): void
    {
        // Crear 3 usuarios en la base de datos
        $users = User::factory()->count(3)->create();

        // Hacer una solicitud GET a la ruta index
        $response = $this->get(route('users.index'));

        // Comprobar que la respuesta sea exitosa
        $response->assertOk();

        // Comprobar que la respuesta tenga una estructura de arreglo
        $response->assertJsonStructure([
            '*' => ['id', 'dni', 'firstname', 'lastname', 'email', 'phone', 'validated', 'cvu', 'pending_balance'],
        ]);
    }

    // Verifica que el controlador use el FormRequest correspondiente para validar
    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\UserController::class,
            'store',
            \App\Http\Requests\UserStoreRequest::class
        );
    }

    // Verifica que el método store cree un usuario correctamente
    #[Test]
    public function store_saves(): void
    {
        // Datos simulados para crear un usuario
        $dni = fake()->regexify('[0-9]{8}');
        $firstname = fake()->firstName();
        $lastname = fake()->lastName();
        $email = fake()->safeEmail();
        $phone = fake()->phoneNumber();
        $password = 'password123';
        $validated = fake()->boolean();
        $cvu = fake()->regexify('[0-9]{22}');
        $pending_balance = 0;

        // Enviar solicitud POST para crear un nuevo usuario
        $response = $this->post(route('users.store'), [
            'dni' => $dni,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'phone' => $phone,
            'password' => $password,
            'validated' => $validated,
            'cvu' => $cvu,
            'pending_balance' => $pending_balance,
        ]);

        // Verificar que se haya creado un usuario en la base
        $this->assertDatabaseHas('users', [
            'dni' => $dni,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'phone' => $phone,
            'validated' => $validated,
            'cvu' => $cvu,
            'pending_balance' => $pending_balance,
        ]);

        // Confirmar que la respuesta tenga status 201 y la estructura esperada
        $response->assertCreated();
        $response->assertJsonStructure(['id', 'firstname', 'lastname', 'email']);
    }

    // Verifica que el método show funcione correctamente
    #[Test]
    public function show_behaves_as_expected(): void
    {
        $user = User::factory()->create();

        $response = $this->get(route('users.show', $user));

        $response->assertOk();
        $response->assertJsonStructure([
            'id',
            'dni',
            'firstname',
            'lastname',
            'email',
            'phone',
            'validated',
            'cvu',
            'pending_balance'
        ]);
    }

    // Verifica que el método update use su FormRequest
    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\UserController::class,
            'update',
            \App\Http\Requests\UserUpdateRequest::class
        );
    }

    // Verifica que el método update actualice correctamente un usuario
    #[Test]
    public function update_behaves_as_expected(): void
    {
        $user = User::factory()->create();

        $dni = fake()->regexify('[0-9]{8}');
        $firstname = fake()->firstName();
        $lastname = fake()->lastName();
        $email = fake()->safeEmail();
        $phone = fake()->phoneNumber();
        $password = 'newPass123';
        $validated = fake()->boolean();
        $cvu = fake()->regexify('[0-9]{22}');
        $pending_balance = 50;

        $response = $this->put(route('users.update', $user), [
            'dni' => $dni,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'phone' => $phone,
            'password' => $password,
            'validated' => $validated,
            'cvu' => $cvu,
            'pending_balance' => $pending_balance,
        ]);

        $user->refresh();

        $response->assertOk();
        $response->assertJsonStructure(['id', 'firstname', 'lastname', 'email']);

        // Verificar que los datos se hayan actualizado correctamente
        $this->assertEquals($dni, $user->dni);
        $this->assertEquals($firstname, $user->firstname);
        $this->assertEquals($lastname, $user->lastname);
        $this->assertEquals($email, $user->email);
        $this->assertEquals($phone, $user->phone);
        $this->assertTrue(Hash::check($password, $user->password));
        $this->assertEquals($validated, $user->validated);
        $this->assertEquals($cvu, $user->cvu);
        $this->assertEquals($pending_balance, $user->pending_balance);
    }

    // Verifica que se pueda eliminar un usuario
    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $user = User::factory()->create();

        $response = $this->delete(route('users.destroy', $user));

        $response->assertNoContent();
        $this->assertModelMissing($user);
    }
}

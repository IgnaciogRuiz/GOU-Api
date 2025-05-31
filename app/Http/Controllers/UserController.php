<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Dedoc\Scramble\Attributes\ExcludeAllRoutesFromDocs;

#[ExcludeAllRoutesFromDocs]

class UserController extends Controller
{
    /**
     * Show All Users
     * 
     * Muestra todos los usuarios
     */

    public function index(Request $request)
    {
        $users = User::all();

        return new UserCollection($users);
    }

    /**
     * Create User
     * 
     * Crea un usuario. Usar Register Request
     * @deprecated
     */

    public function store(Request $request)
    {
        $data = $request->validated();

        $user = new User();
        $user->dni = $data['dni'];
        $user->firstname = $data['firstname'];
        $user->lastname = $data['lastname'];
        $user->email = $data['email'];
        $user->phone = $data['phone'];
        $user->validated = $data['validated'];
        $user->cvu = $data['cvu'];
        $user->pending_balance = $data['pending_balance'];
        $user->password = bcrypt($data['password']);

        // Si se sube una foto
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('profile_photos', 'public');
            $user->profile_photo = $path;
        }

        $user->save();

        return new UserResource($user);
    }

    /**
     * Show User
     * 
     * Muestra un usuario especifico.
     */

    public function show(Request $request, User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update User
     * 
     * Actualiza un usuario especifico.
     */

    public function update(UserUpdateRequest $request, User $user)
    {
        $user->update($request->validated());

        return new UserResource($user);
    }

    /**
     * Delete User
     * 
     * Elimina un usuario especifico.
     */

    public function destroy(Request $request, User $user)
    {
        $user->delete();

        return response()->noContent();
    }
}

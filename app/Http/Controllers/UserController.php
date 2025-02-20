<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\Entity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return Inertia::render('Users/Index', ['items' => User::with(['roles', 'permissions'])->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Users/Create', ['roles' => Role::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'nom' => $request['nom'],
            'prenom' => $request['prenom'],
            'login' =>Str::lower($request['prenom'][0].Str::replace(' ','',$request['nom'])),
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        if($request->type==='admin'){
            $user->assignRole('Administrateur');
        }else{
            $user->assignRole($request['roles']);
            $user->entities()->sync($request['entities']);
        }
        return redirect()->route('users.index')->banner('Utilisateur ajouté avec succès!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $user->permissions;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return Inertia::render('Users/Edit', ['user' => $user, 'roles' => Role::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $user->nom = $request['nom'];
        $user->prenom = $request['prenom'];
        $user->email = $request['email'];
        $user->login = Str::lower($request['prenom'][0].Str::replace(' ','',$request['nom']));
        if ($request['password'] && $request['password'] == $request['password_confirmation']) {
            $user->password = Hash::make($request['password']);
        }
        $user->save();
        if($request->type==='admin'){
            $user->syncRoles('Administrateur');
            $user->entities()->sync([]);
        }else{
            $user->syncRoles($request['roles']);
            $user->entities()->sync($request['entities']);
        }
        return redirect()->route('users.index')->banner('Utilisateur modifié avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}

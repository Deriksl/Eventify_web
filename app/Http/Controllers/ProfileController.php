<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class ProfileController extends Controller
{
    // Muestra el perfil del usuario
    public function show()
    {
        $user = Auth::user(); // Obtén el usuario autenticado
        return view('profile', compact('user')); // Pasa el usuario a la vista
    }


    // Actualiza el perfil del usuario
    public function update(Request $request)
    {
        $user = Auth::user();
        if (!$user instanceof \App\Models\User) {
            return redirect()->route('login')->with('error', 'Debes estar autenticado para actualizar tu perfil.');
        }

        // Validar los datos
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:15',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ]);


        // Actualizar los campos del usuario
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->username = $request->username;

        // Manejar la subida de la foto de perfil
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        // Actualizar la contraseña si se proporciona
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Redirigir a la ruta 'profile' pasando el ID del usuario
        return redirect()->route('profile', ['user' => $user->id])->with('success', 'Perfil actualizado correctamente.');


    }
}

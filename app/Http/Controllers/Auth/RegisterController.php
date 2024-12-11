<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\registermail;
use App\Models\User;
use App\Notifications\WelcomeEmailNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validar los datos
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // Validar la contraseña
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Guardar el usuario
        $user = new User();
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);

        // Manejar la carga de la imagen de perfil
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path; // Guarda solo la ruta
        }

        // Guardar el usuario en la base de datos
// Guardar el usuario en la base de datos
        $user->save();

// Enviar correo o notificación
        Mail::to($user->email)->send(new registermail($user)); // Pasar el usuario al Mailable
// O
        $user->notify(new WelcomeEmailNotification()); // Si usas Notification

// Redirigir o mostrar un mensaje de éxito
        return redirect()->route('login')->with('success', 'Registro exitoso. Revisa tu correo para más información.');




    }
}

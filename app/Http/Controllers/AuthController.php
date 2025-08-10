<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function index() 
    {
        return view('modules.auth.login');
    }

    public function logear(Request $request)
    {
        $credenciales = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Correo invalido.'])->withInput();
        }
        if (!Hash::check($request->password, (string) $user->password)) {
            return back()->withErrors(['email' => 'Contraseña incorrecta.'])->withInput();
        }
        if (!$user->activo) {
            return back()->withErrors(['email' => 'Usuario inactivo.'])->withInput();
        }

        Auth::login($user);
        $request->session()->regenerate();

        return to_route('dashboard.index');
       
    }

    public function crearAdmin()
    {
        $usuario = User::where('email', 'Admin@gmail.com')->first();

        if (!$usuario) {
            User::create([
                'nombre' => 'Administrador',
                'email' => 'Admin@gmail.com',
                'password' => Hash::make('Admin1234'), 
                'rol' => 'Gerente',
            ]);

            return "Usuario administrador creado exitosamente.";
        }

        return "El usuario administrador ya existe. No es necesario crearlo nuevamente.";
    }


    public function logout()
    {
        Auth::logout();
        

        return to_route('login');
    }
}

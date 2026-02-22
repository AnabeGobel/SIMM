<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\usuario;



class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

  public function process(Request $request)
{
    $credentials = $request->validate([
    'email' => 'required|email',
    'password' => 'required'
]);

if (Auth::attempt([
    'email' => $credentials['email'],
    'password' => $credentials['password'],
    'ativo' => 1
])) {
    $request->session()->regenerate();

    if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.home');
    }

    return redirect()->route('operador.home2');
}

return back()->withErrors([
    'email' => 'Credenciais inválidas ou usuário inativo.'
]);

}

    public function logout(Request $request)
    {
       Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // Alterado de 'login' para 'login.index'
    return redirect()->route('login.index');
        
    }
    
}

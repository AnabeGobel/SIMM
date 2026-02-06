<?php


namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('adm.home');
    }

     public function perfilAdm()
{
    $usuario = auth()->user();
    return view('adm.adm', compact('usuario'));
}

public function atualizarperfilAdm(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:usuarios,email,' . auth()->id(),
        'telefone' => 'nullable|string|max:20',
    ]);

    $usuario = auth()->user();
    $usuario->update($request->only('name', 'email', 'telefone'));

    return back()->with('success', 'Perfil atualizado com sucesso');
}

public function atualizarFotoperfilAdm(Request $request)
{
    $request->validate([
        'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $usuario = auth()->user();

    // Apaga foto antiga
    if ($usuario->foto && Storage::disk('public')->exists($usuario->foto)) {
        Storage::disk('public')->delete($usuario->foto);
    }

    // Salva nova foto
    $path = $request->file('foto')->store('perfis', 'public');
    $usuario->update(['foto' => $path]);

    return back()->with('success', 'Foto atualizada com sucesso');
}

public function alterarSenhaperfilAdm(Request $request)
{
    $request->validate([
        'senha_atual' => 'required',
        'nova_senha' => 'required|min:8|confirmed',
    ]);

    $usuario = auth()->user();

    if (!Hash::check($request->senha_atual, $usuario->password)) {
        return back()->withErrors(['senha_atual' => 'Senha atual incorreta']);
    }

    $usuario->update(['password' => Hash::make($request->nova_senha)]);

    return back()->with('success', 'Senha alterada com sucesso');
}

public function excluirContaperfilAdm(Request $request)
{
    $usuario = auth()->user();

    auth()->logout();
    $usuario->delete();

    return redirect('/login')->with('success', 'Conta excluída com sucesso');
}

}


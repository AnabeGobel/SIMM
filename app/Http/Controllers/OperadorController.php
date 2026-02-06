<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Motoqueiro;
use Illuminate\Support\Facades\Hash;
class OperadorController extends Controller
{


   

 

    public function index(Request $request)
    {
        $query = Motoqueiro::with(['associacao', 'paragem', 'motos']);

        if ($request->filled('nome')) {
            $query->where('nome', 'like', '%' . $request->nome . '%');
        }

        if ($request->filled('cor_uniforme')) {
            $query->where('cor_uniforme', 'like', '%' . $request->cor_uniforme . '%');
        }

        if ($request->filled('associacao')) {
            $query->whereHas('associacao', fn ($q) =>
                $q->where('nome', 'like', '%' . $request->associacao . '%')
            );
        }

        if ($request->filled('paragem')) {
            $query->whereHas('paragem', fn ($q) =>
                $q->where('nome', 'like', '%' . $request->paragem . '%')
            );
        }

        if ($request->filled('numero_mota')) {
            $query->whereHas('motos', fn ($q) =>
                $q->where('numero_mota', 'like', '%' . $request->numero_mota . '%')
            );
        }

        if ($request->filled('placa')) {
            $query->whereHas('motos', fn ($q) =>
                $q->where('placa', 'like', '%' . $request->placa . '%')
            );
        }

        $motoqueiros = $query->get();

        return view('operation.home2', compact('motoqueiros'));
    }

   public function perfil()
{
    $usuario = auth()->user();
    return view('operation.perfil', compact('usuario'));
}

public function atualizarPerfil(Request $request)
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

public function atualizarFoto(Request $request)
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

public function alterarSenha(Request $request)
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

public function excluirConta(Request $request)
{
    $usuario = auth()->user();

    auth()->logout();
    $usuario->delete();

    return redirect('/login')->with('success', 'Conta excluída com sucesso');
}

}


    


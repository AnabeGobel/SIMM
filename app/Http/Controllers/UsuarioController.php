<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuarios;

class UsuarioController extends Controller
{
    
    // Lista todos os usuários
public function index(Request $request)
{
    // Captura o termo de busca
    $search = $request->input('q');

    // Inicia a query
    $query = Usuarios::query();

    // Se houver busca, filtra por nome ou email
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('email', 'LIKE', "%{$search}%");
        });
    }

    // Paginação (mantendo os filtros na URL da paginação)
    $usuarios = $query->paginate(10)->appends(['q' => $search]);

    // Totais (estatísticas costumam ignorar o filtro de busca para mostrar o geral)
    $totalAdmins = Usuarios::where('role', 'admin')->count();
    $totalOperadores = Usuarios::where('role', 'operador')->count();

    return view('Adm.usuario', compact('usuarios', 'totalAdmins', 'totalOperadores'));
}

    // Armazena um novo usuário
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email:rfc,dns|unique:usuarios,email',
            'password' => [
                'required',
                'confirmed', // compara com password_confirmation
                'min:8',
                'regex:/^(?=.*[A-Za-z])(?=.*\d).+$/'
            ],
            'role' => 'required|in:admin,operador',
            'ativo' => 'required|boolean',
        ], [
            'password.regex' => 'A senha deve conter pelo menos uma letra e um número.',
        ]);

                Usuarios::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'telefone' => $request->telefone, 
                'password' => Hash::make($request->password),
                'role'     => $request->role,
                'ativo'    => $request->ativo,
            ]);

        return redirect()->back()->with('success', 'Usuário registrado com sucesso!');
    }

    // Formulário de edição
    public function edit($id)
    {
        $usuario = Usuarios::findOrFail($id); // CORRETO: Usuarios
        return view('usuarios.edit', compact('usuario'));
    }

    // Atualiza usuário
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email,' . $id,
            'ativo' => 'required|boolean'
        ]);

        $usuario = Usuarios::findOrFail($id); // CORRETO: Usuarios
        $usuario->update([
            'name'  => $request->name,
            'email' => $request->email,
            'ativo' => $request->ativo
        ]);

        return redirect()->route('Adm.usuario')
                         ->with('success', 'Usuário atualizado com sucesso');
    }

    // Remove usuário (apenas operador)
    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $usuario = Usuarios::findOrFail($id); // CORRETO: Usuarios
        $usuario->delete();

        return redirect()->route('Adm.usuario')
                         ->with('success', 'Usuário removido');
    }
}

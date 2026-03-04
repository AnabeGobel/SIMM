<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\usuario;
use Cloudinary\Cloudinary;

class UsuarioController extends Controller
{
    
    // Lista todos os usuários
public function index(Request $request)
{
    // Captura o termo de busca
    $search = $request->input('q');

    // Inicia a query
    $query = usuario::query();

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
    $totalAdmins = usuario::where('role', 'admin')->count();
    $totalOperadores = usuario::where('role', 'operador')->count();

    return view('Adm.usuario', compact('usuarios', 'totalAdmins', 'totalOperadores'));
}

   // No método store
public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|string|min:6',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();
        
        // Upload Cloudinary
        if ($request->hasFile('foto')) {
            $cloudinary = new Cloudinary([
                'cloud' => [
                    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                    'api_key'    => env('CLOUDINARY_API_KEY'),
                    'api_secret' => env('CLOUDINARY_API_SECRET'),
                ],
                'url' => ['secure' => true],
            ]);

            $uploadResult = $cloudinary->uploadApi()->upload(
                $request->file('foto')->getRealPath(),
                ['folder' => 'usuarios']
            );

            $data['foto'] = $uploadResult['secure_url'];
        }

        $data['password'] = bcrypt($data['password']); // criptografa senha
        Usuario::create($data);

        return redirect()->back()->with('success', 'Usuário cadastrado com sucesso!');
    }


    // No método update
public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => "required|email|unique:usuarios,email,{$id}",
            'password' => 'nullable|string|min:6',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['name', 'email']);
        
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        if ($request->hasFile('foto')) {
            $cloudinary = new Cloudinary([
                'cloud' => [
                    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                    'api_key'    => env('CLOUDINARY_API_KEY'),
                    'api_secret' => env('CLOUDINARY_API_SECRET'),
                ],
                'url' => ['secure' => true],
            ]);

            $uploadResult = $cloudinary->uploadApi()->upload(
                $request->file('foto')->getRealPath(),
                ['folder' => 'usuarios']
            );

            $data['foto'] = $uploadResult['secure_url'];
        }

        $usuario->update($data);

        return redirect()->back()->with('success', 'Usuário atualizado com sucesso!');
    }

    // Remove usuário (apenas operador)
    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $usuario = usuario::findOrFail($id); // CORRETO: Usuarios
        $usuario->delete();

        return redirect()->route('Adm.usuario')
                         ->with('success', 'Usuário removido');
    }
}

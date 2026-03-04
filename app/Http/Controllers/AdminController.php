<?php


namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Cloudinary\Cloudinary;
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
    $data = [];

    if ($request->hasFile('foto')) {
        $cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key'    => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ],
            'url' => [
                'secure' => true
            ]
        ]);

        // Upload da nova foto
        $uploadResult = $cloudinary->uploadApi()->upload(
            $request->file('foto')->getRealPath(),
            ['folder' => 'perfis'] // pasta no Cloudinary
        );

        $data['foto'] = $uploadResult['secure_url'];
    }

    // Atualiza usuário com a nova foto
    $usuario->update($data);

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


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\associacao;

class AssociacaoController extends Controller
{
    /**
     * Lista todas as associações
     */
    public function index(Request $request)
{
    // 🔹 Pega a query de busca
    $q = $request->input('q');

    // 🔹 Busca associações pelo nome ou cor
    $associacoes = \App\Models\associacao::query()
        ->when($q, function($query) use ($q) {
            $query->where('nome', 'like', "%{$q}%")
                  ->orWhere('cor_uniforme', 'like', "%{$q}%");
        })
        ->orderBy('criado_em', 'desc')
        ->get();

    return view('Adm.associacao', compact('associacoes'));
}

    /**
     * Salva nova associação
     */
    public function store(Request $request)
    {
        // Validação dos dados do formulário
        $request->validate([
            'nome' => 'required|string|max:100',
            'responsavel' => 'required|string|max:100',
            'zona' => 'required|string|max:100',
            'cor_uniforme' => 'nullable|string|max:50',
            'estado' => 'required|boolean',
        ]);

        // Cria a associação no banco
        associacao::create($request->all());

        return redirect()->back()->with('success', 'Associação criada com sucesso!');
    }
    // Atualiza uma associação
        public function update(Request $request, $id)
        {
    // 🔹 Validação dos dados recebidos do formulário
    $request->validate([
        'nome' => 'required|string|max:100',
        'responsavel' => 'required|string|max:100',
        'zona' => 'required|string|max:100',
        'cor_uniforme' => 'nullable|string|max:50',
        'estado' => 'required|boolean',
    ]);

    // 🔹 Busca a associação pelo ID
    $associacao = associacao::findOrFail($id);

    // 🔹 Atualiza os dados da associação com os dados validados
    $associacao->update([
        'nome' => $request->nome,
        'responsavel' => $request->responsavel,
        'zona' => $request->zona,
        'cor_uniforme' => $request->cor_uniforme,
        'estado' => $request->estado,
    ]);

    // 🔹 Redireciona de volta para o painel com mensagem de sucesso
    return redirect()->back()->with('success', 'Associação atualizada com sucesso!');
}

// Remove uma associação
public function destroy($id)
{
    // 🔹 Busca a associação pelo ID ou falha com 404
    $associacao = associacao::findOrFail($id);

    // 🔹 Exclui a associação do banco
    $associacao->delete();

    // 🔹 Redireciona de volta para o painel com mensagem de sucesso
    return redirect()->back()->with('success', 'Associação removida com sucesso!');
}

}

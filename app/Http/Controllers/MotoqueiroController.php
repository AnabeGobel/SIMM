<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\motoqueiro;
use App\Models\moto;
use App\Models\associacao;
use App\Models\paragem;

class MotoqueiroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    $q = $request->q;

    // Pega todos os motoqueiros com relacionamentos
    $motoqueiros = motoqueiro::with('motos', 'associacao', 'paragem')
        ->when($q, function($query) use ($q) {
            $query->where('nome', 'like', "%{$q}%")
                  ->orWhere('cor_uniforme', 'like', "%{$q}%")
                  ->orWhereHas('associacao', function($a) use ($q) {
                      $a->where('nome', 'like', "%{$q}%");
                  });
        })
        ->orderBy('criado_em', 'desc')
        ->get();

    $associacoes = associacao::all();
    $paragens = paragem::all();

    return view('Adm.motoqueiro', compact('motoqueiros', 'associacoes', 'paragens'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $request->validate([
        'nome' => 'required|string|max:100',
        'data_nascimento' => 'required|date',
        'endereco' => 'required|string|max:150',
        'telefone' => 'required|string|max:20',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'cor_uniforme' => 'nullable|string|max:50',
        'associacao_id' => 'required|exists:associacoes,id',
        'paragem_id' => 'nullable|exists:paragens,id',
        'estado' => 'required|string|max:20',
    ]);

    $data = $request->all();

    // 🔹 Se existir foto, salvar no storage e atualizar o path
   if ($request->hasFile('foto')) {
    $path = $request->file('foto')->store('motoqueiros', 'public');
    $data['foto'] = $path; // EX: motoqueiros/GFfQqtSnFlUKSkbjLKgOkZrBI.jpg
}
    motoqueiro::create($data);

    return redirect()->back()->with('success', 'Motoqueiro cadastrado com sucesso!');
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, $id)
{
    $motoqueiro = motoqueiro::findOrFail($id);

    $request->validate([
        'nome' => 'required|string|max:100',
        'telefone' => 'required|string|max:20',
        'cor_uniforme' => 'nullable|string|max:50',
        'associacao_id' => 'required|exists:associacoes,id',
        'paragem_id' => 'nullable|exists:paragens,id',
        'estado' => 'required|string|max:20',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $data = $request->only([
        'nome',
        'telefone',
        'cor_uniforme',
        'associacao_id',
        'paragem_id',
        'estado',
    ]);

    // Atualizar foto se existir
    if ($request->hasFile('foto')) {
        $path = $request->file('foto')->store('motoqueiros', 'public');
        $data['foto'] = $path;
    }

    $motoqueiro->update($data);

    return redirect()->back()->with('success', 'Atualizado com sucesso');
}

 /**
     * Remove the specified resource from storage.
     */
public function destroy($id)
{
    motoqueiro::findOrFail($id)->delete();

    return redirect()->back()->with('success', 'Removido com sucesso');
}

   
    
}

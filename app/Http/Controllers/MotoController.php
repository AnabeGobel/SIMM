<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Moto;
use App\Models\Motoqueiro;

class MotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
 public function index(Request $request)
{
    //  Termo digitado na busca
    $q = $request->q;

    //  Busca motos com relacionamento e filtro
    $motos = Moto::with('motoqueiro')
        ->when($q, function ($query) use ($q) {
            $query->where('placa', 'like', "%{$q}%")
                  ->orWhere('marca', 'like', "%{$q}%")
                  ->orWhere('cor', 'like', "%{$q}%")
                  ->orWhereHas('motoqueiro', function ($mq) use ($q) {
                      $mq->where('nome', 'like', "%{$q}%");
                  });
        })
        ->orderBy('criado_em', 'desc')
        ->get();

    //  Todos os motoqueiros para popular o select do formulário
    $motoqueiros = Motoqueiro::orderBy('nome', 'asc')->get();

    return view('Adm.moto', compact('motos', 'motoqueiros'));
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
            'motoqueiro_id' => 'required|exists:motoqueiros,id',
            'marca' => 'required|string|max:50',
            'modelo' => 'nullable|string|max:50',
            'cor' => 'nullable|string|max:30',
            'placa' => 'required|string|max:20',
            'numero_mota' => 'required|string|max:50',
            'ano' => 'required|integer',
            'estado_legal' => 'required|string|max:20',
        ]);

        Moto::create($request->all());

        return redirect()->back()->with('success', 'Moto cadastrada com sucesso!');
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
    $moto = Moto::findOrFail($id);
    $moto->update($request->all());

    return redirect()->back()->with('success', 'Moto atualizada!');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    Moto::findOrFail($id)->delete();
    return redirect()->back()->with('success', 'Moto removida!');
}
}

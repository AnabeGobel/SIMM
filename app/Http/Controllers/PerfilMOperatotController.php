<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Motoqueiro;
use App\Models\Moto;
use App\Models\Associacao;
use App\Models\Paragem;
use App\Models\Ocorrencias;

class PerfilMOperatotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index(Request $request)
{
    $q = $request->q;
    $resultado = null;

    if ($q) {
        $resultado = Motoqueiro::with([
                'associacao',
                'paragem',
                'motos',
                'ocorrencias' // 👈 AQUI ESTÁ O SEGREDO
            ])
            ->where('nome', 'like', "%{$q}%")
            ->orWhereHas('motos', function ($query) use ($q) {
                $query->where('placa', 'like', "%{$q}%")
                      ->orWhere('numero_mota', 'like', "%{$q}%");
            })
            ->first();
    }

    return view('operation.perfiMo', compact('resultado'));
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
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;
use App\Models\Motoqueiro;
use App\Models\Moto;
use App\Models\Associacao;
use App\Models\Paragem;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    $totalMotoqueiros = Motoqueiro::count();
    $totalAssociacoes = Associacao::count();
    $totalParagens = Paragem::count();

    $ativos = Motoqueiro::where('estado', 'Ativo')->count();
    $inativos = Motoqueiro::where('estado', 'Inativo')->count();

    // Criar dados manuais para os gráficos
    $meses = ['Jan','Fev','Mar','Abr','Mai','Jun']; // meses fixos
    $novosRegistros = [5, 10, 8, 15, 12, 20]; // valores fictícios, você pode alterar

    return view('Adm.home', compact(
        'totalMotoqueiros',
        'totalAssociacoes',
        'totalParagens',
        'ativos',
        'inativos',
        'meses',
        'novosRegistros'
    ));
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
    public function search(Request $request)
{
    $q = $request->q;

    // 1️⃣ Motoqueiro
    if (Motoqueiro::where('nome', 'like', "%$q%")->exists()) {
        return redirect()->route('admin.motoqueiros.index', ['q' => $q]);
    }

    // 2️⃣ Moto (placa, marca, número)
    if (Moto::where('placa', 'like', "%$q%")
        ->orWhere('marca', 'like', "%$q%")
        ->orWhere('numero_mota', 'like', "%$q%")
        ->exists()) {
        return redirect()->route('motos.index', ['q' => $q]);
    }

    // 3️⃣ Associação
    if (Associacao::where('nome', 'like', "%$q%")->exists()) {
        return redirect()->route('associacao.index', ['q' => $q]);
    }

    return back()->with('error', 'Nenhum resultado encontrado.');
}

}

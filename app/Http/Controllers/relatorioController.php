<?php

namespace App\Http\Controllers;
use App\Models\Motoqueiro;
use App\Models\Moto;
use App\Models\Associacao;
use App\Models\Paragem;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
  use App\Models\Ocorrencias;



class relatorioController extends Controller
{
    /**
     * Display a listing of the resource.
     */


public function index(Request $request)
{
    // Motoqueiros
    $motoqueiros = Motoqueiro::with('associacao','paragem','motos')
        ->when($request->associacao_id, fn($q)=>$q->where('associacao_id',$request->associacao_id))
        ->when($request->estado, fn($q)=>$q->where('estado',$request->estado))
        ->orderBy('criado_em','desc')->get();

    // Ocorrências
    $ocorrencias = Ocorrencias::with('motoqueiro','operador')->orderBy('criado_em','desc')->get();

    $totalMotoqueiros = Motoqueiro::count();
    $ativos = Motoqueiro::where('estado','Ativo')->count();
    $inativos = Motoqueiro::where('estado','Inativo')->count();
    $totalAssociacoes = Associacao::count();
    $totalParagens = Paragem::count();
    $totalOcorrencias = Ocorrencias::count();

    // Gráfico meses
    $registrosPorMes = Motoqueiro::select(DB::raw('MONTH(criado_em) as mes'), DB::raw('COUNT(*) as total'))
        ->groupBy('mes')->orderBy('mes')->get();

    $nomeMeses = ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'];
    $meses = $registrosPorMes->pluck('mes')->map(fn($m)=>$nomeMeses[$m-1])->toArray();
    $novosRegistros = $registrosPorMes->pluck('total')->toArray();

    $associacoes = Associacao::all();

    return view('Adm.relatorios', compact(
        'motoqueiros','ocorrencias','totalMotoqueiros','ativos','inativos',
        'totalAssociacoes','totalParagens','totalOcorrencias','meses','novosRegistros','associacoes'
    ));
}
}
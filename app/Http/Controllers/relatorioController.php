<?php

namespace App\Http\Controllers;
use App\Models\motoqueiro;
use App\Models\moto;
use App\Models\associacao;
use App\Models\paragem;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
  use App\Models\ocorrencias;



class relatorioController extends Controller
{
    /**
     * Display a listing of the resource.
     */


public function index(Request $request)
{
    // Motoqueiros
    $motoqueiros = motoqueiro::with('associacao','paragem','motos')
        ->when($request->associacao_id, fn($q)=>$q->where('associacao_id',$request->associacao_id))
        ->when($request->estado, fn($q)=>$q->where('estado',$request->estado))
        ->orderBy('criado_em','desc')->get();

    // Ocorrências
    $ocorrencias = ocorrencias::with('motoqueiro','operador')->orderBy('criado_em','desc')->get();

    $totalMotoqueiros = motoqueiro::count();
    $ativos = motoqueiro::where('estado','Ativo')->count();
    $inativos = motoqueiro::where('estado','Inativo')->count();
    $totalAssociacoes = associacao::count();
    $totalParagens = paragem::count();
    $totalOcorrencias = ocorrencias::count();

    // Gráfico meses
    $registrosPorMes = motoqueiro::select(DB::raw('MONTH(criado_em) as mes'), DB::raw('COUNT(*) as total'))
        ->groupBy('mes')->orderBy('mes')->get();

    $nomeMeses = ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'];
    $meses = $registrosPorMes->pluck('mes')->map(fn($m)=>$nomeMeses[$m-1])->toArray();
    $novosRegistros = $registrosPorMes->pluck('total')->toArray();

    $associacoes = associacao::all();

    return view('Adm.relatorios', compact(
        'motoqueiros','ocorrencias','totalMotoqueiros','ativos','inativos',
        'totalAssociacoes','totalParagens','totalOcorrencias','meses','novosRegistros','associacoes'
    ));
}
}
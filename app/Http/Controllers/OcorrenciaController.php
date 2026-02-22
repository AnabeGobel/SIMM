<?php
namespace App\Http\Controllers;

use App\Models\ocorrencias;
use App\Models\motoqueiro;
use App\Models\usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OcorrenciaController extends Controller
{
    public function index()
    {
        $ocorrencias = ocorrencias::with(['motoqueiro', 'operador'])
            ->orderBy('criado_em', 'desc')
            ->get();

        $motoqueiros = motoqueiro::all();

        return view('operation.ocorrencia', compact('ocorrencias', 'motoqueiros'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'motoqueiro_id' => 'required',
            'tipo' => 'required',
            'descricao' => 'required',
            'local' => 'required',
            'data_ocorrencia' => 'required',
            'estado' => 'required'
        ]);

        ocorrencias::create([
            'motoqueiro_id' => $request->motoqueiro_id,
            'operador_id'    => Auth::id(),
            'tipo'          => $request->tipo,
            'descricao'     => $request->descricao,
            'local'         => $request->local,
            'data_ocorrencia'=> $request->data_ocorrencia,
            'estado'        => $request->estado
        ]);

        return redirect()->back()->with('success', 'Ocorrência registrada com sucesso!');
    }

    public function destroy($id)
    {
        ocorrencias::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Ocorrência removida!');
    }
}

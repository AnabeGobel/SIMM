@extends('layouts.app')

@section('title','SIMM - Relatórios')

@section('content')

<!-- Styles -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

<style>
    .card-summary { text-align: center; padding: 1.5rem; border-radius: .5rem; box-shadow: 0 .125rem .25rem rgba(0,0,0,.075); }
    .card-summary h3 { margin-top: .5rem; font-weight: 600; }
    canvas { max-width: 100%; height: 250px !important; }
    table th, table td { vertical-align: middle !important; }
</style>

<nav class="bg-white shadow-sm border-bottom">
    <div class="container py-2">
        <div class="text-center mb-2">
            <a class="fw-bold fs-4 text-dark text-decoration-none" href="#">SIMM</a>
        </div>
        <div class="d-flex justify-content-center mb-3">
            <ul class="nav flex-wrap justify-content-center">
                <li class="nav-item"><a class="nav-link px-3" href="{{route('admin.home')}}"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
                <li class="nav-item"><a class="nav-link active px-3" href="#"><i class="bi bi-bar-chart-line me-2"></i> Relatórios</a></li>
            </ul>
        </div>
    </div>
</nav>

<main class="container my-4">

<h2 class="text-primary mb-4">Relatórios Gerais</h2>

<!-- Filtros -->
<div class="card bg-light border-0 shadow-sm p-3 mb-4">
    <h6>Filtros</h6>
    <form method="GET" action="{{ route('Adm.relatorios') }}" class="row g-3">
        <div class="col-md-3">
            <label class="form-label">Associação</label>
            <select name="associacao_id" class="form-select">
                <option value="">Todas</option>
                @foreach($associacoes as $assoc)
                    <option value="{{ $assoc->id }}" {{ request('associacao_id') == $assoc->id ? 'selected' : '' }}>{{ $assoc->nome }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Status</label>
            <select name="estado" class="form-select">
                <option value="">Todos</option>
                <option value="Ativo" {{ request('estado') == 'Ativo' ? 'selected' : '' }}>Ativo</option>
                <option value="Inativo" {{ request('estado') == 'Inativo' ? 'selected' : '' }}>Inativo</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">De</label>
            <input type="date" name="de" value="{{ request('de') }}" class="form-control">
        </div>
        <div class="col-md-3">
            <label class="form-label">Até</label>
            <input type="date" name="ate" value="{{ request('ate') }}" class="form-control">
        </div>
        <div class="col-12 text-end">
            <button type="submit" class="btn btn-primary loc2">Filtrar</button>
            <a href="{{ route('Adm.relatorios') }}" class="btn btn-secondary">Limpar</a>
        </div>
    </form>
</div>

<!-- Cards de Resumo -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card-summary bg-white">
            <i class="bi bi-person-badge fs-2 text-primary"></i>
            <h3>{{ $totalMotoqueiros }}</h3>
            <small>Motoqueiros cadastrados</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-summary bg-white">
            <i class="bi bi-people-fill fs-2 text-success"></i>
            <h3>{{ $totalAssociacoes }}</h3>
            <small>Associações ativas</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-summary bg-white">
            <i class="bi bi-geo-alt-fill fs-2 text-warning"></i>
            <h3>{{ $totalParagens }}</h3>
            <small>Paragens registradas</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-summary bg-white">
            <i class="bi bi-check-circle fs-2 text-success"></i>
            <h3>{{ $ativos }} / {{ $inativos }}</h3>
            <small>Ativos / Inativos</small>
        </div>
    </div>
    <div class="col-md-3 mt-3">
        <div class="card-summary bg-white">
            <i class="bi bi-exclamation-circle fs-2 text-danger"></i>
            <h3>{{ $totalOcorrencias }}</h3>
            <small>Ocorrências Registradas</small>
        </div>
    </div>
</div>

<!-- Gráficos -->
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm p-3">
            <h6>Ativos vs Inativos</h6>
            <canvas id="ativosInativosChart"></canvas>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm p-3">
            <h6>Novos registros por mês</h6>
            <canvas id="novosRegistrosChart"></canvas>
        </div>
    </div>
</div>

<!-- Tabela detalhada de Motoqueiros -->
<div class="card border-0 shadow-sm p-3 mb-4">
    <h6>Motoqueiros Detalhados</h6>
    <table id="motoqueirosTable" class="display nowrap table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Associação</th>
                <th>Paragem</th>
                <th>Status</th>
                <th>Data de Registro</th>
                <th>Número de Motos</th>
            </tr>
        </thead>
        <tbody>
            @foreach($motoqueiros as $m)
            <tr>
                <td>{{ $m->id }}</td>
                <td>{{ $m->nome }}</td>
                <td>{{ $m->associacao->nome ?? '-' }}</td>
                <td>{{ $m->paragem->nome ?? '-' }}</td>
                <td>{{ $m->estado }}</td>
                <td>{{ $m->criado_em->format('d/m/Y') }}</td>
                <td>{{ $m->motos->count() }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Tabela de Ocorrências -->
<div class="card border-0 shadow-sm p-3 mb-4">
    <h6>Ocorrências Registradas</h6>
    <table id="ocorrenciasTable" class="display nowrap table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Motoqueiro</th>
                <th>Operador</th>
                <th>Descrição</th>
                <th>Status</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ocorrencias as $o)
            <tr>
                <td>{{ $o->id }}</td>
                <td>{{ $o->motoqueiro->nome ?? '-' }}</td>
                <td>{{ $o->operador->nome ?? $o->operador->email ?? '-' }}</td>
                <td>{{ $o->descricao }}</td>
                <td>{{ $o->status }}</td>
                <td>{{ \Carbon\Carbon::parse($o->criado_em)->format('d/m/Y') }}</td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>

</main>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- DataTables e botões export -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script>
    // Charts
    const ativos = @json($ativos);
    const inativos = @json($inativos);
    const meses = @json($meses);
    const novosRegistros = @json($novosRegistros);

    new Chart(document.getElementById('ativosInativosChart'), {
        type: 'bar',
        data: { labels: ['Ativos','Inativos'], datasets:[{label:'Motoqueiros', data:[ativos,inativos], backgroundColor:['#198754','#dc3545']}] },
        options: { indexAxis:'y', responsive:true, plugins:{legend:{display:false}} }
    });

    new Chart(document.getElementById('novosRegistrosChart'), {
        type:'line',
        data:{ labels: meses, datasets:[{label:'Novos Registros', data:novosRegistros, borderColor:'#0A1F44', backgroundColor:'rgba(10,31,68,0.2)', fill:true, tension:0.3}] },
        options:{ responsive:true, plugins:{legend:{position:'bottom'}} }
    });

    // DataTables com exportação
    $('#motoqueirosTable, #ocorrenciasTable').DataTable({
        dom: 'Bfrtip',
        buttons: ['copy','csv','excel','pdf','print'],
        scrollX:true
    });
</script>

@endsection

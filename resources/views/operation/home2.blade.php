@extends('layouts.app')

@section('title','SIMM - Operador | Pesquisa Rápida')

@section('content')
<style>

    
 /* Menu lateral branco com altura ajustada */
    .sidebar {
    background-color: #fff;
    border-right: 1px solid #dee2e6;
    box-shadow: 2px 0 5px rgba(0,0,0,0.05);
    height: 100vh;
    padding-top: 3rem;
}

.sidebar h4 {
    color: #0A1F44;
    font-weight: 700;
    margin-left: 1rem;
}

.sidebar .nav-link {
    color: #0A1F44;
    padding: 0.75rem 1rem;
    font-weight: 500;
}

.sidebar .nav-link:hover {
    background-color: #f1f3f5;
    border-left: 3px solid #0A1F44;
}

.offcanvas .nav-link {
    padding: 0.5rem 0;
}
    /* Conteúdo principal */
    .content {
        background-color: #f8f9fa;
        min-height: 100vh;
        padding-top: 3.5em !important;
        padding: 1.5rem;
    }
    .search-bar {
        margin-bottom: 1rem;
    }
    .status-regular { color: #198754; font-weight: 600; }
    .status-irregular { color: #dc3545; font-weight: 600; }
    .status-suspeito { color: #ffc107; font-weight: 600; }
</style>

    

<div class="container-fluid">
    <div class="row"> <!-- row obrigatória -->

        <!-- Menu lateral desktop -->
        <div class="d-none d-md-block col-md-3 col-lg-2 sidebar">
            <h4>SIMM Operador</h4>
            <ul class="nav flex-column mt-4">
                <li class="nav-item"><a class="nav-link" href="{{ route('operador.home2') }}"><i class="bi bi-search me-2"></i> Pesquisa</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('operation.perfiMo') }}"><i class="bi bi-person-badge me-2"></i> Motoqueiro</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('operation.relatorio') }}"><i class="bi bi-bar-chart-line me-2"></i> Relatório</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('operador.ocorrencia') }}"><i class="bi bi-clock-history me-2"></i> Ocorrência</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('perfil') }}"><i class="bi bi-person-badge me-2"></i> Perfil Completo</a></li>
                <li class="nav-item mt-3">
                    <form method="GET" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100"><i class="bi bi-box-arrow-right me-1"></i> Sair</button>
                    </form>
                </li>
            </ul>
        </div>

        <!-- Offcanvas para mobile -->
        <div class="d-md-none">
            <button class="btn btn-primary mb-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
                <i class="bi bi-list"></i> Menu
            </button>

            <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title">SIMM Operador</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="nav flex-column">
                        <li class="nav-item"><a class="nav-link" href="{{ route('operador.home2') }}"><i class="bi bi-search me-2"></i> Pesquisa</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('operation.perfiMo') }}"><i class="bi bi-person-badge me-2"></i> Motoqueiro</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('operation.relatorio') }}"><i class="bi bi-bar-chart-line me-2"></i> Relatório</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('operador.ocorrencia') }}"><i class="bi bi-clock-history me-2"></i> Ocorrência</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('perfil') }}"><i class="bi bi-person-badge me-2"></i> Perfil Completo</a></li>
                        <li class="nav-item mt-3">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger w-100"><i class="bi bi-box-arrow-right me-1"></i> Sair</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Conteúdo principal -->
          <div class="col-md-9 col-lg-10 content">
            <h3 class="text-primary mb-3">Pesquisa Rápida</h3>

            <!-- Barra de pesquisa -->
           <form class="row g-3 mb-4 search-bar" method="GET" action="{{ route('operador.home2') }}">

            <div class="col-md-4">
                <input type="text" name="nome" class="form-control" placeholder="Nome">
            </div>

            <div class="col-md-4">
                <input type="text" name="numero_mota" class="form-control" placeholder="Número da Moto">
            </div>

            <div class="col-md-4">
                <input type="text" name="placa" class="form-control" placeholder="Placa">
            </div>

            <div class="col-md-4">
                <input type="text" name="associacao" class="form-control" placeholder="Associação">
            </div>

            <div class="col-md-4">
                <input type="text" name="paragem" class="form-control" placeholder="Paragem">
            </div>

            <div class="col-md-4">
                <input type="text" name="cor_uniforme" class="form-control" placeholder="Cor do Uniforme">
            </div>

            <div class="col-12">
                <button class="btn btn-primary w-100 loc2" >
                    <i class="bi bi-search me-1"></i> Buscar
                </button>
            </div>
</form>



            <!-- Resultados em tabela -->
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                   <tbody>
                    @forelse($motoqueiros as $m)
                    @php $moto = $m->motos->first(); @endphp
                    <tr>
                        <td>{{ $m->nome }}</td>
                        <td>{{ $m->telefone }}</td>
                        <td>{{ $moto->marca ?? '-' }}</td>
                        <td>{{ $m->associacao->nome ?? '-' }}</td>
                        <td>{{ $m->paragem->nome ?? '-' }}</td>
                        <td>{{ $moto->placa ?? '-' }}</td>
                        <td>
                            <span class="badge bg-success">{{ $m->estado }}</span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-info"
                                    data-bs-toggle="modal"
                                    data-bs-target="#viewMotoqueiroModal{{ $m->id }}">
                                <i class="bi bi-eye"></i> Visualizar
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">
                            Nenhum resultado encontrado
                        </td>
                    </tr>
                    @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Visualizar Motoqueiro -->
@foreach($motoqueiros as $m)
@php $moto = $m->motos->first(); @endphp

<div class="modal fade" id="viewMotoqueiroModal{{ $m->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Detalhes do Motoqueiro</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body row g-3">
                <div class="col-md-4 text-center">
                    <img src="{{ $m->foto ? asset('storage/' . $m->foto) : asset('images/default-user.png') }}"
                         class="img-fluid rounded"
                         alt="Foto de {{ $m->nome }}">
                </div>

                <div class="col-md-8">
                    <p><strong>Nome:</strong> {{ $m->nome }}</p>
                    <p><strong>Número da Moto:</strong> {{ $moto->numero_mota ?? '-' }}</p>
                    <p><strong>Placa:</strong> {{ $moto->placa ?? '-' }}</p>
                    <p><strong>Associação:</strong> {{ $m->associacao->nome ?? '-' }}</p>
                    <p><strong>Paragem:</strong> {{ $m->paragem->nome ?? '-' }}</p>
                    <p><strong>Cor do Uniforme:</strong> {{ $m->cor_uniforme ?? '-' }}</p>
                    <p><strong>Status:</strong> {{ $m->estado }}</p>
                    <p><strong>Telefone:</strong> {{ $m->telefone }}</p>
                    <p><strong>Endereço:</strong> {{ $m->endereco }}</p>
                </div>
            </div>

        </div>
    </div>
</div>
@endforeach

@endsection

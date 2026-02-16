@extends('layouts.app')

@section('title','SIMM - Operador | Perfil Completo')

@section('content')

<style>
:root {
    --primary-color: #0d6efd;
    --muted-color: #6c757d;
}

/* Menu lateral desktop */
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

/* Perfil */
h3.page-title { font-size: 1.6rem; font-weight: 600; color: var(--primary-color); }
h5.sub-title { font-size: 1rem; font-weight: 600; }

.profile-card {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    padding: 1.5rem;
    margin-bottom: 2rem;
    transition: box-shadow 0.2s ease-in-out;
}

.profile-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
}

.status-regular { color: #198754; font-weight: 600; }
.status-irregular { color: #dc3545; font-weight: 600; }
.status-suspeito { color: #ffc107; font-weight: 600; }

@media (max-width: 768px) {
    h3.page-title { font-size: 1.2rem; }
    .profile-card { padding: 1rem; }
    .profile-card img { max-width: 100px; }
    .btn { width: 100%; margin-bottom: 0.5rem; }
    .table-responsive { font-size: 0.85rem; }
}
</style>

<div class="container-fluid">
    <div class="row">

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

        <!-- Offcanvas / menu mobile -->
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

            <h3 class="page-title mb-4">Perfil Completo do Motoqueiro</h3>

            <!-- Busca -->
            <form class="d-flex flex-wrap mb-4" role="search"
                method="GET" action="{{ route('operation.perfiMo') }}">
                <div class="input-group flex-grow-1 me-2 mb-2">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input class="form-control" type="search" name="q" value="{{ request('q') }}" placeholder="Nome, placa ou nº da moto" aria-label="Buscar motoqueiro">
                </div>
                <button class="btn btn-outline-primary mb-2 loc1" type="submit">Buscar</button>
            </form>

            <!-- Perfil -->
            <div class="profile-card row g-3 align-items-center">
                <div class="col-md-4 text-center">
                    <img src="{{ optional($resultado)->foto ? asset('storage/' . $resultado->foto) : asset('images/default-user.png') }}"
                         class="img-fluid rounded" alt="Foto de {{ $resultado->nome ?? 'motoqueiro' }}" loading="lazy">
                </div>
                <div class="col-md-8">
                    @if($resultado)
                        <h5>{{ $resultado->nome }} <span class="badge bg-success">{{ $resultado->estado }}</span></h5>
                        <p><strong>Data Nascimento:</strong> {{ \Carbon\Carbon::parse($resultado->data_nascimento)->format('d/m/Y') }}</p>
                        <p><strong>Telefone:</strong> {{ $resultado->telefone }}</p>
                        <p><strong>Endereço:</strong> {{ $resultado->endereco }}</p>
                        <hr>
                        <p><strong>Paragem:</strong> {{ optional($resultado->paragem)->nome ?? '-' }}, {{ optional($resultado->paragem)->bairro ?? '-' }}</p>
                        <hr>
                        <p><strong>Cor do Colete:</strong> {{ $resultado->cor_uniforme ?? '-' }}</p>
                        <hr>
                        @php $moto = $resultado->motos->first(); @endphp
                        <p><strong>Placa:</strong> {{ $moto->placa ?? '-' }}</p>
                        <p><strong>Número da Moto:</strong> {{ $moto->numero_mota ?? '-' }}</p>
                        <p><strong>Marca:</strong> {{ $moto->marca ?? '-' }}</p>
                        <p><strong>Modelo:</strong> {{ $moto->modelo ?? '-' }}</p>
                        <hr>
                        <p><strong>Associação:</strong> {{ optional($resultado->associacao)->nome ?? '-' }}</p>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="bi bi-person-x fs-1 mb-3 d-block"></i>
                            <h5 class="sub-title">Nenhum motoqueiro selecionado</h5>
                            <p>Utilize o campo de busca acima para localizar um motoqueiro.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Histórico de Ocorrências -->
            <h5 class="mb-3">Histórico de Ocorrências</h5>
            <div class="table-responsive mb-4">
                <table class="table table-hover align-middle">
                    <tbody>
@if($resultado && $resultado->ocorrencias->count())
    @foreach($resultado->ocorrencias as $ocorrencia)
        <tr>
           <td>{{ \Carbon\Carbon::parse($ocorrencia->criado_em)->format('d/m/Y') }}</td>
            <td>{{ $ocorrencia->descricao }}</td>
            <td>
                @if($ocorrencia->status === 'regular')
                    <span class="status-regular">
                        <i class="bi bi-check-circle me-1"></i> Regular
                    </span>
                @elseif($ocorrencia->status === 'irregular')
                    <span class="status-irregular">
                        <i class="bi bi-x-circle me-1"></i> Irregular
                    </span>
                @else
                    <span class="status-suspeito">
                        <i class="bi bi-exclamation-triangle me-1"></i> Suspeito
                    </span>
                @endif
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="3" class="text-center text-muted py-3">
            <i class="bi bi-info-circle me-1"></i>
            Nenhuma ocorrência registrada
        </td>
    </tr>
@endif
</tbody>

                </table>
            </div>

        </div> <!-- fim conteúdo principal -->

    </div> <!-- fim row -->
</div> <!-- fim container-fluid -->

@endsection

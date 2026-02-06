@extends('layouts.app')

@section('title','SIMM | Registro de Ocorrências')

@section('content')
<style>
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

    .content {
        background-color: #f8f9fa;
        min-height: 100vh;
        padding: 1.5rem;
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
                    <form method="GET" action="{{ route('login.index') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100"><i class="bi bi-box-arrow-right me-1"></i> Sair</button>
                    </form>
                </li>
            </ul>
        </div>

        {{-- MENU MOBILE (OFFCANVAS) --}}
        <div class="d-md-none mb-3">
            <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#menuMobile">
                <i class="bi bi-list"></i> Menu
            </button>
        </div>

        <div class="offcanvas offcanvas-start" tabindex="-1" id="menuMobile">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">SIMM Operador</h5>
                <button class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>

            <div class="offcanvas-body">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('operador.home2') }}">Pesquisa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('operation.perfiMo') }}">Motoqueiro</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('operador.ocorrencia') }}">Ocorrências</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('perfil') }}">Perfil</a>
                    </li>
                    <li class="nav-item mt-3">
                        <form method="POST" action="{{ route('login.index') }}">
                            @csrf
                            <button class="btn btn-outline-danger w-100">Sair</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        {{-- CONTEÚDO PRINCIPAL --}}
        <div class="col-md-9 col-lg-10 content">

            <div class="d-flex justify-content-between mb-3">
                <h4 class="text-primary">Registro de Ocorrências</h4>

                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalRegistro">
                    <i class="bi bi-plus-circle"></i> Registrar
                </button>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Motoqueiro</th>
                            <th>Tipo</th>
                            <th>Local</th>
                            <th>Data</th>
                            <th>Estado</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($ocorrencias as $ocorrencia)
                            <tr>
                                <td>{{ $ocorrencia->id }}</td>
                                <td>{{ $ocorrencia->motoqueiro->nome ?? '-' }}</td>
                                <td>{{ $ocorrencia->tipo }}</td>
                                <td>{{ $ocorrencia->local }}</td>
                                <td>{{ \Carbon\Carbon::parse($ocorrencia->data_ocorrencia)->format('d/m/Y H:i') }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $ocorrencia->estado }}</span>
                                </td>
                                <td>
                                    <form method="POST"
                                          action="{{ route('operador.ocorrencias.destroy', $ocorrencia->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Deseja remover?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    Nenhuma ocorrência registrada
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalRegistro" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <form method="POST" action="{{ route('operador.ocorrencias.store') }}">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Ocorrência</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body row g-3">

                <div class="col-md-6">
                    <label>Motoqueiro</label>
                    <select name="motoqueiro_id" class="form-select" required>
                        <option disabled selected>Selecione...</option>
                        @foreach($motoqueiros as $m)
                            <option value="{{ $m->id }}">{{ $m->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Tipo</label>
                    <select name="tipo" class="form-select" required>
                        <option>Furto</option>
                        <option>Multa</option>
                        <option>Advertência</option>
                        <option>Apreensão</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Local</label>
                    <input type="text" name="local" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label>Data da Ocorrência</label>
                    <input type="datetime-local" name="data_ocorrencia" class="form-control" required>
                </div>

                <div class="col-12">
                    <label>Descrição</label>
                    <textarea name="descricao" class="form-control" rows="3" required></textarea>
                </div>

                <div class="col-md-6">
                    <label>Estado</label>
                    <select name="estado" class="form-select">
                        <option>Aberto</option>
                        <option>Em análise</option>
                        <option>Resolvido</option>
                    </select>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </form>
  </div>
</div>
@endsection


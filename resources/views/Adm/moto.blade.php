@extends('layouts.app')

@section('title','SIMM - Administrador | Motos')

@section('content')
<style>
    th {
        font-weight: 600;
        color: #0A1F44;
    }
    .btn-action {
        font-size: 0.8rem;
    }
    @media (max-width: 768px) {
        h3.text-primary {
            font-size: 1.2rem;
        }
        .btn {
            font-size: 0.8rem;
        }
        .nav .nav-link {
            padding: 0.25rem 0.5rem;
            font-size: 0.85rem;
        }
        .pagination {
            flex-wrap: wrap;
        }
    }
</style>

<nav class="bg-white shadow-sm border-bottom">
    <div class="container py-2">
        <div class="text-center mb-2">
            <a class="fw-bold fs-4 text-dark text-decoration-none" href="#">SIMM</a>
        </div>
        <div class="d-flex justify-content-center mb-3">
            <ul class="nav flex-wrap justify-content-center">
                <li class="nav-item"><a class="nav-link px-3" href="{{route('admin.home')}}"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
                <li class="nav-item"><a class="nav-link active px-3" href="#"><i class="bi bi-bicycle me-2"></i> Motos</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Conteúdo -->
<main class="container my-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <h3 class="text-primary mb-2">Lista de Motos</h3>
        <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addMotoModal">
            <i class="bi bi-plus-circle me-1"></i> Adicionar Moto
        </button>
    </div>

    <!-- Busca -->
    <form class="d-flex mb-3 flex-wrap" role="search" method="GET" action="{{  route('admin.motos.index') }}">
    <input
        class="form-control me-2 mb-2 flex-grow-1"
        type="search"
        name="q"
        value="{{ request('q') }}"
        placeholder="Buscar por placa, motoqueiro, marca ou cor..."
    >
    <button class="btn btn-outline-primary mb-2 loc" type="submit">
        <i class="bi bi-search"></i>
    </button>
</form>


    <!-- Tabela responsiva -->
    <div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Motoqueiro</th>
                <th>Marca</th>
                <th>Número</th>
                <th>Placa</th>
                <th>Cor</th>
                <th>Modelo</th>
                <th>Estado</th>
                <th>Data</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        @foreach($motos as $moto)
            <tr>
                <td>{{ $moto->motoqueiro->nome }}</td>
                <td>{{ $moto->marca }}</td>
                <td>{{ $moto->numero_mota }}</td>
                <td>{{ $moto->placa }}</td>
                <td>{{ $moto->cor }}</td>
                <td>{{ $moto->modelo }}</td>
                <td>
                    <span class="badge {{ $moto->estado_legal == 'Ativa' ? 'bg-success' : 'bg-danger' }}">
                        {{ $moto->estado_legal }}
                    </span>
                </td>
                <td>{{ \Carbon\Carbon::parse($moto->criado_em)->format('d/m/Y') }}</td>
                <td>

                    <!-- VISUALIZAR -->
                    <button class="btn btn-sm btn-outline-info btn-action"
                        data-bs-toggle="modal"
                        data-bs-target="#viewMotoModal{{ $moto->id }}">
                        <i class="bi bi-eye"></i>
                    </button>

                    <!-- EDITAR -->
                    <button class="btn btn-sm btn-outline-warning btn-action"
                        data-bs-toggle="modal"
                        data-bs-target="#editMotoModal{{ $moto->id }}">
                        <i class="bi bi-pencil"></i>
                    </button>

                    <!-- REMOVER -->
                    <form action="{{ route('admin.motos.destroy', $moto->id) }}"
                          method="POST"
                          class="d-inline"
                          onsubmit="return confirm('Remover esta moto?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger btn-action">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>


    
</main>

<!--MODAL VISUALIZAR-->
@foreach($motos as $moto)
<div class="modal fade" id="viewMotoModal{{ $moto->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Detalhes da Moto</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body row g-3">
                <div class="col-md-4 text-center">
                 <img src="{{ $moto->motoqueiro->foto 
            ? asset('storage/' . $moto->motoqueiro->foto) 
            : asset('images/default-user.png') }}" 
     class="img-fluid rounded" 
     alt="Foto do Motoqueiro">





                </div>

                <div class="col-md-8">
                    <p><strong>Motoqueiro:</strong> {{ $moto->motoqueiro->nome }}</p>
                    <p><strong>Marca:</strong> {{ $moto->marca }}</p>
                    <p><strong>Número:</strong> {{ $moto->numero_mota }}</p>
                    <p><strong>Placa:</strong> {{ $moto->placa }}</p>
                    <p><strong>Cor:</strong> {{ $moto->cor }}</p>
                    <p><strong>Modelo:</strong> {{ $moto->modelo }}</p>
                    <p><strong>Estado:</strong> {{ $moto->estado_legal }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach


<!-- Modal Adicionar Moto -->
<div class="modal fade" id="addMotoModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form class="modal-content"
      method="POST"
      action="{{ route('admin.motos.store') }}">
    @csrf

    <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Adicionar Moto</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body row g-3">

        <!-- Motoqueiro -->
        <div class="col-md-6">
            <label class="form-label">Motoqueiro</label>
            <select name="motoqueiro_id" class="form-select" required>
                            @foreach($motoqueiros as $m)
                <option value="{{ $m->id }}">{{ $m->nome }}</option>
            @endforeach
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Marca</label>
            <input type="text" name="marca" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Número da Moto</label>
            <input type="text" name="numero_mota" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Placa</label>
            <input type="text" name="placa" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Cor</label>
            <input type="text" name="cor" class="form-control">
        </div>

        <div class="col-md-6">
            <label class="form-label">Modelo</label>
            <input type="text" name="modelo" class="form-control">
        </div>

        <div class="col-md-6">
            <label class="form-label">Estado Legal</label>
            <select name="estado_legal" class="form-select">
                <option value="Ativa">Ativa</option>
                <option value="Inativa">Inativa</option>
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Ano</label>
            <input type="number" name="ano" class="form-control" required>
        </div>

    </div>

    <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button class="btn btn-primary" type="submit">Salvar</button>
    </div>
</form>

    </div>
</div>

<!--Model de atualizar-->
@foreach($motos as $moto)
<div class="modal fade" id="editMotoModal{{ $moto->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form class="modal-content"
              method="POST"
              action="{{ route('admin.motos.update', $moto->id) }}">
            @csrf
            @method('PUT')

            <div class="modal-header bg-warning">
                <h5 class="modal-title">Editar Moto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body row g-3">
                <div class="col-md-6">
                    <label class="form-label">Marca</label>
                    <input type="text" name="marca" class="form-control" value="{{ $moto->marca }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Modelo</label>
                    <input type="text" name="modelo" class="form-control" value="{{ $moto->modelo }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Placa</label>
                    <input type="text" name="placa" class="form-control" value="{{ $moto->placa }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Estado</label>
                    <select name="estado_legal" class="form-select">
                        <option value="Ativa" {{ $moto->estado_legal=='Ativa'?'selected':'' }}>Ativa</option>
                        <option value="Inativa" {{ $moto->estado_legal=='Inativa'?'selected':'' }}>Inativa</option>
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-warning">Atualizar</button>
            </div>
        </form>
    </div>
</div>
@endforeach



@endsection

@extends('layouts.app')

@section('title','SIMM - Administrador | Associacao')

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

<!-- Navbar -->
<nav class="bg-white shadow-sm border-bottom">
    <div class="container py-2">
        <div class="text-center mb-2">
            <a class="fw-bold fs-4 text-dark text-decoration-none" href="#">SIMM</a>
        </div>
        <div class="d-flex justify-content-center mb-3">
            <ul class="nav flex-wrap justify-content-center">
                <li class="nav-item"><a class="nav-link px-3" href="{{route('admin.home')}}"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
                <li class="nav-item"><a class="nav-link active px-3" href="#"><i class="bi bi-people-fill me-2"></i> Associações</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Conteúdo -->
<main class="container my-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <h3 class="text-primary mb-2">Lista de Associações</h3>
        <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addAssociacaoModal">
            <i class="bi bi-plus-circle me-1"></i> Adicionar Associação
        </button>
    </div>

    <!-- Busca -->
<form class="d-flex mb-3 flex-wrap" role="search" method="GET" action="{{ route('associacao.index') }}">
    <input 
        class="form-control me-2 mb-2 flex-grow-1" 
        type="search" 
        name="q" 
        placeholder="Buscar associação por nome ou cor..." 
        value="{{ request('q') }}" 
        aria-label="Search"
    >
    <button class="btn btn-outline-primary mb-2 loc" type="submit"><i class="bi bi-search"></i></button>
</form>


    <!-- Tabela responsiva -->
    <div class="table-responsive">
    <table class="table table-hover align-middle">
    <thead class="table-light">
        <tr>
            <th>Nome da Associação</th>
            <th>Responsável</th>
            <th>Zona</th>
            <th>Estado</th>
            <th>Data de Criação</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($associacoes as $associacao)
        <tr>
            <td>{{ $associacao->nome }}</td>
            <td>{{ $associacao->responsavel }}</td>
            <td>{{ $associacao->zona }}</td>
            <td>
                <span class="badge {{ $associacao->estado ? 'bg-success' : 'bg-danger' }}">
                    {{ $associacao->estado ? 'Ativa' : 'Inativa' }}
                </span>
            </td>
            <td>{{ \Carbon\Carbon::parse($associacao->criado_em)->format('d/m/Y') }}</td>
            <td class="d-flex gap-1">
                <!-- BOTÃO EDITAR -->
                <button class="btn btn-sm btn-outline-warning btn-action"
                    data-bs-toggle="modal"
                    data-bs-target="#editAssociacaoModal"
                    onclick="editarAssociacao('{{ $associacao->id }}', '{{ $associacao->nome }}', '{{ $associacao->responsavel }}', '{{ $associacao->zona }}', '{{ $associacao->estado }}', '{{ $associacao->cor_uniforme }}')">
                    <i class="bi bi-pencil"></i>
                </button>

                <!-- BOTÃO REMOVER -->
                <form action="{{ route('associacao.destroy', $associacao->id) }}" method="POST"

                      onsubmit="return confirm('Tem certeza que deseja remover esta associação?')">
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

<!-- Modal Adicionar Associação -->
<div class="modal fade" id="addAssociacaoModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
    <form class="modal-content" method="POST" action="{{ route('associacao.store') }}">
    @csrf <!-- proteção obrigatória -->

    <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Adicionar Associação</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body row g-3">

        <div class="col-md-6">
            <label class="form-label">Nome da Associação</label>
            <input type="text" name="nome" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Responsável</label>
            <input type="text" name="responsavel" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Zona</label>
            <input type="text" name="zona" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Estado</label>
            <select name="estado" class="form-select">
                <option value="1">Ativa</option>
                <option value="0">Inativa</option>
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Cor do Uniforme</label>
            <input type="text" name="cor_uniforme" class="form-control">
        </div>

    </div>

    <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button class="btn btn-primary">Salvar</button>
    </div>
</form>


    </div>
</div>

<!-- Modal Editar Associação -->
<div class="modal fade" id="editAssociacaoModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form class="modal-content" id="editAssociacaoForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Editar Associação</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nome da Associação</label>
                    <input type="text" name="nome" id="edit_nome" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Responsável</label>
                    <input type="text" name="responsavel" id="edit_responsavel" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Zona</label>
                    <input type="text" name="zona" id="edit_zona" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Cor Uniforme</label>
                    <input type="text" name="cor_uniforme" id="edit_cor_uniforme" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Estado</label>
                    <select name="estado" id="edit_estado" class="form-select" required>
                        <option value="1">Ativa</option>
                        <option value="0">Inativa</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary">Atualizar</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Script para preencher o modal dinamicamente
function editarAssociacao(id, nome, responsavel, zona, estado, cor_uniforme) {
    document.getElementById('edit_nome').value = nome;
    document.getElementById('edit_responsavel').value = responsavel;
    document.getElementById('edit_zona').value = zona;
    document.getElementById('edit_cor_uniforme').value = cor_uniforme;
    document.getElementById('edit_estado').value = estado;

    // Atualiza a action do form dinamicamente
    const form = document.getElementById('editAssociacaoForm');
    form.action = '/admin/associacao/' + id;
}
</script>

@endsection

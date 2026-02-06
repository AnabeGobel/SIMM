@extends('layouts.app')

@section('title','SIMM - Administrador | Motoqueiro')

@section('content')
<style>
    
    th {
        font-weight: 600;
        color: #0A1F44;
    }
    .btn-action {
        font-size: 0.8rem;
    }
    .modal-header{
        background-color: #0A1F44 !important;
    }
    
   
    
    /* Ajuste para telas pequenas */
    @media (max-width: 768px) {
        h3.text-primary {
            font-size: 1.2rem;
        }
        .btn {
            font-size: 0.8rem;
            width: 100%; /* botões ocupam largura total no mobile */
        }
        .nav {
            flex-direction: column; /* menus quebram em coluna */
            align-items: flex-start;
        }
        .nav .nav-link {
            padding: 0.25rem 0.5rem;
            font-size: 0.85rem;
        }
        form[role="search"] {
            flex-direction: column; /* busca em coluna */
        }
        form[role="search"] input,
        form[role="search"] button {
            width: 100%;
            margin-bottom: 0.5rem;
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
                <li class="nav-item"><a class="nav-link active px-3" href="#"><i class="bi bi-person-badge me-2"></i> Motoqueiros</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Conteúdo -->
<main class="container my-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <h3 class="text-primary mb-2">Lista de Motoqueiros</h3>
        <button class="btn btn-primary mb-2 bfn" data-bs-toggle="modal" data-bs-target="#addMotoqueiroModal">
            <i class="bi bi-plus-circle me-1"></i> Adicionar 
        </button>
       <button 

    class="btn btn-outline-primary mb-2 loc" 
    data-bs-toggle="modal"
    data-bs-target="#addParagemModal" >
    <i class="bi bi-geo-alt me-1"></i> Adicionar Paragem
</button>

       
    </div>


    <!-- Busca -->
<form class="d-flex mb-3" method="GET" action="{{ route('admin.motoqueiros.index') }}">
    <input type="search" name="q" class="form-control me-2" value="{{ request('q') }}" placeholder="Buscar por nome, associação, cor...">
    <button type="submit" class="btn btn-outline-primary loc" ><i class="bi bi-search"></i></button>
</form>


    <!-- Tabela responsiva -->
    <div class="table-responsive">
        <table class="table table-hover align-middle">
    <thead class="table-light">
        <tr>
            <th>Nome</th>
            <th>Contato</th>
            <th>Marca da Moto</th>
            <th>Associação</th>
            <th>Paragem</th>
            <th>Placa</th>
            <th>Estado</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach($motoqueiros as $m)
        <tr>
            <td>{{ $m->nome }}</td>
            <td>{{ $m->telefone }}</td>
            <td>{{ optional($m->motos()->first())->marca ?? '-' }}</td>
            <td>{{ $m->associacao->nome ?? '-' }}</td>
            <td>{{ optional($m->paragem)->nome ?? '-' }}/{{ optional($m->paragem)->bairro ?? '-' }}</td>
            <td>{{ optional($m->motos()->first())->placa ?? '-' }}</td>
            <td>
                <span class="badge {{ $m->estado == 'Ativo' ? 'bg-success' : 'bg-danger' }}">
                    {{ $m->estado }}
                </span>
            </td>
            <td>
                <!-- VISUALIZAR -->
                <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#viewMotoqueiroModal{{ $m->id }}">
                    <i class="bi bi-eye"></i>
                </button>
                <!-- EDITAR -->
                <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editMotoqueiroModal{{ $m->id }}">
                    <i class="bi bi-pencil"></i>
                </button>
                <!-- REMOVER -->
                <form action="{{ route('admin.motoqueiros.destroy', $m->id) }}""
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

<!-- Modal Detalhes -->
<!--Model de Visualizacao-->
@foreach($motoqueiros as $m)
<div class="modal fade" id="viewMotoqueiroModal{{ $m->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Detalhes do Motoqueiro</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body row g-3">
                <div class="col-md-4 text-center">
                    <img src="{{ $m->foto ? asset('storage/' . $m->foto) : asset('images/default-user.png') }}" class="img-fluid rounded" alt="Foto">
                </div>
                <div class="col-md-8">
                    <p><strong>Nome:</strong> {{ $m->nome }}</p>
                    <p><strong>Data Nascimento:</strong> {{ \Carbon\Carbon::parse($m->data_nascimento)->format('d/m/Y') }}</p>
                    <p><strong>Telefone:</strong> {{ $m->telefone }}</p>
                    <p><strong>Endereço:</strong> {{ $m->endereco }}</p>
                    <p><strong>Cor do Colete:</strong> {{ $m->cor_uniforme }}</p>
                    <p><strong>Marca da Moto:</strong> {{ optional($m->motos->first())->marca ?? '-' }}</p>
                    <p><strong>Associação:</strong> {{ optional($m->associacao)->nome ?? '-' }}</p>
                    <p><strong>Paragem:</strong> {{ optional($m->paragem)->nome ?? '-' }}/{{ optional($m->paragem)->bairro ?? '-' }}</p>
                    <p><strong>Status:</strong> {{ $m->estado }}</p>
                </div>
            </div>
        </div>
    </div>
</div>


@endforeach

<!-- Modal Adicionar -->
<div class="modal fade" id="addMotoqueiroModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
       <form class="modal-content"
      action="{{ route('admin.motoqueiros.store') }}"
      method="POST"
      enctype="multipart/form-data">
    
    @csrf

    <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Adicionar Motoqueiro</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body row g-3">
        <div class="col-md-6">
            <label class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Data de Nascimento</label>
            <input type="date" name="data_nascimento" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Endereço</label>
            <input type="text" name="endereco" class="form-control">
        </div>

        <div class="col-md-6">
            <label class="form-label">Telefone</label>
            <input type="text" name="telefone" class="form-control">
        </div>

        <div class="col-md-6">
            <label class="form-label">Documento ID</label>
            <input type="text" name="documento_id" class="form-control">
        </div>

        <div class="col-md-6">
            <label class="form-label">Fotografia</label>
            <input type="file" name="foto" class="form-control">
        </div>

        <div class="col-md-6">
            <label class="form-label">Cor do Uniforme</label>
            <input type="text" name="cor_uniforme" class="form-control">
        </div>

        <div class="col-md-6">
            <label class="form-label">Associação</label>
            <select name="associacao_id" class="form-select" required>
                @foreach($associacoes as $associacao)
                    <option value="{{ $associacao->id }}">
                        {{ $associacao->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Paragem</label>
            <select name="paragem_id" class="form-select" required>
                @foreach($paragens as $paragem)
                    <option value="{{ $paragem->id }}">
                        {{ $paragem->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Estado</label>
            <select name="estado" class="form-select">
                <option value="Ativo">Ativo</option>
                <option value="Inativo">Inativo</option>
            </select>
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button class="btn btn-primary bfn" type="submit">Salvar</button>
    </div>
</form>

    </div>
</div>
<!-- Modal Adicionar Paragem -->
<div class="modal fade" id="addParagemModal" tabindex="-1">
    <div class="modal-dialog modal-md">
       <form class="modal-content"
      method="POST"
      action="{{ route('admin.paragens.store') }}">
    @csrf

    <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Adicionar Paragem</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body row g-3">
        <div class="col-12">
            <label class="form-label">Nome da Paragem</label>
            <input type="text" name="nome" class="form-control" required>
        </div>

        <div class="col-12">
            <label class="form-label">Bairro</label>
            <input type="text" name="bairro" class="form-control" required>
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button class="btn btn-primary bfn" type="submit" >Salvar</button>
    </div>
</form>

    </div>
</div>



<!--Modal de atualizacao-->
@foreach($motoqueiros as $m)
<div class="modal fade" id="editMotoqueiroModal{{ $m->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('admin.motoqueiros.update', $m->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Editar Motoqueiro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body row g-3">
                    <div class="col-md-6">
                        <label>Nome</label>
                        <input type="text" name="nome" value="{{ $m->nome }}" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label>Telefone</label>
                        <input type="text" name="telefone" value="{{ $m->telefone }}" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label>Cor do Uniforme</label>
                        <input type="text" name="cor_uniforme" value="{{ $m->cor_uniforme }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                    <label>Associação</label>
                    <select name="associacao_id" class="form-select" required>
                        @foreach($associacoes as $a)
                            <option value="{{ $a->id }}"
                                {{ $m->associacao_id == $a->id ? 'selected' : '' }}>
                                {{ $a->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Paragem</label>
                    <select name="paragem_id" class="form-select">
                        <option value="">— Nenhuma —</option>
                        @foreach($paragens as $p)
                            <option value="{{ $p->id }}"
                                {{ $m->paragem_id == $p->id ? 'selected' : '' }}>
                                {{ $p->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>


                    <div class="col-md-6">
                        <label>Estado</label>
                        <select name="estado" class="form-select">
                            <option value="Ativo" {{ $m->estado == 'Ativo' ? 'selected' : '' }}>Ativo</option>
                            <option value="Inativo" {{ $m->estado == 'Inativo' ? 'selected' : '' }}>Inativo</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-warning bfn">Atualizar</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endforeach




@endsection

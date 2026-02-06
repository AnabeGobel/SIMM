@extends('layouts.app')

@section('title','SIMM - Administrador | Usuarios')

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
    @media (max-width: 768px) {
        h3.text-primary { font-size: 1.2rem; }
        .btn { font-size: 0.8rem; width: 100%; }
        .nav { flex-direction: column; align-items: flex-start; }
        .nav .nav-link { padding: 0.25rem 0.5rem; font-size: 0.85rem; }
        form[role="search"] { flex-direction: column; }
        form[role="search"] input,
        form[role="search"] button { width: 100%; margin-bottom: 0.5rem; }
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
                <li class="nav-item"><a class="nav-link active px-3" href="#"><i class="bi bi-person-gear me-2"></i> Usuários</a></li>
            </ul>
        </div>
    </div>
</nav>

<main class="container my-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <h3 class="text-primary mb-2">Lista de Usuários</h3>
        <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addUsuarioModal">
            <i class="bi bi-plus-circle me-1"></i> Adicionar Usuário
        </button>
    </div>
    <!-- Componentes resumo --> <div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card shadow-sm text-center p-3">
            <i class="bi bi-shield-lock fs-2 text-primary"></i>
            <h6>Total Administradores</h6>
            <p class="fs-3 text-primary">{{ $totalAdmins}}</p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm text-center p-3">
            <i class="bi bi-person-gear fs-2 text-success"></i>
            <h6>Total Operadores</h6>
            <p class="fs-3 text-success">{{ $totalOperadores}}</p>
        </div>
    </div>
</div>

    <!-- Busca -->
    <form class="d-flex mb-3 flex-wrap" role="search" method="GET" action="{{ route('usuarios.index') }}">
        <input class="form-control me-2 mb-2 flex-grow-1" type="search" name="q" placeholder="Buscar usuário..." value="{{ request('q') }}">
        <button class="btn btn-outline-primary mb-2 loc" type="submit"><i class="bi bi-search"></i></button>
    </form>

    <!-- Tabela responsiva -->
    <div class="table-responsive">
       <table class="table table-hover align-middle">
        <thead class="table-light">
                <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th> 
                <th>Estado</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($usuarios as $usuario)
<tr>
    <td>{{ $usuario->name }}</td>
    <td>{{ $usuario->email }}</td>
    <td>{{ $usuario->telefone ?? '-' }}</td> <!-- ADICIONADO -->
    <td>
        <span class="badge {{ $usuario->role === 'admin' ? 'bg-primary' : 'bg-success' }}">
            {{ strtoupper($usuario->role) }}
        </span>
    </td>
    <td>
        <span class="badge {{ $usuario->ativo ? 'bg-success' : 'bg-danger' }}">
            {{ $usuario->ativo ? 'ATIVO' : 'INATIVO' }}
        </span>
    </td>
    <td class="d-flex gap-1">
        <!-- BOTÃO EDITAR -->
        <button class="btn btn-sm btn-outline-warning" 
            data-bs-toggle="modal" 
            data-bs-target="#editUsuarioModal"
            onclick="editarUsuario('{{ $usuario->id }}', '{{ $usuario->name }}', '{{ $usuario->email }}', '{{ $usuario->telefone ?? '' }}', '{{ $usuario->role }}', '{{ $usuario->ativo }}')">
            <i class="bi bi-pencil"></i>
             

        </button>

        <!-- BOTÃO REMOVER -->
        @if(auth()->user()->role === 'operador' || $usuario->role !== 'admin')
        <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja remover este usuário?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-outline-danger">
                <i class="bi bi-trash"></i>
            </button>
        </form>
        @endif
    </td>
    </tr>
    @endforeach
    </tbody>
    </table>

    {{ $usuarios->links() }} <!-- Paginação Laravel -->
    </div>

</main>

<!-- Modal Adicionar Usuário -->
<div class="modal fade" id="addUsuarioModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form class="modal-content" method="POST" action="{{ route('usuarios.store') }}">
            @csrf
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Adicionar Usuário</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body row g-3">
                <div class="col-md-6"><label class="form-label">Nome</label><input type="text" name="name" class="form-control" required></div>
                <div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" class="form-control" required></div>
                <div class="col-md-6"> <label class="form-label">Telefone</label> <input type="text" name="telefone" class="form-control"></div>
                <div class="col-md-6"><label class="form-label">Senha</label><input type="password" name="password" class="form-control" required></div>
                <div class="col-md-6"><label class="form-label">Confirmar Senha</label><input type="password" name="password_confirmation" class="form-control" required></div>
                <div class="col-md-6"><label class="form-label">Perfil</label>
                    <select name="role" class="form-select" required>
                        <option value="">Selecione</option>
                        <option value="admin">Administrador</option>
                        <option value="operador">Operador</option>
                    </select>
                </div>
                <div class="col-md-6"><label class="form-label">Estado</label>
                    <select name="ativo" class="form-select" required>
                        <option value="1">Ativo</option>
                        <option value="0">Inativo</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Editar Usuário -->
<div class="modal fade" id="editUsuarioModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form class="modal-content" id="editUsuarioForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Editar Usuário</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body row g-3">
                <div class="col-md-6"><label class="form-label">Nome</label><input type="text" name="name" id="edit_name" class="form-control" required></div>
                <div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" id="edit_email" class="form-control" required></div>
                <div class="col-md-6"><label class="form-label">Telefone</label><input type="text" name="telefone" id="edit_telefone" class="form-control"></div>
                <div class="col-md-6"><label class="form-label">Perfil</label>
                    <select name="role" id="edit_role" class="form-select" required>
                        <option value="admin">Administrador</option>
                        <option value="operador">Operador</option>
                    </select>
                </div>
                <div class="col-md-6"><label class="form-label">Estado</label>
                    <select name="ativo" id="edit_ativo" class="form-select" required>
                        <option value="1">Ativo</option>
                        <option value="0">Inativo</option>
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
function editarUsuario(id, name, email, telefone, role, ativo) {
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_telefone').value = telefone;
    document.getElementById('edit_role').value = role;
    document.getElementById('edit_ativo').value = ativo;

      // Atualiza a action do form dinamicamente
    const form = document.getElementById('editUsuarioForm');
    form.action = '/admin/usuarios/' + id;
}




</script>

@endsection

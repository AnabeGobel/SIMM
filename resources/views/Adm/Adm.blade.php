@extends('layouts.app')

@section('title','SIMM - Administrador| Perfil do Usuário')

@section('content')

<style>
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



/* Conteúdo principal */
.content {
    background-color: #f8f9fa;
    min-height: 100vh;
    padding-top: 3.5em !important;
    padding: 1.5rem;
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
                <li class="nav-item"><a class="nav-link active px-3" href="#"><i class="bi bi-person-badge me-2"></i> Perfil Completo</a></li>
            </ul>
        </div>
    </div>
</nav>
        <!-- Conteúdo principal -->
        <div class="col-md-9 col-lg-10 content">
            
            <h3 class="text-primary mb-4">Perfil do Usuário</h3>

            {{-- Mensagens --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Abas --}}
            <ul class="nav nav-pills mb-3">
                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#perfil">
                        <i class="bi bi-person-circle"></i> Perfil
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#privacidade">
                        <i class="bi bi-shield-lock"></i> Privacidade
                    </button>
                </li>
            </ul>

            <div class="tab-content">
                <!-- Aba Perfil -->
                <div class="tab-pane fade show active" id="perfil">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card shadow-sm mb-4">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-md-4 text-center">
                                            <img src="{{ $usuario->foto ? asset('storage/'.$usuario->foto) : asset('images/default-user.png') }}"
                                                 class="img-fluid rounded-circle mb-2" width="150">
                                            <form method="POST" action="{{ route('perfilAdm.foto') }}" enctype="multipart/form-data">
                                                @csrf
                                                <input type="file" name="foto" class="form-control form-control-sm mb-2">
                                                <button class="btn btn-outline-primary btn-sm w-100">Alterar Foto</button>
                                            </form>
                                        </div>
                                        <div class="col-md-8">
                                            <p><strong>Nome:</strong> {{ $usuario->name }}</p>
                                            <p><strong>Email:</strong> {{ $usuario->email }}</p>
                                            <p><strong>Telefone:</strong> {{ $usuario->telefone ?? '-' }}</p>
                                            <p><strong>Função:</strong> {{ ucfirst($usuario->role) }}</p>
                                            <p><strong>Criado em:</strong> {{ $usuario->created_at->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Editar Dados -->
                        <div class="col-lg-6">
                            <div class="card shadow-sm mb-4">
                                <div class="card-body">
                                    <h5>Editar Dados</h5>
                                    <form method="POST" action="{{ route('perfilAdm.atualizar') }}">
                                        @csrf
                                        <input class="form-control mb-2" name="name" value="{{ $usuario->name }}" placeholder="Nome">
                                        <input class="form-control mb-2" name="email" value="{{ $usuario->email }}" placeholder="Email">
                                        <input class="form-control mb-2" name="telefone" value="{{ $usuario->telefone }}" placeholder="Telefone">
                                        <button class="btn btn-primary w-100">Salvar Alterações</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Aba Privacidade -->
                <div class="tab-pane fade" id="privacidade">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card shadow-sm mb-4">
                                <div class="card-body">
                                    <h5>Alterar Senha</h5>
                                    <form method="POST" action="{{ route('perfilAdm.senha') }}">
                                        @csrf
                                        <input type="password" name="senha_atual" class="form-control mb-2" placeholder="Senha Atual">
                                        <input type="password" name="nova_senha" class="form-control mb-2" placeholder="Nova Senha">
                                        <input type="password" name="nova_senha_confirmation" class="form-control mb-3" placeholder="Confirmar Nova Senha">
                                        <button class="btn btn-warning w-100">Atualizar Senha</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card shadow-sm mb-4 border-danger">
                                <div class="card-body">
                                    <h5 class="text-danger">Excluir Conta</h5>
                                    <form method="POST" action="{{ route('perfilAdm.excluir') }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger w-100" onclick="return confirm('Tem certeza que deseja excluir sua conta?')">Excluir Conta Permanentemente</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- fim tab-content -->

        </div> <!-- fim conteúdo principal -->

    </div> <!-- fim row -->
</div> <!-- fim container-fluid -->

@endsection

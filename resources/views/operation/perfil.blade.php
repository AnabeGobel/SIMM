@extends('layouts.app')

@section('title','SIMM - Operador | Perfil do Usuário')

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

/* Offcanvas mobile */
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
</style>

<div class="container-fluid">
    <div class="row">

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
                                            <form method="POST" action="{{ route('perfil.foto') }}" enctype="multipart/form-data">
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
                                    <form method="POST" action="{{ route('perfil.atualizar') }}">
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
                                    <form method="POST" action="{{ route('perfil.senha') }}">
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
                                    <form method="POST" action="{{ route('perfil.excluir') }}">
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

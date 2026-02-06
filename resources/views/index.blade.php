@extends('layouts.app')

@section('title','SIMM')

@section('content')
    <!-- Navbar horizontal fixa -->
    <nav class="bg-white shadow-sm">
        <div class="container d-flex justify-content-between align-items-center py-2">
            <!-- Logo -->
            <a class="fw-bold fs-4 text-dark text-decoration-none" href="#">SIMM</a>

            <!-- Menu horizontal -->
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link fw-semibold text-dark px-3 d-flex align-items-center" href="#">
                        <i class="bi bi-info-circle me-2"></i> Informação
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold text-dark px-3 d-flex align-items-center" href="#">
                        <i class="bi bi-telephone-fill me-2"></i> Contacto
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold text-dark px-3 d-flex align-items-center" href="#">
                        <i class="bi bi-question-circle me-2"></i> Ajuda
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Conteúdo central -->
    <main class="d-flex flex-column justify-content-center align-items-center vh-100 bg-light">
        <h1 class="text-secondary-custom fw-bold display-4 mb-4 text-center">
            Sistema de Monitoramento de Mototax
        </h1>
        <a href="{{ route('login.index') }}" class="btn btn-lg px-5 py-3 text-white fw-bold shadow"
           style="background: linear-gradient(90deg, #3d4042, #1a4a80); border-radius: 30px;">
           Começar

    </main>

    <!-- Rodapé -->
    <footer class="bg-dark text-center py-4 mt-auto">
        <p class="mb-1 text-white fw-bold">Desenvolvido por Anabe Digital</p>
        <small class="text-white-50">Sistema criado para monitoramento e gestão de mototax. Todos os direitos reservados.</small>
    </footer>
@endsection

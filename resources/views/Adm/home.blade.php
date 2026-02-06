@extends('layouts.app')

@section('title','SIMM - Administrador | Dashboard') 
 @vite(['resources/js/home.js','resources/css/home.css'])

@section('content')

<style>
    /* Navbar links */
    .nav .nav-link {
        color: #212529 !important;
    }
    .nav .nav-link:hover,
    .nav .nav-link.active {
        color: #0A1F44 !important;
        font-weight: 500;
    }

    /* Ajuste do título */
    h2.text-primary {
        font-size: 1.75rem; /* menor que display-6 */
        margin-bottom: 1rem;
    }

   
    .btn{
        border-color: #0A1F44 !important;
        color: #0A1F44 !important;

    }
    .btn:hover{
        background-color: #0A1F44 !important;
        color:white !important;

    }


</style>

<nav class="bg-white shadow-sm border-bottom">
    <div class="container py-2">
        <!-- Logo -->
        <div class="text-center mb-2">
            <a class="fw-bold fs-4 text-dark text-decoration-none" href="#">SIMM</a>
        </div>
      <!--botao do menu-->

     <div class="text-center d-md-none mb-2">
         <button id="btnMenuMobile" class="btn" type="button" aria-label="Toggle navigation">
    <i class="bi bi-list fs-3"></i>
</button>

        </div>


        <!-- Menus horizontais -->
      <div id="menuPrincipal" class="menu-principal">
    <div class="d-flex justify-content-center mb-3">
        <ul class="nav flex-column flex-md-row text-center justify-content-center">

            <li class="nav-item">
                <a class="nav-link active px-3 d-flex align-items-center justify-content-center"
                   href="{{ route('admin.home') }}">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link px-3 d-flex align-items-center justify-content-center"
                   href="{{ route('Adm.motoqueiro') }}">
                    <i class="bi bi-person-badge me-2"></i> Motoqueiros
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link px-3 d-flex align-items-center justify-content-center"
                   href="{{ route('Adm.moto') }}">
                    <i class="bi bi-bicycle me-2"></i> Motos
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link px-3 d-flex align-items-center justify-content-center"
                   href="{{ route('Adm.associacao') }}">
                    <i class="bi bi-people-fill me-2"></i> Associações
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link px-3 d-flex align-items-center justify-content-center"
                   href="{{ route('Adm.usuario') }}">
                    <i class="bi bi-person-gear me-2"></i> Usuários
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link px-3 d-flex align-items-center justify-content-center"
                   href="{{ route('Adm.relatorios') }}">
                    <i class="bi bi-bar-chart-line me-2"></i> Relatórios
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link px-3 d-flex align-items-center justify-content-center"
                   href="{{ route('Adm.backup') }}">
                    <i class="bi bi-cloud-arrow-down me-2"></i> Backup
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link px-3 d-flex align-items-center justify-content-center"
                   href="{{ route('perfilAdm') }}">
                    <i class="bi bi-person-badge me-2"></i> Perfil Completo
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link px-3 d-flex align-items-center justify-content-center"
                   href="{{ route('login.index') }}">
                    <i class="bi bi-box-arrow-right me-1"></i> Sair
                </a>
            </li>

        </ul>
    </div>
</div>


        <!-- Barra de busca -->
        <div class="d-flex justify-content-center mb-2">
           <form class="d-flex" role="search" style="max-width:400px; width:100%;"action="{{ route('admin.dashboard.search') }}" > <label for="search" class="visually-hidden">Buscar</label> <input id="search" class="form-control me-2" type="search" placeholder="Buscar..." aria-label="Search"> <button class="btn btn-outline-primary d-flex align-items-center" type="submit"> <i class="bi bi-search me-1"></i> Buscar </button> </form>
        </div>
    </div>
</nav>



<!-- Conteúdo do Dashboard -->
<main class="container my-4">
    <h2 class="text-primary mb-4">Dashboard Geral</h2>

    <!-- Cards de métricas principais -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm text-center p-3">
                <i class="bi bi-person-badge fs-2 text-primary"></i>
                <h6>Motoqueiros Registrados</h6>
                <p class="fs-3 text-primary">{{  $totalMotoqueiros }}</p>
                <small class="text-muted">Total cadastrados</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm text-center p-3">
                <i class="bi bi-people-fill fs-2 text-success"></i>
                <h6>Associações</h6>
                <p class="fs-3 text-success">{{ $totalAssociacoes }}</p>
                <small class="text-muted">Atualmente ativas</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm text-center p-3">
                <i class="bi bi-geo-alt-fill fs-2 text-warning"></i>
                <h6>Paragens</h6>
                <p class="fs-3 text-warning">{{ $totalParagens }}</p>
                <small class="text-muted">Registradas</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm text-center p-3">
                <i class="bi bi-check-circle fs-2 text-success"></i>
                <h6>Status</h6>
               
                <p class="fs-3">
                    <span class="text-success">{{ $ativos }}</span> /
                    <span class="text-danger">{{ $inativos }}</span>
                </p>
                <small class="text-muted">Ativos / Inativos</small>
            </div>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="row g-4">
    <!-- Gráfico de Barras -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm p-3">
            <h6>Ativos vs Inativos</h6>
            <small class="text-muted">Comparação clara entre motoqueiros ativos e inativos</small>
            <canvas id="ativosInativosChart"></canvas>
        </div>
    </div>

    <!-- Gráfico de Área -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm p-3">
            <h6>Novos Registros</h6>
            <small class="text-muted">Tendência de crescimento ao longo dos meses</small>
            <canvas id="novosRegistrosChart"></canvas>
        </div>
    </div>
</div>


    <!-- Filtros rápidos -->
    <div class="card bg-light border-0 shadow-sm p-3 mt-4">
        <h6>Filtros Rápidos</h6>
        <form class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Associação</label>
                <select class="form-select">
                    <option selected>Selecione...</option>
                    <option>Associação A</option>
                    <option>Associação B</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Status</label>
                <select class="form-select">
                    <option selected>Selecione...</option>
                    <option>Ativo</option>
                    <option>Inativo</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Período</label>
                <input type="date" class="form-control">
            </div>
        </form>
    </div>
</main>

@php
    $mesesJs = $meses ?? ['Jan','Fev','Mar','Abr','Mai','Jun'];
    $novosRegistrosJs = $novosRegistros ?? [0,0,0,0,0,0];
    $ativosMotoqueirosJs = $ativosMotoqueiros ?? 0;
    $inativosMotoqueirosJs = $inativosMotoqueiros ?? 0;
@endphp


<!-- Scripts Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Pegando os dados do PHP
const ativos = @json($ativos);
const inativos = @json($inativos);
const meses = @json($meses);
const novosRegistros = @json($novosRegistros);

// Gráfico de Barras Horizontais
new Chart(document.getElementById('ativosInativosChart'), {
    type: 'bar',
    data: {
        labels: ['Ativos', 'Inativos'],
        datasets: [{
            label: 'Motoqueiros',
            data: [ativos, inativos],
            backgroundColor: ['#198754', '#dc3545']
        }]
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        plugins: {
            legend: { display: false }
        }
    }
});

// Gráfico de Área (Novos Registros)
new Chart(document.getElementById('novosRegistrosChart'), {
    type: 'line',
    data: {
        labels: meses,
        datasets: [{
            label: 'Novos Registros',
            data: novosRegistros,
            borderColor: '#0A1F44',
            backgroundColor: 'rgba(10,31,68,0.2)',
            fill: true,
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});


</script>



@endsection

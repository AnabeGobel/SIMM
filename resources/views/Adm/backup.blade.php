@extends('layouts.app')

@section('title','SIMM - Backup de Dados')

@section('content')
<style>
    th {
        font-weight: 600;
        color: #0A1F44;
    }
    .btn-action {
        font-size: 0.85rem;
    }
    .modal-header{
        background-color: #0A1F44 !important;
    }
    @media (max-width: 768px) {
        h3.text-primary {
            font-size: 1.2rem;
        }
        .btn {
            font-size: 0.8rem;
            width: 100%;
        }
        .nav {
            flex-direction: column;
            align-items: flex-start;
        }
        .nav .nav-link {
            padding: 0.25rem 0.5rem;
            font-size: 0.85rem;
        }
        form[role="search"] {
            flex-direction: column;
        }
        form[role="search"] input,
        form[role="search"] button {
            width: 100%;
            margin-bottom: 0.5rem;
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
                <li class="nav-item"><a class="nav-link active px-3" href="#"><i class="bi bi-cloud-arrow-down me-2"></i> Backup</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Conteúdo -->
<main class="container my-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <h3 class="text-primary mb-2">Backup de Dados</h3>
        <button class="btn btn-primary mb-2">
            <i class="bi bi-cloud-arrow-down me-1"></i> Gerar Backup
        </button>
    </div>

    <!-- Busca -->
    <form class="d-flex mb-3 flex-wrap" role="search">
        <input class="form-control me-2 mb-2 flex-grow-1" type="search" placeholder="Buscar backup..." aria-label="Search">
        <button class="btn btn-outline-primary mb-2 loc" type="submit"><i class="bi bi-search"></i></button>
    </form>

    <!-- Histórico de backups -->
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Data</th>
                    <th>Arquivo</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>23/01/2026 - 18:00</td>
                    <td>backup_23012026.zip</td>
                    <td><span class="badge bg-success">Concluído</span></td>
                    <td>
                        <button class="btn btn-sm btn-outline-success btn-action"><i class="bi bi-arrow-counterclockwise"></i> Restaurar</button>
                        <button class="btn btn-sm btn-outline-danger btn-action"><i class="bi bi-trash"></i> Remover</button>
                    </td>
                </tr>
                <tr>
                    <td>20/01/2026 - 14:30</td>
                    <td>backup_20012026.zip</td>
                    <td><span class="badge bg-warning">Pendente</span></td>
                    <td>
                        <button class="btn btn-sm btn-outline-secondary btn-action" disabled><i class="bi bi-arrow-counterclockwise"></i> Restaurar</button>
                        <button class="btn btn-sm btn-outline-danger btn-action"><i class="bi bi-trash"></i> Remover</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    
</main>
@endsection

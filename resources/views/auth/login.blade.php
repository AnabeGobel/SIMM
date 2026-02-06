@extends('layouts.app')
@section('title','SIMM-Login')
@section('content')
<div class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="card shadow-sm p-4" style="max-width: 400px; width: 100%;">
        <h3 class="text-secondary-custom fw-bold text-center mb-4">Login</h3>
        
        <form method="POST" action="{{ route('login.process') }}">
             @csrf
            <!-- Campo Email -->
            <div class="mb-3 input-group">
                <span class="input-group-text bg-secondary-custom text-dark">
                    <i class="bi bi-envelope-fill"></i>
                </span>
                <input type="email" class="form-control" name="email" placeholder="Email" required autofocus>
            </div>

            <!-- Campo Palavra-passe -->
            <div class="mb-3 input-group">
                <span class="input-group-text bg-secondary-custom text-dark">
                    <i class="bi bi-lock-fill"></i>
                </span>
                <input type="password" class="form-control" name="password" placeholder="Palavra-passe" required>
            </div>

            <!-- Botão Entrar -->
            <div class="d-grid">
                <button type="submit" class="btn text-white fw-bold"
                        style="background-color:#0A1F44; border-radius:30px;">
                    Entrar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

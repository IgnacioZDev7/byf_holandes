@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_top_nav_right')
    <li class="nav-item d-flex align-items-center">
        <span class="nav-link text-muted">{{ auth()->user()->nombre ?? 'Usuario' }}</span>
    </li>
    <li class="nav-item">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-link nav-link" style="color: #dc3545;">
                <i class="fas fa-sign-out-alt"></i> Cerrar sesión
            </button>
        </form>
    </li>
@endsection

@section('content_header')
    <h1>Dashboard</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>Bienvenido</h3>
                    <p>Acceso al sistema de salud</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hospital"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ auth()->user()->nombre ?? 'Usuario' }}</h3>
                    <p>Sesión activa</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-check"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>Panel</h3>
                    <p>Navega con el menú lateral</p>
                </div>
                <div class="icon">
                    <i class="fas fa-bars"></i>
                </div>
            </div>
        </div>
    </div>
@endsection

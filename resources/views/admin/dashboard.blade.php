@extends('layouts.admin')

@section('titulo', 'Panel de Administración')

@section('contenido')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Panel de Administración</h1>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <div id="tabla-ejemplo"></div>
        </div>
    </div>

@endsection
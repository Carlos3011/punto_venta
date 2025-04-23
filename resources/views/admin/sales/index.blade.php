@extends('layouts.admin')

@section('titulo', 'Gestión de Ventas')

@section('contenido')
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="container mx-auto px-4 py-8 animate-fade-in">
        <div class="bg-orange-100 p-6 rounded-xl shadow-md">
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center space-x-4">
                    <i class="fas fa-cash-register text-4xl text-orange-500"></i>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-orange-600 to-orange-400 bg-clip-text text-transparent">
                        Gestión de Ventas
                    </h1>
                </div>
                <a href="{{ route('admin.sales.create') }}"
                    class="bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-100 hover:shadow-xl flex items-center space-x-2 has-tooltip shadow-md hover:shadow-lg">
                    <i class="fas fa-plus text-lg"></i>
                    <span>Nueva Venta</span>
                </a>
            </div>
    <h2 class="text-2xl font-bold mb-6">Reportes de Ventas y Análisis Financiero</h2>

    <!-- Filtros -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8 transform transition-all duration-300 hover:shadow-xl">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Reporte</label>
                <select id="tipo_reporte" class="w-full border-gray-300 rounded-md shadow-sm">
                    <option value="dia">Por Día</option>
                    <option value="semana">Por Semana</option>
                    <option value="mes">Por Mes</option>
                    <option value="año">Por Año</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Inicio</label>
                <input type="date" id="fecha_inicio" class="w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Fin</label>
                <input type="date" id="fecha_fin" class="w-full border-gray-300 rounded-md shadow-sm">
            </div>
        </div>
        <div class="mt-4 flex justify-end space-x-2">
            <button id="btn_filtrar" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                Filtrar
            </button>
            <button id="btn_excel" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                Exportar Excel
            </button>
            <button id="btn_pdf" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                Exportar PDF
            </button>
        </div>
    </div>

    <!-- Resumen -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4">
            <h3 class="text-lg font-semibold mb-2">Total Ventas</h3>
            <p id="total_ventas" class="text-2xl font-bold text-blue-600">$0.00</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <h3 class="text-lg font-semibold mb-2">Total Descuentos</h3>
            <p id="total_descuentos" class="text-2xl font-bold text-yellow-600">$0.00</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <h3 class="text-lg font-semibold mb-2">Total Gastos</h3>
            <p id="total_gastos" class="text-2xl font-bold text-red-600">$0.00</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <h3 class="text-lg font-semibold mb-2">Utilidad</h3>
            <p id="total_utilidad" class="text-2xl font-bold text-green-600">$0.00</p>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-4">
            <h3 class="text-lg font-semibold mb-4">Ventas por Período</h3>
            <canvas id="grafico_ventas"></canvas>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <h3 class="text-lg font-semibold mb-4">Métodos de Pago</h3>
            <canvas id="grafico_metodos_pago"></canvas>
        </div>
    </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let ventasChart, metodosChart;

    function inicializarGraficos() {
        const ctxVentas = document.getElementById('grafico_ventas').getContext('2d');
        const ctxMetodos = document.getElementById('grafico_metodos_pago').getContext('2d');

        ventasChart = new Chart(ctxVentas, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Ventas',
                    data: [],
                    borderColor: 'rgb(59, 130, 246)',
                    tension: 0.1
                }]
            }
        });

        metodosChart = new Chart(ctxMetodos, {
            type: 'doughnut',
            data: {
                labels: ['Efectivo', 'Tarjeta', 'Transferencia'],
                datasets: [{
                    data: [0, 0, 0],
                    backgroundColor: [
                        'rgb(34, 197, 94)',
                        'rgb(59, 130, 246)',
                        'rgb(168, 85, 247)'
                    ]
                }]
            }
        });
    }

    function actualizarDatos() {
        const fechaInicio = document.getElementById('fecha_inicio').value;
        const fechaFin = document.getElementById('fecha_fin').value;
        const tipo = document.getElementById('tipo_reporte').value;

        fetch(`/admin/reportes/datos?fecha_inicio=${fechaInicio}&fecha_fin=${fechaFin}&tipo=${tipo}`)
            .then(response => response.json())
            .then(data => {
                actualizarGraficos(data);
                actualizarResumen(data);
            });
    }

    function actualizarGraficos(data) {
        // Actualizar gráfico de ventas
        ventasChart.data.labels = data.ventas.map(v => v.fecha);
        ventasChart.data.datasets[0].data = data.ventas.map(v => v.total_ventas);
        ventasChart.update();

        // Actualizar gráfico de métodos de pago
        const totalEfectivo = data.ventas.reduce((sum, v) => sum + v.ventas_efectivo, 0);
        const totalTarjeta = data.ventas.reduce((sum, v) => sum + v.ventas_tarjeta, 0);
        const totalTransferencia = data.ventas.reduce((sum, v) => sum + v.ventas_transferencia, 0);

        metodosChart.data.datasets[0].data = [totalEfectivo, totalTarjeta, totalTransferencia];
        metodosChart.update();
    }

    function actualizarResumen(data) {
        const totalVentas = data.ventas.reduce((sum, v) => sum + v.total_ventas, 0);
        const totalDescuentos = data.ventas.reduce((sum, v) => sum + v.total_descuentos, 0);
        const totalGastos = data.cajas.reduce((sum, c) => sum + c.gastos_totales, 0);
        const utilidad = totalVentas - totalGastos;

        document.getElementById('total_ventas').textContent = `$${totalVentas.toFixed(2)}`;
        document.getElementById('total_descuentos').textContent = `$${totalDescuentos.toFixed(2)}`;
        document.getElementById('total_gastos').textContent = `$${totalGastos.toFixed(2)}`;
        document.getElementById('total_utilidad').textContent = `$${utilidad.toFixed(2)}`;
    }

    document.addEventListener('DOMContentLoaded', function() {
        inicializarGraficos();

        document.getElementById('btn_filtrar').addEventListener('click', actualizarDatos);
        document.getElementById('btn_excel').addEventListener('click', () => {
            const fechaInicio = document.getElementById('fecha_inicio').value;
            const fechaFin = document.getElementById('fecha_fin').value;
            window.location.href = `/admin/reportes/exportar-excel?fecha_inicio=${fechaInicio}&fecha_fin=${fechaFin}`;
        });
        document.getElementById('btn_pdf').addEventListener('click', () => {
            const fechaInicio = document.getElementById('fecha_inicio').value;
            const fechaFin = document.getElementById('fecha_fin').value;
            window.location.href = `/admin/reportes/exportar-pdf?fecha_inicio=${fechaInicio}&fecha_fin=${fechaFin}`;
        });

        // Establecer fechas por defecto
        const hoy = new Date();
        const inicioMes = new Date(hoy.getFullYear(), hoy.getMonth(), 1);
        document.getElementById('fecha_inicio').value = inicioMes.toISOString().split('T')[0];
        document.getElementById('fecha_fin').value = hoy.toISOString().split('T')[0];

        actualizarDatos();
    });
</script>
@endpush
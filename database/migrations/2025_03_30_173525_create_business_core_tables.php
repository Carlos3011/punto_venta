<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('teléfono');
            $table->string('email');
            $table->string('rfc')->nullable();
            $table->string('dirección');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('proveedores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('contacto');
            $table->string('teléfono');
            $table->string('email');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->timestamps();
        });

        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('código')->unique();
            $table->text('descripción');
            $table->decimal('precio_mayoreo', 10, 2);
            $table->decimal('precio_menudeo', 10, 2);
            $table->string('estado');
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('producto_proveedor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->foreignId('proveedor_id')->constrained('proveedores')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('cliente_id')->nullable()->constrained('clientes');
            $table->date('fecha');
            $table->decimal('total', 10, 2);
            $table->string('forma_pago');
            $table->decimal('descuento', 10, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('venta_detalle', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venta_id')->constrained('ventas')->onDelete('cascade');
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });

        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venta_id')->constrained('ventas')->onDelete('cascade');
            $table->string('rfc_cliente');
            $table->string('uuid');
            $table->text('xml');
            $table->text('pdf');
            $table->timestamps();
        });

        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venta_id')->constrained('ventas')->onDelete('cascade');
            $table->text('ticket_text');
            $table->date('fecha_generacion');
            $table->timestamps();
        });

        Schema::create('instaladores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('teléfono');
            $table->string('especialidad');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('servicios_instalacion', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('tipo');
            $table->decimal('precio', 10, 2);
            $table->foreignId('instalador_id')->constrained('instaladores')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('caja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users');
            $table->date('fecha');
            $table->decimal('monto_inicial', 10, 2);
            $table->decimal('total_ventas', 10, 2);
            $table->decimal('total_efectivo', 10, 2);
            $table->decimal('total_tarjeta', 10, 2);
            $table->decimal('total_transferencia', 10, 2);
            $table->decimal('total_gastos', 10, 2);
            $table->decimal('diferencia_caja', 10, 2);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('reportes_ventas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->decimal('total_ventas', 10, 2);
            $table->decimal('total_descuentos', 10, 2);
            $table->decimal('ventas_efectivo', 10, 2);
            $table->decimal('ventas_tarjeta', 10, 2);
            $table->decimal('ventas_transferencia', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportes_ventas');
        Schema::dropIfExists('caja');
        Schema::dropIfExists('servicios_instalacion');
        Schema::dropIfExists('instaladores');
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('facturas');
        Schema::dropIfExists('venta_detalle');
        Schema::dropIfExists('ventas');
        Schema::dropIfExists('productos');
        Schema::dropIfExists('categorias');
        Schema::dropIfExists('proveedores');
        Schema::dropIfExists('clientes');
    }
};

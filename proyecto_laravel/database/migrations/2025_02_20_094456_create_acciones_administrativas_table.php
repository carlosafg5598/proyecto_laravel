<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('acciones_administrativas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id'); // Quién hizo el cambio
            $table->unsignedBigInteger('cliente_id')->nullable(); // Cliente afectado
            $table->unsignedBigInteger('otro_admin_id')->nullable(); // Otro administrador afectado
            $table->string('accion'); // Ejemplo: "Edición", "Eliminación"
            $table->text('detalles')->nullable(); // Descripción del cambio
            $table->timestamps();

            // Claves foráneas
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->foreign('otro_admin_id')->references('id')->on('administradores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acciones_administrativas');
    }
};

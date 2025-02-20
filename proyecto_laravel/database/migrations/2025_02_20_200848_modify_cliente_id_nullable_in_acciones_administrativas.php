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
        Schema::table('acciones_administrativas', function (Blueprint $table) {
            $table->dropForeign(['cliente_id']); // Eliminar la clave foránea actual
            $table->unsignedBigInteger('cliente_id')->nullable()->change(); // Permitir NULL
            $table->foreign('cliente_id')->references('id')->on('clientes')->nullOnDelete(); // No eliminar registros, solo poner NULL
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('acciones_administrativas', function (Blueprint $table) {
            $table->dropForeign(['cliente_id']);
            $table->unsignedBigInteger('cliente_id')->nullable(false)->change(); // Revertir cambio a obligatorio
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade'); // Restaurar eliminación en cascada
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('administradores', function (Blueprint $table) {
            $table->string('nombre')->after('user_id'); // Agregar la columna nombre
        });
    }

    public function down()
    {
        Schema::table('administradores', function (Blueprint $table) {
            $table->dropColumn('nombre');
        });
    }
};

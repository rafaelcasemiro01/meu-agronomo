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
        Schema::table('clientes', function (Blueprint $table) {
            // Adiciona a coluna 'status' como um booleano, com valor padrão 'true' (ativo)
            // AFTER 'contato' para melhor organização, se desejar.
            $table->boolean('status')->default(true)->after('contato');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            // Remove a coluna 'status' se a migration for revertida
            $table->dropColumn('status');
        });
    }
};

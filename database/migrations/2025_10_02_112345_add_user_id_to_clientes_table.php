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
            // Adiciona a coluna user_id como uma chave estrangeira
            // Torna ela nullable para permitir que registros existentes tenham NULL
            if (!Schema::hasColumn('clientes', 'user_id')) { // <-- Checa se a coluna já existe
                $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            if (Schema::hasColumn('clientes', 'user_id')) { // <-- Checa se a coluna existe antes de tentar remover
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * (O que fazer ao EXECUTAR a migração)
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
        });
    }

    /**
     * Reverse the migrations.
     * (O que fazer se precisar de DESFAZER a migração)
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 3. Remove as colunas se precisar de reverter
            $table->dropColumn('data_nascimento');
            $table->dropColumn('celular');
        });
    }
};
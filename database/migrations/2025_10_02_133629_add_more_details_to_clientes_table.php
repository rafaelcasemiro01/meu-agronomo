<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            if (!Schema::hasColumn('clientes', 'rg')) {
                $table->string('rg')->nullable()->after('cpf');
            }
            if (!Schema::hasColumn('clientes', 'telefone')) {
                $table->string('telefone')->nullable()->after('contato'); // ou onde achar melhor
            }
            if (!Schema::hasColumn('clientes', 'endereco')) {
                $table->string('endereco')->nullable()->after('cidade');
            }
            if (!Schema::hasColumn('clientes', 'estado')) {
                $table->string('estado')->nullable()->after('cidade');
            }
            if (!Schema::hasColumn('clientes', 'cep')) {
                $table->string('cep')->nullable()->after('endereco');
            }
            // Exemplo de campo mais específico para propriedade
            if (!Schema::hasColumn('clientes', 'nome_propriedade')) {
                $table->string('nome_propriedade')->nullable()->after('nome');
            }
            if (!Schema::hasColumn('clientes', 'area_total_ha')) {
                $table->decimal('area_total_ha', 8, 2)->nullable()->after('nome_propriedade'); // Área em hectares
            }
            if (!Schema::hasColumn('clientes', 'cultura_principal')) {
                $table->string('cultura_principal')->nullable()->after('area_total_ha');
            }
        });
    }

    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            if (Schema::hasColumn('clientes', 'rg')) {
                $table->dropColumn('rg');
            }
            if (Schema::hasColumn('clientes', 'telefone')) {
                $table->dropColumn('telefone');
            }
            if (Schema::hasColumn('clientes', 'endereco')) {
                $table->dropColumn('endereco');
            }
            if (Schema::hasColumn('clientes', 'estado')) {
                $table->dropColumn('estado');
            }
            if (Schema::hasColumn('clientes', 'cep')) {
                $table->dropColumn('cep');
            }
            if (Schema::hasColumn('clientes', 'nome_propriedade')) {
                $table->dropColumn('nome_propriedade');
            }
            if (Schema::hasColumn('clientes', 'area_total_ha')) {
                $table->dropColumn('area_total_ha');
            }
            if (Schema::hasColumn('clientes', 'cultura_principal')) {
                $table->dropColumn('cultura_principal');
            }
        });
    }
};

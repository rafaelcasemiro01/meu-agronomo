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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id(); // Coluna de ID automático
            $table->string('nome'); // Coluna para o nome do cliente
            $table->string('cpf')->unique(); // Coluna para o CPF (deve ser único)
            $table->integer('visitas')->default(0); // Coluna para o n.º de visitas
            $table->string('cidade'); // Coluna para a cidade
            $table->string('contato'); // Coluna para o telefone/contato
            $table->timestamps(); // Colunas created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('relatorios', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('cliente_id')->constrained('clientes')->cascadeOnDelete();

            // Um relatório PODE nascer de uma visita técnica realizada (opcional).
            $table->foreignId('visita_tecnica_id')->nullable()
                  ->constrained('visitas_tecnicas')->nullOnDelete();

            $table->string('titulo');
            $table->string('tipo');                       // Ex.: Análise de solo, Monitoramento de pragas…
            $table->date('data_relatorio');
            $table->text('diagnostico')->nullable();      // O que foi observado em campo
            $table->text('recomendacoes')->nullable();    // O que o agrônomo recomenda
            $table->string('status')->default('rascunho'); // rascunho | finalizado

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('relatorios');
    }
};

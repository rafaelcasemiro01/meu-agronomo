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
        Schema::create('visitas_tecnicas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Agrônomo que agendou
            $table->foreignId('cliente_id')->constrained()->onDelete('cascade'); // Cliente da visita

            $table->date('data_visita');
            $table->time('hora_visita');
            $table->string('local_visita')->nullable(); // Pode ser o endereço da propriedade, ou algo mais específico
            $table->text('observacoes')->nullable();
            $table->string('status')->default('agendada'); // agendada, realizada, cancelada
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitas_tecnicas');
    }
};

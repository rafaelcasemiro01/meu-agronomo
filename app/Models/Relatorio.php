<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Relatorio extends Model
{
    use HasFactory;

    protected $table = 'relatorios';

    protected $fillable = [
        'user_id',
        'cliente_id',
        'visita_tecnica_id',
        'titulo',
        'tipo',
        'data_relatorio',
        'diagnostico',
        'recomendacoes',
        'status',
    ];

    protected $casts = [
        'data_relatorio' => 'date',
    ];

    /**
     * Tipos de relatório oferecidos no formulário.
     */
    public const TIPOS = [
        'Análise de solo',
        'Monitoramento de pragas',
        'Recomendação de adubação',
        'Diagnóstico fitossanitário',
        'Vistoria de irrigação',
        'Acompanhamento de cultura',
        'Outro',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function visitaTecnica(): BelongsTo
    {
        return $this->belongsTo(VisitaTecnica::class);
    }
}

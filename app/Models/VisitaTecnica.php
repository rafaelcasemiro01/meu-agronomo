<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VisitaTecnica extends Model
{
    use HasFactory;

    // A tabela 'visitas_tecnicas' é inferida corretamente pelo Laravel,
    // mas adicioná-la explicitamente pode melhorar a clareza para alguns desenvolvedores.
    protected $table = 'visitas_tecnicas';

    protected $fillable = [
        'user_id',
        'cliente_id',
        'data_visita',
        'hora_visita',
        'local_visita',
        'observacoes',
        'status',
    ];

    protected $casts = [
        'data_visita' => 'date',
        'hora_visita' => 'string', // 'string' é o ideal para corresponder ao tipo TIME no banco e ao formato H:i do Flatpickr.
    ];

    /**
     * Uma visita técnica pertence a um usuário (agrônomo).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Uma visita técnica pertence a um cliente.
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }
}

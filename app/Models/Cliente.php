<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany; // <-- Adicionado

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome', 'cpf', 'rg', 'telefone', 'contato', 'endereco', 'cidade',
        'estado', 'cep', 'nome_propriedade', 'area_total_ha', 'cultura_principal',
        'status', 'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Um cliente pode ter muitas visitas técnicas.
     */
    public function visitasTecnicas(): HasMany // <-- Adicionado
    {
        return $this->hasMany(VisitaTecnica::class);
    }
}

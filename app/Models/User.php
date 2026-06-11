<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'data_nascimento',
        'celular',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'data_nascimento' => 'date',
    ];

    /**
     * Um usuário (agrônomo) pode ter muitos clientes.
     */
    public function clientes(): HasMany
    {
        return $this->hasMany(Cliente::class);
    }

    /**
     * Um usuário (agrônomo) pode ter muitas visitas técnicas.
     */
    public function visitas(): HasMany
    {
        return $this->hasMany(VisitaTecnica::class);
    }

    /**
     * NOVO: Um usuário (agrônomo) pode ter muitos relatórios.
     */
    public function relatorios(): HasMany
    {
        return $this->hasMany(Relatorio::class);
    }

    /**
     * Retorna o celular formatado no padrão brasileiro (xx) xxxxx-xxxx
     */
    public function getCelularFormatadoAttribute(): ?string
    {
        if (!$this->celular) {
            return null;
        }

        $numero = preg_replace('/\D/', '', $this->celular);

        if (strlen($numero) === 11) {
            return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $numero);
        } elseif (strlen($numero) === 10) {
            return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $numero);
        }

        return $this->celular;
    }
}

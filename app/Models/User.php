<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    // Remova ou mantenha 'HasApiTokens' aqui com base na sua decisão.
    // use HasApiTokens, HasFactory, Notifiable; // Original se usando Sanctum
    use HasFactory, Notifiable; // Se você NÃO USA Sanctum, use esta linha

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
        'data_nascimento' => 'date', // Certifique-se de que está aqui para o cast de data
    ];

    /**
     * Um usuário (agrônomo) pode ter muitos clientes.
     */
    public function clientes(): HasMany
    {
        return $this->hasMany(Cliente::class);
    }

    /**
     * NOVO: Um usuário (agrônomo) pode ter muitas visitas técnicas.
     */
    public function visitas(): HasMany
    {
        return $this->hasMany(VisitaTecnica::class);
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

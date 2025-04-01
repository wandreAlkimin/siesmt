<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

 protected $fillable = [
        'nome',
        'email',
        'password',
        'cpf',
        'data_nascimento'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'data_nascimento'   => 'date',
    ];

    /**
     * Atributos que serão automaticamente adicionados na serialização.
     *
     * @var array
     */
    protected $appends = ['idade'];

    /**
     * Accessor para calcular a idade com base na data de nascimento.
     */
    public function getIdadeAttribute()
    {
        if ($this->data_nascimento) {
            return Carbon::parse($this->data_nascimento)->age;
        }
        return null;
    }


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function fotoPessoas() {
        return $this->hasMany(FotoPessoa::class);
    }

    public function servidoresEfetivos() {
        return $this->hasOne(ServidorEfetivo::class);
    }

    public function servidoresEfetivosCompleto() {
        return $this->servidoresEfetivos()->with('user');
    }

    public function servidoresTemporarios() {
        return $this->hasOne(ServidorTemporario::class);
    }

    public function servidoresTemporariosCompleto() {
        return $this->servidoresTemporarios()->with('user');
    }

    public function lotacoes() {
        return $this->hasMany(Lotacao::class);
    }

    public function lotacoesUnidades() {
        return $this->lotacoes()->with('unidade.enderecos');
    }

    public function enderecos() {
        return $this->belongsToMany(Endereco::class, 'pessoa_enderecos', 'user_id', 'endereco_id')->withTimestamps();
    }

    public function enderecosCompletos()
    {
        return $this->enderecos()->with('cidade.estado');
    }
}

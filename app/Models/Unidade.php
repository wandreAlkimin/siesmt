<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unidade extends Model {

    use SoftDeletes;

    protected $table = 'unidades';

    protected $fillable = ['nome', 'sigla'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function lotacoes() {
        return $this->hasMany(Lotacao::class);
    }
    public function enderecos() {
        return $this->belongsToMany(Endereco::class, 'unidade_enderecos', 'unidade_id', 'endereco_id')->withTimestamps();
    }
}
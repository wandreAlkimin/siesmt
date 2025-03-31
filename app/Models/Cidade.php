<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cidade extends Model {

    use SoftDeletes;

    protected $table = 'cidades';

    protected $fillable = ['estado_id', 'nome'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function estado() {
        return $this->belongsTo(Estado::class);
    }

    public function enderecos() {
        return $this->hasMany(Endereco::class);
    }
}
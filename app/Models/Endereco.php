<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Endereco extends Model {

    use SoftDeletes;

    protected $table = 'enderecos';

    protected $fillable = ['logradouro', 'numero', 'bairro', 'cidade_id'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function cidade() {
        return $this->belongsTo(Cidade::class);
    }

    public function unidades() {
        return $this->belongsToMany(Unidade::class, 'unidade_enderecos', 'endereco_id', 'unidade_id')->withTimestamps();
    }

    public function usuarios() {
        return $this->belongsToMany(User::class, 'pessoa_enderecos', 'endereco_id', 'user_id')->withTimestamps();
    }
}
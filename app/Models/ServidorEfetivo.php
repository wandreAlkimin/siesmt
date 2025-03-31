<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServidorEfetivo extends Model {

    use SoftDeletes;

    protected $table = 'servidor_efetivos';

    protected $fillable = ['user_id', 'matricula'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function todosDados()
    {
        return $this->user()->with(['lotacoesUnidades', 'fotoPessoas']);
    }
}

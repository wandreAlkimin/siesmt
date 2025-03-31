<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServidorTemporario extends Model {

    use SoftDeletes;

    protected $table = 'servidor_temporarios';
    
    protected $fillable = ['user_id', 'data_admissao', 'data_desligamento'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
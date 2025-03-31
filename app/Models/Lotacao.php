<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lotacao extends Model {

    use SoftDeletes;

    protected $table = 'lotacoes';

    protected $fillable = ['data_lotacao', 'data_remocao', 'portaria', 'user_id', 'unidade_id'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function unidade() {
        return $this->belongsTo(Unidade::class);
    }
}
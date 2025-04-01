<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FotoPessoa extends Model {

    use SoftDeletes;

    protected $table = 'foto_pessoas';

    protected $fillable = ['user_id', 'data', 'bucket', 'hash', 'url'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}

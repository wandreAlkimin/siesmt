<?php

namespace App\Http\Controllers;

use App\Models\ServidorEfetivo;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\ApiCrudOperations;
use Illuminate\Database\QueryException;

class ServidorEfetivoController extends Controller
{
    use ApiCrudOperations;

    protected function getModel(): ServidorEfetivo
    {
        return new ServidorEfetivo();
    }

    protected function getValidationRulesStore(): array
    {
        return [
            'user_id' => 'required',
            'matricula' => 'required',
        ];
    }

    protected function getValidationRulesUpdate(): array
    {
        return [
        ];
    }
}

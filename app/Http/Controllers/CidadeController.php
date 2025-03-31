<?php

namespace App\Http\Controllers;

use App\Models\Cidade;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\ApiCrudOperations;
use Illuminate\Database\QueryException;

class CidadeController extends Controller
{
    use ApiCrudOperations;

    protected function getModel(): Cidade
    {
        return new Cidade();
    }

    protected function getValidationRulesStore(): array
    {
        return [
            'nome' => 'required|string',
            'estado_id' => 'required',
        ];
    }

    protected function getValidationRulesUpdate(): array
    {
        return [
            'nome' => 'required|string',
        ];
    }
}

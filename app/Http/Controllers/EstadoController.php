<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\ApiCrudOperations;
use Illuminate\Database\QueryException;

class EstadoController extends Controller
{
    use ApiCrudOperations;

    protected function getModel(): Estado
    {
        return new Estado();
    }

    protected function getValidationRulesStore(): array
    {
        return [
            'sigla' => 'required|string|max:2',
            'nome' => 'required|string',
        ];
    }

    protected function getValidationRulesUpdate(): array
    {
        return [
            'sigla' => 'required|string|max:2',
            'nome' => 'required|string',
        ];
    }
}

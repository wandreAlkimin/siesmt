<?php

namespace App\Http\Controllers;

use App\Models\Unidade;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\ApiCrudOperations;
use Illuminate\Database\QueryException;

class UnidadeController extends Controller
{
    use ApiCrudOperations;

    protected function getModel(): Unidade
    {
        return new Unidade();
    }

    protected function getValidationRulesStore(): array
    {
        return [
            'nome' => 'required',
            'sigla' => 'required',
        ];
    }

    protected function getValidationRulesUpdate(): array
    {
        return [
        ];
    }
}

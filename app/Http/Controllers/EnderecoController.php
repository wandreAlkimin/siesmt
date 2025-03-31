<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\ApiCrudOperations;
use Illuminate\Database\QueryException;

class EnderecoController extends Controller
{
    use ApiCrudOperations;

    protected function getModel(): Endereco
    {
        return new Endereco();
    }

    protected function getValidationRulesStore(): array
    {
        return [
            'cidade_id' => 'required',
            'bairro' => 'required',
            'numero' => 'required',
            'logradouro' => 'required',
        ];
    }

    protected function getValidationRulesUpdate(): array
    {
        return [
        ];
    }
}

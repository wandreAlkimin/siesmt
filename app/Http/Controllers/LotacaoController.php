<?php

namespace App\Http\Controllers;

use App\Models\Lotacao;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\ApiCrudOperations;
use Illuminate\Database\QueryException;

class LotacaoController extends Controller
{
    use ApiCrudOperations;

    protected function getModel(): Lotacao
    {
        return new Lotacao();
    }

    protected function getValidationRulesStore(): array
    {
        return [
            'unidade_id' => 'required',
            'user_id' => 'required',
            'data_lotacao' => 'required',
            'portaria' => 'required',
        ];
    }



    protected function getValidationRulesUpdate(): array
    {
        return [
        ];
    }
}

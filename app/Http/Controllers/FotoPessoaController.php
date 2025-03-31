<?php

namespace App\Http\Controllers;

use App\Models\FotoPessoa;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\ApiCrudOperations;
use Illuminate\Database\QueryException;

class FotoPessoaController extends Controller
{
    use ApiCrudOperations;

    protected function getModel(): FotoPessoa
    {
        return new FotoPessoa();
    }

    protected function getValidationRulesStore(): array
    {
        return [
            'user_id' => 'required',
        ];
    }

    protected function getValidationRulesUpdate(): array
    {
        return [
        ];
    }
}

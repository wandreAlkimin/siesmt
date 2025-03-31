<?php

namespace App\Http\Controllers;

use App\Models\ServidorTemporario;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\ApiCrudOperations;
use Illuminate\Database\QueryException;

class ServidorTemporarioController extends Controller
{
    use ApiCrudOperations;

    protected function getModel(): ServidorTemporario
    {
        return new ServidorTemporario();
    }

    protected function getValidationRulesStore(): array
    {
        return [
            'user_id' => 'required',
            'data_admissao' => 'required',
        ];
    }

    protected function getValidationRulesUpdate(): array
    {
        return [
        ];
    }
}

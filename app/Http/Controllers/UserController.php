<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\ApiCrudOperations;
use Illuminate\Database\QueryException;

class UserController extends Controller
{
    use ApiCrudOperations;

    protected function getModel(): User
    {
        return new User();
    }

    protected function getValidationRulesStore(): array
    {
        return [
            'nome' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ];
    }

    protected function getValidationRulesUpdate(): array
    {
        return [
        ];
    }
}

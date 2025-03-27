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
}

<?php

namespace App\Http\Controllers\Traits;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

trait ApiCrudOperations
{
    abstract protected function getModel(): Model;

    protected function getValidationRules(): array
    {
        return [];
    }

    protected function successResponse($data = null, $message = null, $status = 200): JsonResponse
    {
        $response = [
            'data' => $data,
            'message' => $message,
            'result' => true,
        ];

        return new JsonResponse($response, $status);
    }

    protected function errorResponse($message, $erroInterno, $status = 400): JsonResponse
    {
        $response = [
            'data' => false,
            'message' => $message,
            'result' => false,
            'erroInterno' => $erroInterno,
        ];

        return new JsonResponse($response, $status);
    }

    public function search(Request $request)
    {

        try {
            $model = $this->getModel();
            $query = $model::query();

            $resultados = $this->aplicarFiltros($query, $request->all());

            if ($resultados->isEmpty()) {
                return $this->errorResponse('Nenhum item encontrado', 'NenhumEncontrado', 404);
            }

            return $this->successResponse($resultados, 'Resultado recuperado com sucesso');
        } catch (QueryException $e) {
            // Registra a mensagem de erro no log
            Log::error('Ocorreu um erro ao recuperar os registros.', ['exception' => $e]);
            return $this->errorResponse('Ocorreu um erro ao recuperar os registros.', $e->getMessage());
        }
    }

    protected function aplicarFiltros(Builder $query, array $request)
    {
        $limit = isset($request['limit']) ? (int)$request['limit'] : 10;

        unset($request['page'], $request['limit']);

        foreach ($request as $campo => $valor) {
            if ($valor !== null && $valor !== "null") {
                $query->orWhere($campo, 'LIKE', '%' . $valor . '%');
            }
        }

        return $limit ? $query->paginate($limit) : $query->paginate();
    }

    // Método para listar todos os itens
    public function index(Request $request)
    {
        try {
            $model = $this->getModel();
            $limit = $request->input('limit', 10);
            $items = $model::paginate($limit);
            return $this->successResponse($items);
        } catch (\Exception $e) {
            Log::error('Erro interno ao listar todos os itens.', ['exception' => $e]);
            return $this->errorResponse('Erro interno ao listar todos os itens.', $e->getMessage(), 500);
        }
    }

    public function show($id)
    {
        try {
            $model = $this->getModel();
            $item = $model::find($id);

            if (!$item) {
                return $this->errorResponse('Item não encontrado', 'NãoEncontrado', 404);
            }

            return $this->successResponse($item);
        } catch (\Exception $e) {
            Log::error('Erro interno ao exibir um item.', ['exception' => $e]);
            return $this->errorResponse('Erro interno ao exibir um item.', $e->getMessage(), 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $model = $this->getModel();

            $validator = Validator::make($request->all(), $this->getValidationRules());

            if ($validator->fails()) {
                return $this->errorResponse('Erro de validação', $validator->errors(), 422);
            }

            $item = $model::create($request->all());

            return $this->successResponse($item, 'Item criado com sucesso', 201);
        } catch (\Exception $e) {
            Log::error('Erro interno ao criar um novo item.', ['exception' => $e]);
            return $this->errorResponse('Erro interno ao criar um novo item.', $e->getMessage(), 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $model = $this->getModel();

            $validator = Validator::make($request->all(), $this->getValidationRules());

            if ($validator->fails()) {
                return $this->errorResponse('Erro de validação', $validator->errors(), 422);
            }

            $item = $model::find($id);

            if (!$item) {
                return $this->errorResponse('Item não encontrado', 'NãoEncontrado', 404);
            }

            $item->update($request->all());

            return $this->successResponse($item, 'Item atualizado com sucesso');
        } catch (\Exception $e) {
            Log::error('Erro interno ao atualizar um item.', ['exception' => $e]);
            return $this->errorResponse('Erro interno ao atualizar um item.', $e->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        try {
            $model = $this->getModel();

            $item = $model::find($id);

            if (!$item) {
                return $this->errorResponse('Item não encontrado', 'NãoEncontrado', 404);
            }

            $item->delete();

            return $this->successResponse(null, 'Item excluído com sucesso');
        } catch (\Exception $e) {
            Log::error('Erro interno ao excluir um item.', ['exception' => $e]);
            return $this->errorResponse('Erro interno ao excluir um item.', $e->getMessage(), 500);
        }
    }
}

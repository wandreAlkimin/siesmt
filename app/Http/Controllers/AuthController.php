<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\JWT;
use App\Http\Controllers\Traits\ApiCrudOperations;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ApiCrudOperations;

    protected function getModel(): User
    {
        return new User();
    }

    public function __construct()
    {
        $this->middleware('jwt.validar', ['except' => ['login','register','refresh']]);
    }

    public function validacao(Request $request){

        try {
            $token = JWTAuth::getToken();
            JWTAuth::checkOrFail($token);
            return response()->json(['success' => true]);

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return $this->errorResponse('Token expirado', $e->getMessage(), 401);

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return $this->errorResponse('Token inválido', $e->getMessage(), 401);

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return $this->errorResponse('Erro ao processar o token', $e->getMessage(), 500);
        }
    }

    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');

        $token = auth('api')->attempt($credentials);
        if (!$token) {
            return $this->errorResponse('Não autorizado', 'erro', 401);
        }

        $user = auth()->user();

        return response()->json([
            'data' => $user,
            'message' => 'Login efetuado com sucesso',
            'result' => true,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function register(Request  $request){

        // Verificar se já existe um usuário com o mesmo e-mail
        $existingUser = User::where('email', $request->email)->first();
        if ($existingUser) {
            return $this->errorResponse('Email já registrado', '', 422);
        }

        $validator = Validator::make($request->all(), [
             'nome' => 'required|string',
             'email' => 'required|email',
             'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Erro de validação', $validator->errors(), 422);
        }

        $user = User::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromUser($user);
        return response()->json([
            'data' => $user,
            'message' => 'Usuario registrado com sucesso',
            'result' => true,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json([
                'result' => false,
                'message' => 'Token não fornecido'
            ], 401);
        }

         auth('api')->logout();
         return response()->json([
             'data' => '',
             'message' => 'Usuario deslogado',
             'result' => true
         ]);
    }

    public function refresh(Request $request)
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json([
                'result' => false,
                'message' => 'Token não fornecido'
            ], 401);
        }

        try {
            $newToken = auth('api')->refresh();
            return response()->json([
                'data' => auth('api')->user(),
                'message' => 'Token atualizado',
                'result' => true,
                'authorization' => [
                    'token' => $newToken,
                    'type' => 'bearer',
                ]
            ]);
        } catch (\PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException $e) {
            return response()->json([
                'result' => false,
                'message' => 'Erro ao atualizar o token: ' . $e->getMessage()
            ], 401);
        }
    }
}

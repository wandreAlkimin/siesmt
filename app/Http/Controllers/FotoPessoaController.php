<?php

namespace App\Http\Controllers;

use App\Models\FotoPessoa;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\ApiCrudOperations;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Aws\Credentials\Credentials;
use Aws\S3\S3Client;

class FotoPessoaController extends Controller
{
    use ApiCrudOperations;

    protected function getModel(): FotoPessoa
    {
        return new FotoPessoa();
    }

    public function upload(Request $request)
    {

        $validator = Validator::make($request->all(), [
             'foto'    => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
             'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Erro de validação', $validator->errors(), 422);
        }

        try {

            $file = $request->file('foto');
            $path = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

            $validacao = Storage::disk('s3')->put($path, file_get_contents($file));
            if($validacao == false){
                 return $this->errorResponse('Erro interno ao criar um novo item.', 'Erro ao fazer upload da foto para o s3', 500);
            }

            // Cria um novo S3Client
            $credentials = new Credentials(
                config('filesystems.disks.s3.key'),
                config('filesystems.disks.s3.secret')
            );

            $s3Client = new S3Client([
                'version'               => 'latest',
                'region'                => config('filesystems.disks.s3.region'),
                'endpoint'              => 'http://localhost:9000',
                'use_path_style_endpoint' => true,
                'credentials'           => $credentials,
            ]);

            // comando para ter o objeto
            $command = $s3Client->getCommand('GetObject', [
                'Bucket' => config('filesystems.disks.s3.bucket'), // Ex: "arquivos"
                'Key'    => $path,
            ]);

            // Gera a URL
            $requestPresigned = $s3Client->createPresignedRequest($command, '+5 minutes');
            $url = (string) $requestPresigned->getUri();

            $foto = FotoPessoa::create([
                'user_id' => $request->input('user_id'),
                'data'    => now(),
                'bucket'  => config('filesystems.disks.s3.bucket'),
                'hash'    => md5($path . now()), // gera um hash
                'url'     => $url,
            ]);

            return $this->successResponse($foto, 'Item criado com sucesso', 201);

        } catch (QueryException $e) {
             Log::error('Erro interno ao criar um novo item.', ['exception' => $e]);
             return $this->errorResponse('Erro interno ao criar um novo item.', $e->getMessage(), 500);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class PrimeirosRegistrosSeeder extends Seeder
{
    public function run(): void
    {
           $faker = Faker::create('pt_BR');

           // --- Tabela users ---
           $userIds = [];
           for ($i = 0; $i < 3; $i++) {
               $userIds[] = DB::table('users')->insertGetId([
                   'nome'              => $faker->name,
                   'email'             => $faker->unique()->safeEmail,
                   'password'          => Hash::make('12345678'), // senha padrão
                   'cpf'               => $faker->numerify('###.###.###-##'),
                   'data_nascimento'   => $faker->date('Y-m-d', '2002-12-31'),
               ]);
           }

           // --- Tabela enderecos Cidade de Brasilia DF ---
           $enderecoIds = [];
           for ($i = 1; $i < 5; $i++) {
               $enderecoIds[] = DB::table('enderecos')->insertGetId([
                   'logradouro' => $faker->streetAddress,
                   'numero'     => $faker->numberBetween(1, 1000),
                   'bairro'     => $faker->word,
                   'cidade_id'  => 1799,
               ]);
           }

           // --- Tabela foto_pessoas (associada a um usuário) ---
           for ($i = 1; $i < 4; $i++) {
               DB::table('foto_pessoas')->insert([
                   'user_id'    => $i,
                   'data'       => now()->format('Y-m-d'),
                   'bucket'     => $faker->word,
                   'hash'       => md5($faker->word),
               ]);
           }

           // --- Tabela servidor_efetivos (associada a um usuário) ---
           for ($i = 1; $i < 4; $i++) {
               DB::table('servidor_efetivos')->insert([
                   'user_id'    => $i,
                   'matricula'  => $faker->bothify('??-####'),
               ]);
           }

           // --- Tabela servidor_temporarios (associada a um usuário) ---
           for ($i = 1; $i < 4; $i++) {
               DB::table('servidor_temporarios')->insert([
                   'user_id'           => $i,
                   'data_admissao'     => $faker->date,
               ]);
           }

           // --- Tabela unidades ---
           $unidadeIds = [];
           for ($i = 0; $i < 10; $i++) {
               $unidadeIds[] = DB::table('unidades')->insertGetId([
                   'nome'       => $faker->company,
                   'sigla'      => strtoupper($faker->lexify('???')),
               ]);
           }

           // --- Tabela lotacoes (associada a um usuário e uma unidade) ---
           for ($i = 1; $i < 4; $i++) {
               DB::table('lotacoes')->insert([
                   'user_id'      => $i,
                   'unidade_id'   => $faker->randomElement($unidadeIds),
                   'data_lotacao' => $faker->date,
                   'portaria'     => $faker->bothify('Portaria-####'),
               ]);
           }

           // --- Tabela unidade_enderecos (relaciona unidades com endereços) ---
           for ($i = 1; $i < 4; $i++) {
               DB::table('unidade_enderecos')->insert([
                   'unidade_id' => $unidadeIds[$i],
                   'endereco_id'=> $enderecoIds[$i],
               ]);
           }

           // --- Tabela pessoa_enderecos (relaciona usuários com endereços) ---
           for ($i = 1; $i < 3; $i++) {
               DB::table('pessoa_enderecos')->insert([
                   'user_id'     => $userIds[$i],
                   'endereco_id' => $enderecoIds[$i],
               ]);
           }
    }
}

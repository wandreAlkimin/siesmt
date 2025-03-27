<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Database\QueryException;

class ImportEstadosCidadesSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('estadoscidades.sql');
        if (File::exists($path)) {
            $sql = File::get($path);

            // Substitui \'
            $sql = str_replace("\\'", "''", $sql);

            // Divide as queries individuais
            $queries = preg_split('/;\s*[\r\n]+/', $sql);

            foreach ($queries as $query) {
                $query = trim($query);
                if (!empty($query)) {
                    try {
                        DB::statement($query);
                    } catch (QueryException $e) {
                        logger()->error("Erro executando query: {$query}", ['error' => $e->getMessage()]);
                        throw $e;
                    }
                }
            }
        }
    }
}

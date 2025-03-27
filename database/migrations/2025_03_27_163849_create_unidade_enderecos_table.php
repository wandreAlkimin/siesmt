<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('unidade_enderecos', function (Blueprint $table) {
            $table->unsignedInteger('unidade_id');
            $table->unsignedInteger('endereco_id');

            $table->primary(['unidade_id', 'endereco_id']);

            $table->foreign('unidade_id')->references('id')->on('unidades');
            $table->foreign('endereco_id')->references('id')->on('enderecos');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unidade_enderecos');
    }
};

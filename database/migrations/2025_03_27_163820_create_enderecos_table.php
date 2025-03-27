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
         Schema::create('enderecos', function (Blueprint $table) {
                $table->increments('id');
                $table->string('logradouro', 200);
                $table->integer('numero')->nullable();
                $table->string('bairro', 50)->nullable();
                $table->unsignedInteger('cidade_id');
                $table->foreign('cidade_id')->references('id')->on('cidades');
                $table->timestamps();
                $table->softDeletes();
          });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enderecos');
    }
};

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
        Schema::create('lotacoes', function (Blueprint $table) {
            $table->increments('id');
            $table->date('data_lotacao');
            $table->date('data_remocao')->nullable();
            $table->string('portaria', 100);
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedInteger('unidade_id');
            $table->foreign('unidade_id')->references('id')->on('unidades');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lotacaos');
    }
};

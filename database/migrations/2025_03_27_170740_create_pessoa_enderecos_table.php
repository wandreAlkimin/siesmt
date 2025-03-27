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
        Schema::create('pessoa_enderecos', function (Blueprint $table) {
               $table->unsignedInteger('user_id');
               $table->unsignedInteger('endereco_id');
               $table->primary(['user_id', 'endereco_id']);
               $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('pessoa_enderecos');
    }
};

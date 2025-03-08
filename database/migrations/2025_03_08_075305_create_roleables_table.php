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
        Schema::create('roleables', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('roleable_id'); // ID связанной модели
            $table->string('roleable_type'); // Тип связанной модели

            // Внешний ключ для ролей
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

            // Составной индекс для полиморфной связи
            $table->index(['roleable_id', 'roleable_type']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roleables');
    }
};

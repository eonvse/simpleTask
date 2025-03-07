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
        Schema::create('worker_task', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Worker::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(App\Models\Task::class)->constrained()->cascadeOnDelete();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('worker_task');
    }
};

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
        Schema::create('volquetas', function (Blueprint $table) {
            $table->id();
            $table->string('placa', 10)->unique()->nullable(false);
            $table->string('propietario')->nullable(false);
            $table->string('conductor')->nullable(false);
            $table->float('cubicaje')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volquetas');
    }
};

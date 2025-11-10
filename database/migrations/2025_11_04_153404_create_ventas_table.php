<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();

            // Ahora cliente_id y volqueta_id pueden ser NULL
            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->unsignedBigInteger('volqueta_id')->nullable();

            $table->string('ticket_mina'); // Cambiado a string para formato 000001
            $table->string('ticket_transporte')->nullable();

            // Datos que pueden venir de volquetas o ser ingresados manualmente
            $table->string('propietario');
            $table->string('conductor');
            $table->string('placa');
            $table->decimal('cubicaje', 8, 3);

            // Cliente puede ser un nombre directo si no está en la tabla
            $table->string('cliente_nombre');

            $table->string('material');
            $table->string('tipo_volqueta');
            $table->string('origen');
            $table->string('destino');

            $table->date('fecha');
            $table->time('hora');

            $table->timestamps();

            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('set null');
            $table->foreign('volqueta_id')->references('id')->on('volquetas')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
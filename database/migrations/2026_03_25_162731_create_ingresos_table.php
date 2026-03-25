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
        Schema::create('ingresos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campos_id')->constrained('campos')->onDelete('cascade');
            $table->date('fechaIngreso');
            $table->double('monto', 15, 2);
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->foreignId('guardianes_id')->constrained('guardianes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingresos');
    }
};

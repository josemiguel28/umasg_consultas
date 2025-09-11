<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            $table->string('route_code', 50)->nullable();   // Ruta 
            $table->string('customer_code', 50)->index();  // Clave 
            $table->string('owner_name');                  // Propietario
            $table->string('address')->nullable();         // Direccion
            $table->string('category', 50)->nullable();    // Categoria 
            $table->string('status', 20)->nullable();      // Estado (ej. Activo/Inactivo)
            $table->boolean('has_meter')->default(false);  // Tiene_med (Y/N)
            $table->string('meter_code', 50)->nullable();  // Medidor (puede estar vacío)

            $table->integer('month_billed')->default(0);      // Mesfacturado
            $table->decimal('balance_water', 10, 2)->default(0);   // Saldoagua
            $table->decimal('balance_sewer', 10, 2)->default(0);   // Saldoalca
            $table->decimal('balance_other', 10, 2)->default(0);   // Saldootro

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};

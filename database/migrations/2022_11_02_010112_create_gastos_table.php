<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gastos', function (Blueprint $table) {
            $table->id();
            $table->float('monto');
            $table->float('monto_total');
            $table->integer('cantidad');
            $table->float('flete');
            $table->foreignId('fk_cliente')->constrained('clientes');
            $table->foreignId('fk_producto')->constrained('productos');
            $table->foreignId('fk_tipo')->constrained('tipo_gasto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gastos');
    }
};

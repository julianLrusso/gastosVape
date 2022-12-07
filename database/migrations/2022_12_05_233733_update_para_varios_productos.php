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
        Schema::table('gastos', function (Blueprint $table) {
            $table->dropForeign(['fk_producto']);
            $table->dropColumn('fk_producto');
        });

        Schema::create('gastos_tienen_productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fk_producto')->constrained('productos');
            $table->foreignId('fk_factura')->constrained('gastos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};

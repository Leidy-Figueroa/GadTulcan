<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('fecha_ingreso');
            $table->timestamp('fecha_actualizacion')->nullable();
            $table->string('serie')->unique();
            $table->string('serieGAD')->nullable()->unique();
            $table->text('descripcion');
            $table->string('imagen')->nullable();
            $table->softDeletes();

            $table->foreignId('user_id')->constrained('users')->unsigned()->nullable();
            $table->foreignId('estado_id')->constrained('estados')->nullable();
            $table->foreignId('marca_id')->constrained('marcas')->nullable();
            $table->foreignId('modelo_id')->constrained('modelos')->nullable();
            $table->foreignId('detalle_id')->constrained('detalles')->nullable();
            $table->foreignId('departamento_id')->constrained('departamentos')->nullable();
            $table->foreignId('incidencia_id')->constrained('incidents')->unsigned()->nullable();
    
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
        Schema::dropIfExists('productos');
    }
}

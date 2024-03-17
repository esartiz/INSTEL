<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMallasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mallas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mdl')->constrained('modulos');
            $table->foreignId('prg')->constrained('programas');
            $table->foreignId('docente')->constrained('users');
            $table->string('semestre');
            $table->integer('semanas');
            $table->date('fecha1');
            $table->date('fecha2');
            $table->date('fecha3');
            $table->date('fecha4');
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
        Schema::dropIfExists('mallas');
    }
}

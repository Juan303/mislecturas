<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablasUsuarios extends Migration
{
    public function up()
    {
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token')->index();
            $table->timestamp('created_at');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('active')->default(false);
            $table->boolean('admin')->default(false);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('colecciones', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned()->primary();
            $table->string('titulo');
            $table->string('tituloOriginal')->nullable()->default(null);
            $table->text('sinopsis')->nullable();
            $table->integer('numero_comics_editados')->nullable()->default(null);
            $table->longText('datosColeccion')->nullable();
            $table->tinyInteger('completa')->default(null)->nullable();
            $table->decimal('putuacion')->default(null)->nullable();
            $table->timestamps();
        });

        Schema::create('comics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('numero')->nullable()->default(null);
            $table->tinyInteger('numeroUnico')->nullable()->default(null);
            $table->integer('numeroPaginasBN')->nullable()->default(null);
            $table->integer('numeroPaginasColor')->nullable()->default(null);
            $table->string('tipo')->nullable()->default(null);
            $table->decimal('precio')->nullable()->default(null);
            $table->char('moneda')->nullable()->default(null);
            $table->string('imagen')->nullable()->default(null);
            $table->string('fecha')->nullable()->default(null);
            $table->timestamps();

            //FK
            $table->bigInteger('coleccion_id')->unsigned();
            $table->foreign('coleccion_id')->references('id')->on('colecciones')->onDelete('cascade');

        });


        Schema::create('usuario_colecciones', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned()->index();

            $table->json('datos')->nullable();
            $table->decimal('puntuacion')->nullable()->default(null);

            $table->timestamps();

            //FK
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->bigInteger('coleccion_id')->unsigned();
            $table->foreign('coleccion_id')->references('id')->on('colecciones')->onDelete('cascade');

        });

        Schema::create('usuario_comics', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->json('datos')->nullable();
            $table->tinyInteger('tengo')->default(0)->nullable()->index();
          /*  $table->tinyInteger('estado_lectura')->default(0)->nullable()->index();
            $table->timestamp('fecha_inicio_lectura')->nullable()->default(null);
            $table->timestamp('fecha_fin_lectura')->nullable()->default(null);*/

            $table->timestamps();

            //FK
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->bigInteger('usuario_coleccion_id')->unsigned();
            $table->foreign('usuario_coleccion_id')->references('id')->on('usuario_colecciones')->onDelete('cascade');

            $table->bigInteger('comic_id')->unsigned();
            $table->foreign('comic_id')->references('id')->on('comics')->onDelete('cascade');
        });

        Schema::create('usuario_lecturas', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->timestamp('fecha_inicio_lectura')->nullable()->default(null);
            $table->timestamp('fecha_fin_lectura')->nullable()->default(null);
            $table->integer('paginas_leidas')->nullable()->default(null);
            $table->integer('paginas_totales')->nullable()->default(null);
            $table->tinyInteger('estado_lectura')->nullable()->default(0);

            $table->timestamps();

            //FK
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');


            $table->bigInteger('comic_id')->unsigned();
            $table->foreign('comic_id')->references('id')->on('comics')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuario_lecturas');
        Schema::dropIfExists('usuario_comics');
        Schema::dropIfExists('usuario_colecciones');
    }
}

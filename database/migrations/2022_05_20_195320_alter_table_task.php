<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableTask extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {

            $table->string('cliente', 200)->nullable();
            $table->string('consultor', 200)->nullable();
            $table->string('contato', 200)->nullable();
            $table->string('telefone', 200)->nullable();
            $table->string('origem_indicacao', 200)->nullable();
            $table->string('fabricante', 200)->nullable();
            $table->string('produto', 200)->nullable();
            $table->string('m2', 200)->nullable();
            $table->string('valor', 200)->nullable();
            $table->string('situacao', 200)->nullable();
            $table->string('cep', 200)->nullable();
            $table->string('rua', 200)->nullable();
            $table->string('bairro', 200)->nullable();
            $table->string('cidade', 200)->nullable();
            $table->string('uf', 200)->nullable();
            $table->string('cnpj', 200)->nullable();
            $table->string('email_1', 200)->nullable();
            $table->string('email_2', 200)->nullable();
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
}

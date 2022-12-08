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
        Schema::create('environments', function (Blueprint $table) {
            $table->id();
            $table->integer('emossion_year');
            $table->string('emitter_code');
            $table->integer('company_id');
            $table->text('energy_co2');
            $table->text('non_energy_co2');
            $table->text('non_energy_co2_2');
            $table->text('ch4');
            $table->text('n2o');
            $table->text('hfc');
            $table->text('pfc');
            $table->text('sf6');
            $table->text('nf3');
            $table->text('energy_co2_3');
            $table->text('before_gas_emission');
            $table->text('after_gas_emission');
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
        Schema::dropIfExists('environments');
    }
};

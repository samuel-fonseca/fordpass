<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('nickname')->nullable();
            $table->string('vin');
            $table->string('vehicle_type')->nullable();
            $table->string('color');
            $table->string('model_name');
            $table->string('model_code');
            $table->string('model_year');
            $table->integer('tcu_enabled')->unsigned();
            $table->string('local_market_value');
            $table->string('territory_description');
            $table->json('authorization_status');
            $table->json('recal_info');
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
        Schema::dropIfExists('vehicles');
    }
};

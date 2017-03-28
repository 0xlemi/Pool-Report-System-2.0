<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // General Settings
                // Administrator Profile information
                $table->string('name');
            // Company information
                $table->string('company_name');
                $table->decimal('latitude', 9, 6)->nullable();
                $table->decimal('longitude', 9, 6)->nullable();
                $table->string('timezone');
                $table->char('language', 2)->default('en');
                $table->string('website')->nullable();
                $table->string('facebook')->nullable();
                $table->string('twitter')->nullable();
            // System Values
                // ph
                $table->string('ph_very_low')->default('Very Low'); // 1
                $table->string('ph_low')->default('Low'); // 2
                $table->string('ph_perfect')->default('Perfect'); // 3
                $table->string('ph_high')->default('High'); // 4
                $table->string('ph_very_high')->default('Very High'); // 5
                // chlorine
                $table->string('chlorine_very_low')->default('Very Low'); // 1
                $table->string('chlorine_low')->default('Low'); // 2
                $table->string('chlorine_perfect')->default('Perfect'); // 3
                $table->string('chlorine_high')->default('High'); // 4
                $table->string('chlorine_very_high')->default('Very High'); // 5
                // temperature
                $table->string('temperature_very_low')->default('Very Low'); // 1
                $table->string('temperature_low')->default('Low'); // 2
                $table->string('temperature_perfect')->default('Perfect'); // 3
                $table->string('temperature_high')->default('High'); // 4
                $table->string('temperature_very_high')->default('Very High'); // 5
                // turbidity
                $table->string('turbidity_perfect')->default('Perfect'); // 1
                $table->string('turbidity_low')->default('Low'); // 2
                $table->string('turbidity_high')->default('High'); // 3
                $table->string('turbidity_very_high')->default('Very High'); // 4
                // salt
                $table->string('salt_very_low')->default('Very Low'); // 1
                $table->string('salt_low')->default('Low'); // 2
                $table->string('salt_perfect')->default('Perfect'); // 3
                $table->string('salt_high')->default('High'); // 4
                $table->string('salt_very_high')->default('Very High'); // 5

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
        Schema::dropIfExists('companies');
    }
}

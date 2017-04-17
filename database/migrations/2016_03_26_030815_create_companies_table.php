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

            // ***********************
            //   Company information
            // ***********************
                $table->string('name');
                $table->string('timezone');
                $table->char('language', 2)->default('en');
                $table->string('website')->nullable();
                $table->string('facebook')->nullable();
                $table->string('twitter')->nullable();
                $table->decimal('latitude', 9, 6)->nullable();
                $table->decimal('longitude', 9, 6)->nullable();

            // **************
            //    Billing
            // **************
                $table->integer('free_objects')->default(2);
                // Stripe
                $table->string('stripe_id')->nullable();
                $table->string('card_brand')->nullable();
                $table->string('card_last_four')->nullable();
                $table->timestamp('trial_ends_at')->nullable();

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

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('email')->unique()->index();
            $table->string('password');
            // change this to verified
            $table->boolean('verified')->default(false); // Activated the account via email

            $table->string('name');
            $table->string('last_name');
            $table->string('cellphone');
            $table->string('address');
            $table->char('language', 2)->default('en');
            $table->text('about');

            // **************
            //    Billing
            // **************
            $table->integer('free_objects')->default(2);
            // Stripe
            $table->string('stripe_id')->nullable();
            $table->string('card_brand')->nullable();
            $table->string('card_last_four')->nullable();
            $table->timestamp('trial_ends_at')->nullable();

            $table->string('api_token', 60)->unique();
            $table->rememberToken();
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
        Schema::drop('users');
    }
}

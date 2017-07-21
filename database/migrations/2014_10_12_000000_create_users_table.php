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
            $table->string('password')->nullable();
            $table->boolean('verified')->default(false); // Activated the account via email

            $table->string('name');
            $table->string('last_name')->nullable();
            $table->char('language', 2)->default('en');

            // Stripe
            // This is for charging the clients
            $table->string('stripe_id')->nullable()->index();
            $table->string('card_token')->nullable();
            $table->string('card_brand')->nullable();
            $table->string('card_last_four')->nullable();

            // $table->string('api_token', 60)->unique();
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

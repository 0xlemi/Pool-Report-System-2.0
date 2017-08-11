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
            $table->string('name');
            $table->string('timezone');
            $table->char('language', 2)->default('en');
            $table->string('website')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->decimal('latitude', 9, 6)->nullable();
            $table->decimal('longitude', 9, 6)->nullable();

            // Device Magic
            $table->string('destination_id')->nullable(); // removed
            $table->string('form_id')->nullable(); // removed
            $table->string('group_id')->unique()->nullable();

            // Billing
                $table->integer('free_objects')->default(0);
                // Stripe
                $table->string('stripe_id')->nullable()->index();
                $table->string('card_brand')->nullable();
                $table->string('card_last_four')->nullable();
                $table->timestamp('trial_ends_at')->nullable();

            // Stripe Connect Account
            $table->string('connect_id')->nullable()->index();
            $table->string('connect_email')->nullable();
            $table->string('connect_token')->nullable();
            $table->string('connect_refresh_token')->nullable();
            $table->string('connect_business_name')->nullable();
            $table->string('connect_business_url')->nullable();
            $table->string('connect_country')->nullable();
            $table->string('connect_currency')->nullable();
            $table->string('connect_support_email')->nullable();
            $table->string('connect_support_phone')->nullable();

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

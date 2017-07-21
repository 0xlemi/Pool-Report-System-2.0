<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRoleCompanyPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_role_company', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->integer('company_id')->unsigned();

            $table->string('cellphone')->nullable();
            $table->string('address')->nullable();
            $table->text('about')->nullable();

            // Device Magic
            $table->string('device_id')->unique()->nullable()->index();

            // SendBird Chat
            $table->uuid('chat_id')->unique()->nullable();
            $table->string('chat_nickname')->nullable();
            $table->string('chat_token')->nullable();

            $table->unsignedTinyInteger('type')->default(1); // Type meaning depends on the role

            $table->boolean('selected')->default(false); // We need to know which urc the user wants to use rigth now
            $table->boolean('accepted')->default(false); // Maybe the user don't what to be a part of this urc
            // Set this back to true when the custom app is here
            $table->boolean('paid')->default(false); // Billable active account

            $table->timestamps();

            $table->integer('seq_id')->unsigned()->index();
            $table->unique(['user_id', 'role_id', 'company_id']);
            $table->unique(['seq_id', 'company_id']);

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');
            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_role_company');
    }
}

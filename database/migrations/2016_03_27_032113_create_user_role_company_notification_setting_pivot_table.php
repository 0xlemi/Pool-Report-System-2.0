<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRoleCompanyNotificationSettingPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urc_notify_setting', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('urc_id')->unsigned();
            $table->integer('notify_setting_id')->unsigned();

            $table->timestamps();

            $table->primary(['urc_id', 'notify_setting_id']);

            $table->foreign('urc_id')
                ->references('id')
                ->on('user_role_company')
                ->onDelete('cascade');
            $table->foreign('notify_setting_id')
                ->references('id')
                ->on('notification_settings')
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
        Schema::dropIfExists('urc_notify_setting');
    }
}

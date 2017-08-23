<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUrcExtraEmailName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_role_company', function (Blueprint $table) {
            $table->string('name_extra')->nullable();
            $table->string('last_name_extra')->nullable();
            $table->string('email_extra')->nullable();

            // $table->boolean('change_email_request')->default(false);
            // $table->boolean('change_name_request')->default(false);

            $table->boolean('denied_change_email')->default(false);
            $table->boolean('denied_change_name')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_role_company', function (Blueprint $table) {
            $table->dropColumn([
                        'name_extra',
                        'last_name_extra',
                        'email_extra',
                        // 'change_email_request',
                        // 'change_name_request',
                        'denied_change_email',
                        'denied_change_name'
                    ]);
        });
    }
}

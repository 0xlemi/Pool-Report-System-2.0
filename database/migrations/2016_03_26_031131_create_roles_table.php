<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('id')->unsigned();
            $table->string('name')->unique();
            $table->string('route');
            $table->string('text');

            $table->primary('id');
        });

        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'admin', 'route' => '', 'text' => 'Company Administrator'],
            ['id' => 2, 'name' => 'client', 'route' => 'clients', 'text' => 'Client'],
            ['id' => 3, 'name' => 'sup', 'route' => 'supervisors', 'text' => 'Supervisor'],
            ['id' => 4, 'name' => 'tech', 'route' => 'technicians', 'text' => 'Technician'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}

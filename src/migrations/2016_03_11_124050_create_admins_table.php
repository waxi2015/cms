<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('password')->nullable();
            $table->string('photo')->nullable();
            $table->string('email')->nullable();
            $table->string('role')->nullable();
            $table->integer('status')->comment('0inactive|1active')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('admins')->insert(
            array(
                'email' => 'admin',
                'firstname' => 'Admin',
                'password' => bcrypt('admin'),
                'role' => 'admin',
                'status' => 1,
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('admins');
    }
}

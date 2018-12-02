<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersProjection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(env('DB_PROJECTION_CONNECTION'))->create('users', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name');
            $table->string('email');
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(env('DB_PROJECTION_CONNECTION'))->dropIfExists('users');
        
    }
}

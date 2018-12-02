<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NumUsersNotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(env('DB_PROJECTION_CONNECTION'))->create('num_user_notes', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('user_id');
            $table->integer('num_notes')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(env('DB_PROJECTION_CONNECTION'))->dropIfExists('num_user_notes');
        
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NotesFromUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(env('DB_PROJECTION_CONNECTION'))->create('notes_from_user', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('user_id');
            $table->uuid('note_id');
            $table->uuid('notepad_id');
            $table->string('title');
            $table->text('content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(env('DB_PROJECTION_CONNECTION'))->dropIfExists('notes_from_user');
        
    }
}

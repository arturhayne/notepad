<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NotesProjection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(env('DB_PROJECTION_CONNECTION'))->create('notes', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('title');
            $table->text('content');
            $table->primary('id');
            $table->uuid('notepad_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(env('DB_PROJECTION_CONNECTION'))->dropIfExists('notes');
        
    }
}

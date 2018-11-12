<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EventStore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_store', function (Blueprint $table) {
            $table->increments('event_id');
            $table->uuid('aggregate_id');
            $table->text('event_body');
            $table->string('type_name');
            $table->datetime('occured_on');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_store');
        
    }
}

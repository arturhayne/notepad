<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PublishedMessage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_published_message_tracker', function (Blueprint $table) {
            $table->increments('tracker_id');
            $table->bigInteger('most_recent_published_message_id');
            $table->string('exchange_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_published_message_tracker');
        
    }
}

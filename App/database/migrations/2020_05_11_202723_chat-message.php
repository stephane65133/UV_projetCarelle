<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChatMessage extends Migration
{
    public function up()
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sender_id');
            $table->unsignedInteger('group_id');
            $table->unsignedInteger('discussion_id');
            $table->unsignedInteger('parent_id')->nullable();
            $table->text('content')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->timestamp('sender_delete_at')->nullable();
            $table->timestamp('receiver_delete_at')->nullable();
            $table->timestamp('viewed_at')->nullable();
            $table->string('file')->nullable();
            $table->timestamps();

            $table->foreign('discussion_id')->references('id')->on('chat_discussions')->onDelete('cascade');
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_messages');
    }
}

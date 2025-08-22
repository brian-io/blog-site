<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Migration for votes table
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('vote'); // 1 for upvote, -1 for downvote
            $table->timestamps();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('comment_id')->constrained('comments')->onDelete('cascade');
            $table->unique(['user_id', 'comment_id']);
            $table->index(['comment_id', 'vote']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('votes');
    }
};

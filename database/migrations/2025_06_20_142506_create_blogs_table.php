<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();

            // Relationships
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            

            // Content
            $table->string('title');
            $table->string('slug')->unique()->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('content');

            // Featured image
            $table->string('featured_image')->nullable();

            // SEO
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();

            // Status Enum: draft, published, scheduled
            $table->enum('status', ['draft', 'published', 'scheduled'])->default('draft');

            // Some numbers
            $table->integer('reading_time')->nullable();
            $table->integer('view_count')->nullable();

            // Scheduling
            $table->timestamp('published_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};

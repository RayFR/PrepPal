<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->default('Advice');
            $table->string('excerpt', 300)->nullable();
            $table->longText('content'); // store HTML or markdown/plain
            $table->string('cover_image')->nullable(); // e.g. images/blog/cover.jpg
            $table->boolean('published')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['published', 'published_at']);
            $table->index(['category']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};

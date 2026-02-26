<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->string('section')->default('nutrition')->after('slug');
            $table->boolean('is_featured')->default(false)->after('cover_image');
            $table->unsignedInteger('views')->default(0)->after('is_featured');

            $table->index('section');
            $table->index('is_featured');
            $table->index('views');
        });
    }

    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropIndex(['section']);
            $table->dropIndex(['is_featured']);
            $table->dropIndex(['views']);

            $table->dropColumn(['section', 'is_featured', 'views']);
        });
    }
};

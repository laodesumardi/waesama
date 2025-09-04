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
        Schema::table('news', function (Blueprint $table) {
            // Check if columns exist before adding them
            if (!Schema::hasColumn('news', 'status')) {
                $table->enum('status', ['draft', 'published'])->default('draft')->after('author');
            }
            if (!Schema::hasColumn('news', 'published_at')) {
                $table->timestamp('published_at')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            if (Schema::hasColumn('news', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('news', 'published_at')) {
                $table->dropColumn('published_at');
            }
        });
    }
};

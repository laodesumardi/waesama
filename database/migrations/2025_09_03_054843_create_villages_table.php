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
        Schema::create('villages', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('name');
            $table->string('head_name')->nullable();
            $table->string('head_phone', 20)->nullable();
            $table->decimal('area_size', 10, 2)->nullable()->comment('Area in KM2');
            $table->integer('population_count')->default(0);
            $table->text('description')->nullable();
            $table->json('boundaries')->nullable()->comment('Geographic boundaries');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['code', 'is_active']);
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('villages');
    }
};

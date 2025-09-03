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
        Schema::create('citizens', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->unique();
            $table->string('kk_number', 16)->nullable();
            $table->string('name');
            $table->date('birth_date');
            $table->string('birth_place');
            $table->enum('gender', ['L', 'P']);
            $table->string('religion', 50);
            $table->string('marital_status', 50);
            $table->string('occupation')->nullable();
            $table->string('education', 100)->nullable();
            $table->text('address');
            $table->foreignId('village_id')->nullable()->constrained()->nullOnDelete();
            $table->string('rt', 3)->nullable();
            $table->string('rw', 3)->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('photo_path')->nullable();
            $table->json('family_members')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['nik', 'is_active']);
            $table->index(['village_id', 'rt', 'rw']);
            $table->index('name');
            $table->index('kk_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citizens');
    }
};

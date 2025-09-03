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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('document_number', 100)->unique();
            $table->foreignId('service_request_id')->constrained()->cascadeOnDelete();
            $table->string('template_name');
            $table->string('document_title');
            $table->string('file_path', 500);
            $table->string('file_name');
            $table->integer('file_size')->unsigned();
            $table->string('mime_type', 100);
            $table->text('digital_signature')->nullable();
            $table->json('template_variables')->nullable();
            $table->foreignId('generated_by')->constrained('users')->cascadeOnDelete();
            $table->timestamp('generated_at')->useCurrent();
            $table->integer('download_count')->default(0);
            $table->timestamp('last_downloaded_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->date('valid_until')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['document_number', 'is_active']);
            $table->index('service_request_id');
            $table->index(['template_name', 'generated_at']);
            $table->index('generated_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};

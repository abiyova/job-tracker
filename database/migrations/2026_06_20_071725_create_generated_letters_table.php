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
        Schema::create('generated_letters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('job_applications')->onDelete('cascade');
            $table->foreignId('template_id')->nullable()->constrained('letter_templates')->nullOnDelete();
            $table->string('file_name');
            $table->enum('file_type', ['pdf', 'docx']);
            $table->string('file_path');
            $table->timestamp('generated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generated_letters');
    }
};

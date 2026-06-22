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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('company_name');
            $table->string('position');
            $table->date('publish_date')->nullable();
            $table->string('source')->nullable(); // LinkedIn, Jobstreet, dll
            $table->string('job_url')->nullable();
            $table->date('apply_date')->nullable();
            $table->enum('status', [
                'belum_dilamar','sudah_dilamar','diproses',
                'interview','tes','offering','ditolak','diterima'
            ])->default('belum_dilamar');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify ENUM column using raw SQL because Doctrine DBAL struggles with ENUMs in some Laravel versions
        DB::statement("ALTER TABLE job_applications MODIFY COLUMN status ENUM('belum_dilamar','sudah_dilamar','diproses','interview','tes','offering','ditolak','diterima','perlu_follow_up','tidak_direspon') DEFAULT 'belum_dilamar'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE job_applications MODIFY COLUMN status ENUM('belum_dilamar','sudah_dilamar','diproses','interview','tes','offering','ditolak','diterima') DEFAULT 'belum_dilamar'");
    }
};

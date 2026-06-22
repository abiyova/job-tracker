<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\{Job, StatusHistory};
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CheckJobFollowUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobs:check-followup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengecek lamaran yang sudah 2/3 minggu belum ada respons';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai pengecekan status lamaran...');
        
        $now = Carbon::now();
        $twoWeeksAgo = $now->copy()->subWeeks(2);
        $threeWeeksAgo = $now->copy()->subWeeks(3);

        $updatedCount = 0;

        // 1. Cek yang sudah lebih dari 3 minggu -> ubah ke 'tidak_direspon'
        // Berlaku untuk yang statusnya 'sudah_dilamar' ATAU 'perlu_follow_up'
        $jobsToNoResponse = Job::whereIn('status', ['sudah_dilamar', 'perlu_follow_up'])
            ->whereNotNull('apply_date')
            ->where('apply_date', '<=', $threeWeeksAgo)
            ->get();

        foreach ($jobsToNoResponse as $job) {
            $oldStatus = $job->status;
            $job->update(['status' => 'tidak_direspon']);
            
            StatusHistory::create([
                'job_id'     => $job->id,
                'old_status' => $oldStatus,
                'new_status' => 'tidak_direspon',
                'note'       => 'Otomatis diubah oleh sistem (> 3 minggu tidak ada respons)',
            ]);
            $updatedCount++;
        }

        // 2. Cek yang sudah lebih dari 2 minggu tapi kurang dari 3 minggu -> ubah ke 'perlu_follow_up'
        // Hanya berlaku untuk yang statusnya masih 'sudah_dilamar'
        $jobsToFollowUp = Job::where('status', 'sudah_dilamar')
            ->whereNotNull('apply_date')
            ->where('apply_date', '<=', $twoWeeksAgo)
            ->where('apply_date', '>', $threeWeeksAgo)
            ->get();

        foreach ($jobsToFollowUp as $job) {
            $oldStatus = $job->status;
            $job->update(['status' => 'perlu_follow_up']);
            
            StatusHistory::create([
                'job_id'     => $job->id,
                'old_status' => $oldStatus,
                'new_status' => 'perlu_follow_up',
                'note'       => 'Otomatis diubah oleh sistem (> 2 minggu, sarankan follow up)',
            ]);
            $updatedCount++;
        }

        $this->info("Selesai. Sebanyak {$updatedCount} data lamaran diperbarui otomatis.");
    }
}

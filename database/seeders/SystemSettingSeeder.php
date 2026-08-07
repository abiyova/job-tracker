<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $settings = [
            ['key' => 'app_name',     'value' => 'Job Application Tracker'],
            ['key' => 'app_logo',     'value' => null],
            ['key' => 'mail_from',    'value' => 'noreply@jobtracker.com'],
        ];

        foreach ($settings as $s) {
            \App\Models\SystemSetting::updateOrCreate(['key' => $s['key']], $s);
        }
    }
}

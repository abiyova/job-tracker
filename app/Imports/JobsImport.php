<?php

namespace App\Imports;

use App\Models\{Job, StatusHistory};
use Maatwebsite\Excel\Concerns\{ToModel, WithHeadingRow, SkipsEmptyRows};
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Carbon\Carbon;

class JobsImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    public function model(array $row)
    {
        $job = Job::create([
            'user_id'      => auth()->id(),
            'company_name' => $row['company_name'],
            'position'     => $row['position'],
            'location'     => $row['location'] ?? $row['lokasi'] ?? null,
            'publish_date' => $this->parseDate($row['publish_date'] ?? null),
            'source'       => $row['source'] ?? null,
            'job_url'      => $row['job_url'] ?? null,
            'apply_date'   => $this->parseDate($row['apply_date'] ?? null),
            'status'       => $row['status'] ?? 'belum_dilamar',
            'notes'        => $row['notes'] ?? null,
        ]);

        StatusHistory::create([
            'job_id'     => $job->id,
            'old_status' => null,
            'new_status' => $job->status,
            'note'       => 'Import dari Excel',
        ]);

        return $job;
    }

    /**
     * Parse tanggal dari Excel.
     * Mendukung: serial number Excel (46052), format string (d/m/Y, m/d/Y, Y-m-d, d-m-Y)
     */
    private function parseDate($value): ?string
    {
        if (empty($value)) {
            return null;
        }

        // Jika berupa angka (serial number Excel), konversi langsung
        if (is_numeric($value)) {
            try {
                return Carbon::instance(ExcelDate::excelToDateTimeObject($value))->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        }

        // Jika berupa string, coba beberapa format umum
        $formats = ['d/m/Y', 'm/d/Y', 'Y-m-d', 'd-m-Y', 'd-M-Y', 'Y/m/d'];
        foreach ($formats as $format) {
            try {
                $date = Carbon::createFromFormat($format, trim($value));
                if ($date && $date->format($format) === trim($value)) {
                    return $date->format('Y-m-d');
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        // Fallback: biarkan Carbon parse otomatis
        try {
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}

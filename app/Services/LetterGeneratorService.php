<?php

namespace App\Services;

use App\Models\{Job, LetterTemplate, GeneratedLetter, ApplicantProfile};
use Barryvdh\DomPDF\Facade\Pdf;

class LetterGeneratorService
{
    public function autoCapitalize(?string $value): string
    {
        if (empty($value)) return '';
        $words = explode(' ', $value);
        foreach ($words as &$word) {
            $upperWord = strtoupper($word);
            $cleanWord = rtrim($upperWord, '.,;');
            
            // Handle common acronyms, company types, and degrees in Indonesian
            $abbreviations = [
                'PT', 'CV', 'RS', 'RSUD', 'RSIA', 'RSUP', 'TBK', 'UD', 'PD', 'PO', 
                'BPR', 'BUMN', 'BUMD', 'KOP', 'FA', 'NV', 'IT', 'S1', 'S2', 'S3', 
                'D1', 'D2', 'D3', 'D4', 'SMA', 'SMK', 'MA', 'MTS', 'SD', 'SMP', 
                'SI', 'TI', 'HRD', 'CEO', 'CTO', 'CFO', 'COO', 'CMO', 'UI', 'UX', 
                'QA', 'QC', 'PR', 'MT', 'OJT'
            ];

            if (in_array($cleanWord, $abbreviations)) {
                $word = strtoupper($word); // Will keep original punctuation but uppercase letters
            } else {
                $word = ucfirst(strtolower($word));
            }
        }
        return implode(' ', $words);
    }

    public function replacePlaceholders(string $content, Job $job, ApplicantProfile $profile): string
    {
        $map = [
            // New intuitive placeholders
            '[Tanggal Hari Ini]' => now()->translatedFormat('d F Y'),
            '[Nama Perusahaan]'  => $this->autoCapitalize($job->company_name),
            '[Posisi Pekerjaan]' => $this->autoCapitalize($job->position),
            '[Sumber Info]'      => $job->source ?? '-',
            '[Nama Lengkap]'     => $this->autoCapitalize($profile->full_name ?? ''),
            '[No Telepon]'       => $profile->phone ?? '',
            '[Email]'            => $profile->email ?? '',
            '[Alamat Lengkap]'   => $this->autoCapitalize($profile->address ?? ''),
            '[Pendidikan]'       => $this->autoCapitalize($profile->education ?? ''),
            '[Link Portofolio]'  => $profile->portfolio ?? '',
            '[Link LinkedIn]'    => $profile->linkedin ?? '',
            '[Link GitHub]'      => $profile->github ?? '',
            '[Ringkasan]'        => $profile->summary ?? '',

            // Backward compatibility for old placeholders
            '{{today}}'        => now()->translatedFormat('d F Y'),
            '{{company_name}}' => $this->autoCapitalize($job->company_name),
            '{{position}}'     => $this->autoCapitalize($job->position),
            '{{source}}'       => $job->source ?? '-',
            '{{full_name}}'    => $this->autoCapitalize($profile->full_name ?? ''),
            '{{phone}}'        => $profile->phone ?? '',
            '{{email}}'        => $profile->email ?? '',
            '{{address}}'      => $this->autoCapitalize($profile->address ?? ''),
            '{{education}}'    => $this->autoCapitalize($profile->education ?? ''),
            '{{portfolio}}'    => $profile->portfolio ?? '',
            '{{linkedin}}'     => $profile->linkedin ?? '',
            '{{github}}'       => $profile->github ?? '',
            '{{summary}}'      => $profile->summary ?? '',
        ];
        return str_replace(array_keys($map), array_values($map), $content);
    }

    public function generateDocx(Job $job, LetterTemplate $template, ApplicantProfile $profile, int $fontSize = 12, ?string $editedContent = null, float $lineSpacing = 1.5): string
    {
        $content  = $editedContent !== null ? $editedContent : $this->replacePlaceholders($template->content, $job, $profile);
        $fileName = 'Surat_Lamaran_' . str_replace(' ', '_', $job->company_name) . '.docx';
        $filePath = 'letters/' . auth()->id() . '/' . $fileName;

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $phpWord->setDefaultFontName('Times New Roman');
        $phpWord->setDefaultFontSize($fontSize);
        
        // Remove default paragraph spacing after
        $phpWord->setDefaultParagraphStyle(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0)]);

        $section = $phpWord->addSection([
            'marginTop' => 1440, 'marginBottom' => 1440,
            'marginLeft' => 1800, 'marginRight' => 1440,
        ]);

        foreach (explode("\n", $content) as $line) {
            $line = rtrim($line, "\r");
            // Justify long paragraph lines, left-align short/info lines
            $align = (mb_strlen($line) > 60) ? 'both' : 'left';
            $section->addText(htmlspecialchars($line), [], ['alignment' => $align, 'lineHeight' => $lineSpacing, 'spaceAfter' => 0]);
        }

        $tempFile = tempnam(sys_get_temp_dir(), 'docx');
        $writer = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($tempFile);

        \Storage::put($filePath, file_get_contents($tempFile));
        @unlink($tempFile);

        GeneratedLetter::create([
            'job_id'      => $job->id,
            'template_id' => $template->id,
            'file_name'   => $fileName,
            'file_type'   => 'docx',
            'file_path'   => $filePath,
        ]);

        return $filePath;
    }
}
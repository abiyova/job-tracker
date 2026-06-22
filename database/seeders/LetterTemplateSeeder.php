<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\LetterTemplate;

class LetterTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'name' => 'Formal Umum',
                'description' => 'Template surat lamaran formal standar bahasa Indonesia.',
                'content' => "{{today}}\n\nHal: Lamaran Pekerjaan\n\nKepada Yth.\nHRD {{company_name}}\nDi Tempat\n\nDengan hormat,\nSehubungan dengan informasi lowongan pekerjaan yang saya dapatkan dari {{source}}, saya bermaksud mengajukan diri untuk bergabung dengan {{company_name}} sebagai {{position}}.\n\nBerikut adalah data singkat saya:\nNama: {{full_name}}\nPendidikan: {{education}}\nNo. HP: {{phone}}\nEmail: {{email}}\n\nSaya memiliki komitmen tinggi untuk bekerja keras, belajar dengan cepat, dan berkontribusi secara maksimal untuk kemajuan {{company_name}}.\n\nSebagai bahan pertimbangan, saya lampirkan curriculum vitae serta berkas pendukung lainnya. Besar harapan saya untuk diberikan kesempatan melakukan wawancara agar dapat menjelaskan kualifikasi saya secara lebih mendalam.\n\nAtas perhatian Bapak/Ibu, saya ucapkan terima kasih.\n\nHormat saya,\n\n\n{{full_name}}",
            ],
            [
                'name' => 'Fresh Graduate',
                'description' => 'Template surat lamaran untuk lulusan baru (fresh graduate).',
                'content' => "{{today}}\n\nHal: Lamaran Pekerjaan - {{position}}\n\nKepada Yth.\nHRD {{company_name}}\nDi Tempat\n\nDengan hormat,\nSaya menulis surat ini untuk menyatakan ketertarikan saya pada posisi {{position}} di {{company_name}} seperti yang diiklankan di {{source}}. Sebagai lulusan baru dari {{education}}, saya sangat bersemangat untuk memulai karir profesional saya di perusahaan Bapak/Ibu.\n\nSelama masa studi, saya telah mempelajari teori dasar dan praktis yang relevan dengan posisi ini. Saya juga aktif dalam kegiatan organisasi yang melatih kemampuan komunikasi, kerja sama tim, dan pemecahan masalah saya.\n\nDetail profil saya:\nNama Lengkap: {{full_name}}\nEmail: {{email}}\nTelepon: {{phone}}\nAlamat: {{address}}\nLinkedIn: {{linkedin}}\nPortfolio: {{portfolio}}\n\nSaya yakin bahwa latar belakang akademis dan antusiasme saya untuk terus belajar akan menjadi nilai tambah bagi tim di {{company_name}}.\n\nDemikian surat lamaran ini saya sampaikan. Terima kasih atas waktu dan pertimbangan Bapak/Ibu.\n\nHormat saya,\n\n\n{{full_name}}",
            ],
            [
                'name' => 'IT Support',
                'description' => 'Template surat lamaran untuk posisi IT Support.',
                'content' => "{{today}}\n\nHal: Lamaran Pekerjaan - {{position}}\n\nKepada Yth.\nHRD {{company_name}}\nDi Tempat\n\nDengan hormat,\nBerdasarkan informasi dari {{source}}, saya mengetahui bahwa {{company_name}} sedang membuka lowongan untuk posisi {{position}}. Saya sangat tertarik untuk mengisi posisi tersebut karena memiliki keahlian dalam pemeliharaan sistem komputer dan jaringan.\n\nSaya memiliki pengalaman dalam melakukan troubleshoot hardware dan software, instalasi sistem operasi, penanganan masalah jaringan (LAN/Wi-Fi), serta memberikan bantuan teknis langsung kepada pengguna (helpdesk). Saya berkomitmen untuk memastikan semua infrastruktur IT di {{company_name}} berjalan dengan lancar dan efisien.\n\nBerikut adalah informasi kontak saya:\nNama: {{full_name}}\nTelepon: {{phone}}\nEmail: {{email}}\nPendidikan: {{education}}\n\nBersama surat ini, saya lampirkan dokumen pendukung untuk pertimbangan Bapak/Ibu. Atas perhatiannya, saya ucapkan terima kasih.\n\nHormat saya,\n\n\n{{full_name}}",
            ],
            [
                'name' => 'Programmer',
                'description' => 'Template surat lamaran untuk pengembang perangkat lunak (Programmer).',
                'content' => "{{today}}\n\nHal: Lamaran Pekerjaan - {{position}}\n\nKepada Yth.\nHRD {{company_name}}\nDi Tempat\n\nDengan hormat,\nDengan surat ini saya bermaksud mengajukan diri sebagai {{position}} di {{company_name}} sesuai dengan informasi lowongan yang saya lihat di {{source}}.\n\nSebagai seorang pengembang perangkat lunak, saya terbiasa menulis kode yang bersih, efisien, dan mudah dipelihara. Saya memiliki pengalaman dalam mengembangkan aplikasi web dan mobile serta mengelola basis data. Ringkasan keahlian dan kepribadian saya dapat dilihat pada profil singkat saya: {{summary}}.\n\nInformasi Kontak & Portofolio:\nNama: {{full_name}}\nEmail: {{email}}\nNomor HP: {{phone}}\nPendidikan: {{education}}\nGitHub: {{github}}\nPortfolio: {{portfolio}}\n\nSaya sangat berharap bisa berdiskusi lebih lanjut mengenai kontribusi yang dapat saya berikan untuk menyukseskan proyek-proyek teknologi di {{company_name}}.\n\nHormat saya,\n\n\n{{full_name}}",
            ],
            [
                'name' => 'Network Engineer',
                'description' => 'Template surat lamaran untuk spesialis jaringan.',
                'content' => "{{today}}\n\nHal: Lamaran Pekerjaan - {{position}}\n\nKepada Yth.\nHRD {{company_name}}\nDi Tempat\n\nDengan hormat,\nSehubungan dengan informasi lowongan kerja di {{source}} untuk posisi {{position}}, saya ingin mengajukan lamaran pekerjaan untuk posisi tersebut di {{company_name}}.\n\nSaya memiliki kompetensi dalam merancang, mengonfigurasi, dan memelihara infrastruktur jaringan komputer. Keahlian saya meliputi manajemen router, switch, firewall, subnetting, VPN, serta troubleshooting konektivitas jaringan. Saya juga memahami standar keamanan jaringan untuk melindungi integritas data perusahaan.\n\nData Diri Singkat:\nNama: {{full_name}}\nPendidikan: {{education}}\nEmail: {{email}}\nTelepon: {{phone}}\n\nSaya siap berkontribusi dalam menjaga keandalan dan stabilitas sistem jaringan di {{company_name}}. Terima kasih atas kesempatan dan waktu yang diberikan.\n\nHormat saya,\n\n\n{{full_name}}",
            ],
            [
                'name' => 'System Administrator',
                'description' => 'Template surat lamaran untuk System Administrator / Sysadmin.',
                'content' => "{{today}}\n\nHal: Lamaran Pekerjaan - {{position}}\n\nKepada Yth.\nHRD {{company_name}}\nDi Tempat\n\nDengan hormat,\nMelalui surat ini, saya bermaksud melamar pekerjaan untuk posisi {{position}} di {{company_name}} sebagaimana diinformasikan di {{source}}.\n\nSaya memiliki keahlian dalam mengelola, memantau, dan mengamankan server (Linux/Windows Server), virtualisasi, manajemen hak akses, serta sistem cadangan data (backup & recovery). Saya berfokus pada efisiensi performa server demi mendukung kelancaran operasional harian perusahaan.\n\nProfil Singkat:\nNama: {{full_name}}\nKontak: {{phone}} / {{email}}\nPendidikan: {{education}}\n\nSaya melampirkan berkas pendukung bersama surat lamaran ini. Saya berharap dapat segera bergabung bersama tim IT {{company_name}}.\n\nHormat saya,\n\n\n{{full_name}}",
            ],
            [
                'name' => 'Staff IT All Rounder',
                'description' => 'Template default untuk berbagai peran IT serba bisa.',
                'content' => "{{today}}\n\nHal: Lamaran Pekerjaan - {{position}}\n\nKepada Yth.\nHRD {{company_name}}\nDi Tempat\n\nDengan hormat,\nBerdasarkan informasi lowongan pekerjaan yang saya peroleh dari {{source}}, saya tertarik untuk melamar posisi {{position}} di {{company_name}}.\n\nSaya merupakan seorang profesional IT serba bisa (all-rounder) yang memiliki kemampuan dalam berbagai aspek teknologi informasi. Keahlian utama saya meliputi troubleshooting hardware & software komputer, memberikan dukungan teknis (helpdesk) kepada pengguna, mengonfigurasi jaringan dasar (LAN, Wi-Fi, Router), serta memelihara server dan database dasar. Selain itu, saya juga memiliki kemampuan administrasi IT untuk mendokumentasikan aset dan sistem perusahaan.\n\nDengan dedikasi tinggi dan kemampuan belajar yang cepat, saya siap membantu {{company_name}} dalam menjaga kelancaran seluruh infrastruktur teknologi informasi.\n\nBerikut adalah informasi detail mengenai profil saya:\nNama Lengkap: {{full_name}}\nAlamat: {{address}}\nNomor HP: {{phone}}\nEmail: {{email}}\nPendidikan: {{education}}\nLinkedIn: {{linkedin}}\nGitHub: {{github}}\nPortfolio: {{portfolio}}\n\nSebagai bahan pertimbangan, saya lampirkan CV beserta berkas pendukung lainnya. Terima kasih atas perhatian dan kesempatan yang diberikan.\n\nHormat saya,\n\n\n{{full_name}}",
            ]
        ];

        $users = User::all();
        foreach ($users as $user) {
            foreach ($templates as $tmpl) {
                // Only create if not exists
                LetterTemplate::firstOrCreate(
                    ['user_id' => $user->id, 'name' => $tmpl['name']],
                    ['description' => $tmpl['description'], 'content' => $tmpl['content']]
                );
            }
        }
    }
}

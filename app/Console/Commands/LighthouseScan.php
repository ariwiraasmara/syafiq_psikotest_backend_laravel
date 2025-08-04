<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class LighthouseScan extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lighthouse:scan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scan multiple pages with Lighthouse and generate reports';

    /**
     * Execute the console command.
     */
    public function handle() {
        //
        $baseUrl = 'http://localhost:8000';

        $urls = [
            $baseUrl.'/',
            // $baseUrl.'/peserta',
            // $baseUrl.'/admin',
            // $baseUrl.'/mengenai_kami',
            // $baseUrl.'/artikel',
            // $baseUrl.'/blog',
            // $baseUrl.'/blog?kategori=acara',
            // $baseUrl.'/blog?kategori=artikel',
            // $baseUrl.'/blog?kategori=informasi',
            // $baseUrl.'/blog?kategori=kegiatan',
            // $baseUrl.'/kontak',
            // $baseUrl.'/layanan',
            // $baseUrl.'/layanan/psikotes-sim',
            // $baseUrl.'/link-psikotes',
        ];

        // ✅ 2. Folder output
        $outputDir = base_path('lighthouse-reports');
        if (!is_dir($outputDir)) {
            mkdir($outputDir, 0777, true);
        }

        $this->info("🚀 Memulai scan Lighthouse untuk " . count($urls) . " halaman...");

        // ✅ 3. Variabel untuk hitung rata-rata
        $totalScores = [
            'performance' => 0,
            'accessibility' => 0,
            'best-practices' => 0,
            'seo' => 0
        ];
        $totalPages = 0;

        foreach ($urls as $url) {
            $this->line("🔍 Scan: {$url}");

            // ✅ 4. Ubah URL jadi nama file
            $filenameBase = preg_replace('/https?:\/\//', '', $url);
            $filenameBase = str_replace('/', '_', $filenameBase);

            $htmlReport = $outputDir . '/' . $filenameBase . '.html';
            $jsonReport = $outputDir . '/' . $filenameBase . '.json';

            // ✅ 5. Jalankan Lighthouse via CLI
            $process = new Process([
                'lighthouse',
                $url,
                '--output', 'html',
                '--output-path', $htmlReport,
                '--only-categories=performance,seo,best-practices,accessibility',
                '--quiet',
                '--verbose'
            ]);

            $process->setTimeout(600); // 10 menit
            $process->run();

            $this->line($process->getOutput()); // ✅ Tambah ini
            $this->error($process->getErrorOutput()); // ✅ Tambah ini

            if ($process->isSuccessful()) {
                $this->info("✅ Laporan HTML: {$htmlReport}");
                // Karena Lighthouse CLI kalau multi output (html+json) hanya save HTML di output-path,
                // JSON-nya akan otomatis disimpan di file yang sama tapi berekstensi .report.json
                $autoJsonReport = str_replace('.html', '.report.json', $htmlReport);
                if (file_exists($autoJsonReport)) {
                    rename($autoJsonReport, $jsonReport);
                }

                // ✅ 6. Ambil skor dari JSON
                if (file_exists($jsonReport)) {
                    $jsonData = json_decode(file_get_contents($jsonReport), true);
                    $categories = $jsonData['categories'] ?? [];

                    if (!empty($categories)) {
                        $totalScores['performance'] += $categories['performance']['score'] ?? 0;
                        $totalScores['accessibility'] += $categories['accessibility']['score'] ?? 0;
                        $totalScores['best-practices'] += $categories['best-practices']['score'] ?? 0;
                        $totalScores['seo'] += $categories['seo']['score'] ?? 0;
                        $totalPages++;
                    }
                }

            } else {
                $this->error("❌ Gagal scan: {$url}");
                $this->error($process->getErrorOutput());
            }
        }

        // ✅ 7. Tampilkan Summary Skor Rata-rata
        if ($totalPages > 0) {
            $this->info("\n📊 SUMMARY LIGHTHOUSE SCORE");
            $this->line("Halaman yang discan: {$totalPages}");

            $avgPerformance = round(($totalScores['performance'] / $totalPages) * 100);
            $avgAccessibility = round(($totalScores['accessibility'] / $totalPages) * 100);
            $avgBestPractices = round(($totalScores['best-practices'] / $totalPages) * 100);
            $avgSEO = round(($totalScores['seo'] / $totalPages) * 100);

            $this->line("⚡ Performance   : {$avgPerformance}");
            $this->line("♿ Accessibility : {$avgAccessibility}");
            $this->line("✅ Best Practices: {$avgBestPractices}");
            $this->line("🔍 SEO          : {$avgSEO}");
        }

        $this->info("\n🎉 Semua laporan selesai! Cek folder: {$outputDir}");
    }
}

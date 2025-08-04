<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Console\Commands;

use Illuminate\Console\Command;
use MatthiasMullie\Minify;

class MinifyAssets extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'minify:assets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Minify semua CSS & JS di public folder';

    /**
     * Execute the console command.
     */
    public function handle() {
        //
        $this->info('🚀 Proses minify dimulai...');

        // Path CSS & JS
        $cssFiles = [
            // public_path('css/app.css'),
            public_path('css/additional.css'),
            asset('dist/css/app.css'),
            tailwindcss('css/app.css')
        ];

        $jsFiles = [
            // public_path('js/app.js'),
            public_path('js/myfunction.js'),
        ];

        // ======================
        // ✅ Minify CSS
        // ======================
        $cssMinifier = new Minify\CSS();
        foreach ($cssFiles as $file) {
            if (file_exists($file)) {
                $cssMinifier->add($file);
                $this->info("✅ CSS ditambahkan: " . $file);
            } else {
                $this->warn("⚠ CSS file tidak ditemukan: " . $file);
            }
        }
        $cssMinifier->minify(public_path('css/app.min.css'));
        $this->info('🎉 CSS selesai di-minify ➜ public/css/app.min.css');

        // ======================
        // ✅ Minify JS
        // ======================
        $jsMinifier = new Minify\JS();
        foreach ($jsFiles as $file) {
            if (file_exists($file)) {
                $jsMinifier->add($file);
                $this->info("✅ JS ditambahkan: " . $file);
            } else {
                $this->warn("⚠ JS file tidak ditemukan: " . $file);
            }
        }
        $jsMinifier->minify(public_path('js/app.min.js'));
        $this->info('🎉 JS selesai di-minify ➜ public/js/app.min.js');

        $this->info('✅ Semua asset berhasil di-minify!');
    }
}

<?php
// 
// 
// 
namespace App\Http\Controllers\View\Peserta\Psikotest\Kecermatan\Hasil;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class Page extends Controller {
    //
    public function index($no_identitas, $tgl_tes) {
        Sitemap::create('https://psikotesasyik.com')
            ->add(Url::create('/')
                    ->setLastModificationDate(Carbon::yesterday())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.8)
            )
            ->add(Url::create('/peserta/psikotest/kecermatan/hasil/{no_identitas}/{tgl_tes}')
                        ->setLastModificationDate(Carbon::yesterday())
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                        ->setPriority(1)
            )
            ->writeToFile(base_path('sitemap.xml'));

        return Inertia::render('peserta/psikotest/kecermatan/hasil/page', [
            'title'           => 'Hasil Psikotest Kecermatan Peserta | Psikotest Online App',
            'pathURL'         => url()->current(),
            'robots'          => 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate',
            'onetime'         => false,
            'no_identitas'    => $no_identitas,
            'tgl_tes'         => $tgl_tes,
        ]);
    }
}

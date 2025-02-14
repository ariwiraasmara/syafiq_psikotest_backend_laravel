<?php
// 
// 
// 
namespace App\Http\Controllers\View;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class Home extends Controller {
    //
    public function __construct() {}


    public function index() {
        // Sitemap::create('https://psikotesasyik.com')
        //     ->add(Url::create('/')
        //             ->setLastModificationDate(Carbon::yesterday())
        //             ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
        //             ->setPriority(0.8)
        //     )
        //     ->add(Url::create('/admin')
        //             ->setLastModificationDate(Carbon::yesterday())
        //             ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
        //             ->setPriority(0.5)
        //     )
        //     ->add(Url::create('/peserta')
        //             ->setLastModificationDate(Carbon::yesterday())
        //             ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
        //             ->setPriority(1)
        //     )
        //     ->add(Url::create('/peserta/psikotest/kecermatan/hasil/{no_identitas}/{tgl_tes}')
        //             ->setLastModificationDate(Carbon::yesterday())
        //             ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
        //             ->setPriority(1)
        //     )
        //     ->writeToFile(base_path('sitemap.xml'));

        return Inertia::render('Home', [
            'title'     => 'Psikotest Online App',
            'pathURL'   => url()->current(),
            'robots'    => 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate',
            'onetime'   => true
        ]);
    }
}

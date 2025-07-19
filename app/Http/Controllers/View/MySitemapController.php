<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use App\Services\as1001_peserta_profilService;
use App\Libraries\branding;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;
use Exception;

class MySitemapController extends Controller {
    //
    protected as1001_peserta_profilService $profilpesertaService;
    protected branding $brand;
    protected $titlepage, $path, $domain, $unique, $robots;
    protected $id, $nama, $email, $roles, $pat, $rtk, $filename;
    protected $sitemap, $sitemap_hasil_psikotest_peserta, $sitemap_admin_peserta_detil, $sitemapindex;
    public function __construct(
        Request $request,
        as1001_peserta_profilService $profilpesertaService,
        branding $brand
    ) {
        $this->profilpesertaService = $profilpesertaService;
        $this->brand = $brand;

        $this->titlepage = 'Sitemap'.$this->brand->getTitlepage();
        $this->path = env('SESSION_PATH', '/');
        $this->domain = env('SESSION_DOMAIN', 'localhosthost:8000');
        $this->unique = fun::random('combwisp', 50);
        $this->robots = 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate';

        if($request->session()->has('id')) $this->id = $request->session()->get('id');
        else $this->id = null;

        if($request->session()->has('nama')) $this->nama = $request->session()->get('nama');
        else $this->nama = null;

        if($request->session()->has('email')) $this->email = $request->session()->get('email');
        else $this->email = null;

        if($request->session()->has('roles')) $this->roles = $request->session()->get('roles');
        else $this->roles = null;

        $this->sitemap = Sitemap::create('https://psikotesasyik.com');
        $this->sitemap_hasil_psikotest_peserta = Sitemap::create('https://psikotesasyik.com');
        $this->sitemap_admin_peserta_detil = Sitemap::create('https://psikotesasyik.com');
        $this->sitemapindex = SitemapIndex::create();
    }

    public function generate(Request $request) {
        $unique = fun::random('combwisp', 20);
        try {
            // Session tidak ada atau sudah kadaluarsa, generate sitemap
            $request->session()->put('is_generatate_sitemap', true);
            $request->session()->put('is_generatate_sitemap_expiry', now()->addHours(24));
            $profilpeserta = $this->profilpesertaService->allReport_forSitemap();

            $this->sitemap->add(Url::create('/')
                ->setLastModificationDate(Carbon::now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(1)
            );
            $this->sitemap->add(Url::create('/admin')
                ->setLastModificationDate(Carbon::now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(1)
            );
            $this->sitemap->add(Url::create('/peserta')
                ->setLastModificationDate(Carbon::now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(1)
            );
            $this->sitemap->add(Url::create('/admin/dashboard')
                ->setLastModificationDate(Carbon::now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(1)
            );
            $this->sitemap->add(Url::create('/admin/peserta')
                ->setLastModificationDate(Carbon::now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(1)
            );
            $this->sitemap->add(Url::create('/admin/psikotest')
                ->setLastModificationDate(Carbon::now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.5)
            );
            $this->sitemap->add(Url::create('/admin/psikotest/kecermatan')
                ->setLastModificationDate(Carbon::now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.6)
            );
            $this->sitemap->add(Url::create('/admin/psikotest/kecermatan-detil/{encrypt_id}')
                ->setLastModificationDate(Carbon::now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.7)
            );
            $this->sitemap->add(Url::create('/admin/variabel')
                ->setLastModificationDate(Carbon::now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(0.7)
            );
            
            $index_number = 1;
            for($x = 0; $x < $profilpeserta->count(); $x++) {
                //generate kedua
                $this->sitemap_hasil_psikotest_peserta->add(Url::create('/peserta/psikotest/kecermatan/hasil/'.$profilpeserta[$x]['no_identitas'].'/'.$profilpeserta[$x]['tgl_ujian'])
                        ->setLastModificationDate(Carbon::now())
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                        ->setPriority(1)
                );

                //generate ketiga
                // $this->sitemap_admin_peserta_detil->add(Url::create('/admin/peserta-detil/'.$profilpeserta[$x]['tgl_ujian'].'/'.$profilpeserta[$x]['tgl_ujian'].'/'.fun::enval($profilpeserta[$x]['id'], true))
                //         ->setLastModificationDate(Carbon::now())
                //         ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                //         ->setPriority(1)
                // );
                $index_number++;
            }

            $this->sitemap->writeToFile(public_path('sitemap.xml'));
            $this->sitemap_hasil_psikotest_peserta->writeToFile(public_path('sitemap_hasil_psikotest_kecermatan_peserta.xml'));
            // $this->sitemap_admin_peserta_detil->writeToFile(public_path('sitemap_admin_peserta_detil.xml'));
            $this->sitemapindex->add(url('sitemap.xml'), Carbon::now())
                                ->add(url('sitemap_hasil_psikotest_kecermatan_peserta.xml'), Carbon::now());
                                // ->add(url('sitemap_admin_peserta_detil.xml'), Carbon::now());
            $this->sitemapindex->writeToFile(public_path('sitemap_index.xml'));

            return view('sitemap', [
                'title'                => 'Generate Sitemap SEO Berhasil | Psikotest Online App',
                'pathURL'              => url()->current(),
                'breadcrumb'           => '/generate-sitemap',
                'is_breadcrumb_hidden' => 'hidden',
                'robots'               => 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate',
                'onetime'              => true,
                'unique'               => $unique,
                'pesan'                => 'generate sitemap seo berhasil!<br/>tunggu 10 detik untuk kembali ke halaman Admin!',
                'error'                => '',
            ]);
        }
        catch(Exception $error) {
            return view('sitemap', [
                'title'                => 'Generate Sitemap SEO Gagal | Psikotest Online App',
                'pathURL'              => url()->current(),
                'breadcrumb'           => '/generate-sitemap',
                'is_breadcrumb_hidden' => 'hidden',
                'robots'               => 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate',
                'onetime'              => true,
                'unique'               => fun::random('combwisp', 50),
                'pesan'                => 'generate sitemap seo gagal!',
                'error'                => $error->getMessage()
            ]);
        }
    }

    public function __destruct() {
        $this->titlepage = null;
        $this->path = null;
        $this->domain = null;
        $this->unique = null;
        $this->robots = null;
        $this->id = null;
        $this->nama = null;
        $this->email = null;
        $this->roles = null;
    }
}

<?php
// 
// 
// 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Exception;
class SitemapController extends Controller {
    //
    public function __construct() {

    }

    public function generate(Request $request) {
        try {
            $sitemap = Sitemap::create('https://psikotesasyik.com');
            $sitemap->add(Url::create('/')
                ->setLastModificationDate(Carbon::yesterday())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.8)
            );
            $sitemap->add(Url::create('/admin')
                ->setLastModificationDate(Carbon::yesterday())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.5)
            );
            $sitemap->add(Url::create('/peserta')
                ->setLastModificationDate(Carbon::yesterday())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(1)
            );
            $sitemap->add(Url::create('/peserta/psikotest/kecermatan/hasil/{no_identitas}/{tgl_tes}')
                ->setLastModificationDate(Carbon::yesterday())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(1)
            );

            $sitemap->add(Url::create('/admin/dashboard')
                ->setLastModificationDate(Carbon::now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(0.8)
            );

            $sitemap->add(Url::create('/admin/peserta')
                ->setLastModificationDate(Carbon::now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(0.8)
            );

            $sitemap->add(Url::create('/admin/psikotest')
                ->setLastModificationDate(Carbon::now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(0.8)
            );

            $sitemap->add(Url::create('/admin/psikotest/kecermatan')
                ->setLastModificationDate(Carbon::now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(0.8)
            );

            $sitemap->add(Url::create('/admin/variabel')
                ->setLastModificationDate(Carbon::now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(0.8)
            );

            
            if($request->hasHeader('sitemap')[0] == 'peserta') {
                $pages = 0;
                if($request->hasHeader('sitemap_pages')) $pages = (int)$request->hasHeader('sitemap_pages')[0];

                for($sv = 0; $sv < $pages; $sv++) {
                    $sitemap->add(Url::create('/admin/peserta/'.$sv)
                        ->setLastModificationDate(Carbon::now())
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                        ->setPriority(0.5)
                    );
                }

                

                if($request->hasHeader('sub_sitemap')[0] == 'peserta_detil') {
                    for($sv = 0; $sv < (int)$request->hasHeader('sitemap_pages')[0]; $sv++) {
                        $sitemap->add(Url::create('/admin/peserta/'.$sv)
                            ->setLastModificationDate(Carbon::now())
                            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                            ->setPriority(0.5)
                        );
                    }
                }
            }
            else if($request->hasHeader('sitemap')[0] == 'variabel') {
                for($sv = 0; $sv < (int)$request->hasHeader('sitemap_pages')[0]; $sv++) {
                    $sitemap->add(Url::create('/admin/variabel/'.$sv)
                        ->setLastModificationDate(Carbon::now())
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                        ->setPriority(0.5)
                    );
                }
            }
            $sitemap->writeToFile(base_path('sitemap.xml'));
            return 1;
        }
        catch(Exception $error) {
            return 0;
        }
    }
}

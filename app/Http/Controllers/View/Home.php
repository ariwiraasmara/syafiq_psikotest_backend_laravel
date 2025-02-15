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
        return Inertia::render('Home', [
            'title'     => 'Psikotest Online App',
            'pathURL'   => url()->current(),
            'robots'    => 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate',
            'onetime'   => true
        ]);
    }
}

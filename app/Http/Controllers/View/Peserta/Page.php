<?php
// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers\View\Peserta;
use Inertia\Inertia;
use Inertia\Response as Inar;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Libraries\myfunction as fun;

class Page extends Controller {
    //
    public function __construct() {}

    public function view(Request $request): Inar|JsonResponse|Collection|array|String|int|null {
        return Inertia::render('peserta/page', [
            'title'   => 'Formulir Peserta | Psikotest Online App',
            'pathURL' => url()->current(),
            'robots'  => 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate',
            'onetime' => true,
        ]);
    }

    public function bladeView(Request $request): View|Response|JsonResponse|Collection|array|String|int|null {
        $path = env('SESSION_PATH', '/');
        $domain = env('SESSION_DOMAIN', 'localhosthost:8000');
        return view('pages.peserta.page', [
            'title'                => 'Formulir Peserta | Psikotest Online App',
            'pathURL'              => url()->current(),
            'breadcrumb'           => '/peserta',
            'is_breadcrumb_hidden' => 'hidden',
            'robots'               => 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate',
            'onetime'              => true,
            'unique'               => fun::random('combwisp', 50),
            'path'                 => $path,
            'domain'               => $domain
        ]);
    }
}

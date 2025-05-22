<?php
// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers\View;
use Inertia\Inertia;
use Inertia\Response as Inar;
use App\Http\Controllers\Controller;
use App\Libraries\myfunction as fun;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use App\Libraries\jsr;
use Exception;
use Meta;

class Home extends Controller {
    //
    protected $path, $domain;
    public function __construct() {
        $this->path = env('SESSION_PATH', '/');
        $this->domain = env('SESSION_DOMAIN', 'localhosthost:8000');
    }

    public function reactView(Request $request): Inar|Response|JsonResponse|Collection|array|String|int|null {
        $unique = fun::random('combwisp', 50);

        meta()->title('Psikotest Online App')
            ->set('og:title', 'Psikotest Online App')
            ->set('canonical', url()->current())
            ->set('og:url', url()->current())
            ->set('robots', 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate')
            ->set('XSRF-TOKEN', csrf_token())
            ->set('__unique__', $unique);

        return Inertia::render('Home', [
            'title'      => 'Psikotest Online App',
            'pathURL'    => url()->current(),
            'robots'     => 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate',
            'onetime'    => 1,
            'csrf_token' => csrf_token(),
            'unique'     => fun::random('combwisp', 50),
            'path'       => $this->path,
            'domain'     => $this->domain
        ]);
    }

    public function bladeView(Request $request): View|Response|JsonResponse|Collection|array|String|int|null {
        return view('home', [
            'title'                => 'Psikotest Online App',
            'pathURL'              => url()->current(),
            'breadcrumb'           => '/',
            'is_breadcrumb_hidden' => 'hidden',
            'robots'               => 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate',
            'onetime'              => true,
            'unique'               => fun::random('combwisp', 50),
            'ispeserta'            => 'null'
        ]);
    }
}

<?php
// 
namespace App\Http\Controllers\View;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Libraries\myfunction as fun;
use Meta;

class SecurityController extends Controller {
    //
    protected $titlepage, $path, $domain;
    public function __construct() {
        $this->path = env('SESSION_PATH', '/');
        $this->domain = env('SESSION_DOMAIN', 'localhosthost:8000');
    }

    public function reactView_halloffame() {
        $this->titlepage = 'Hall Of Fame - Security | Psikotest Online App';
        $unique = fun::random('combwisp', 50);

        meta()->title($this->titlepage)
            ->set('og:title', $this->titlepage)
            ->set('canonical', url()->current())
            ->set('og:url', url()->current())
            ->set('robots', 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate')
            ->set('XSRF-TOKEN', csrf_token())
            ->set('__unique__', $unique);

        return Inertia::render('security/hall_of_fame/page', [
            'title'    => $this->titlepage,
            'token'    => csrf_token(),
            'unique'   => $unique,
        ]);
    }

    public function bladeView_halloffame() {
        $this->titlepage = 'Hall Of Fame - Security | Psikotest Online App';
        return view('pages.security.hall_of_fame', [
            'title'                => $this->titlepage,
            'appbar_title'         => 'Hall Of Fame - Security',
            'pathURL'              => url()->current(),
            'robots'               => 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate',
            'onetime'              => false,
            'breadcrumb'           => '/security/hall-of-fame',
            'is_breadcrumb_hidden' => 'hidden',
            'unique'               => fun::random('combwisp', 50),
        ]);
    }
}

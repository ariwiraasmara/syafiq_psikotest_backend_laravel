<?php
// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers\View;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libraries\myfunction as fun;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class Logout extends Controller {
    //
    protected $path, $domain;
    public function __construct() {
        $this->path = env('SESSION_PATH', '/');
        $this->domain = env('SESSION_DOMAIN', 'localhosthost:8000');
    }

    public function view(Request $request) {
        // $domain = '9002-idx-umkmku-1726831788791.cluster-a3grjzek65cxex762e4mwrzl46.cloudworkstations.dev';
        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return Inertia::render('logout/page');
    }

    public function bladeView(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')
                ->cookie('email', null, -1, $this->path, $this->domain, true, true, false, 'Strict')
                ->cookie('islogin', null, -1, $this->path, $this->domain, true, true, false, 'Strict')
                ->cookie('isadmin', null, -1, $this->path, $this->domain, true, true, false, 'Strict')
                ->cookie('isauth', null, -1, $this->path, $this->domain, true, true, false, 'Strict')
                ->cookie('__sysauth__', null, -1, $this->path, $this->domain, true, true, false, 'Strict')
                ->cookie('__token__', null, -1, $this->path, $this->domain, true, true, false, 'Strict')
                ->cookie('__unique__', null, -1, $this->path, $this->domain, true, true, false, 'Strict');

        return view('pages.admin.logout', [
            'title'                => 'Logout | Admin | Psikotest Online App',
            'appbar_title'         => 'Logout',
            'pathURL'              => url()->current(),
            'breadcrumb'           => '/logout',
            'navval'               => '-',
            'is_breadcrumb_hidden' => 'hidden',
            'robots'               => 'none, nosnippet, noarchive, notranslate, noimageindex',
            'onetime'              => true,
            'unique'               => fun::random('combwisp', 50),
        ]);
    }
}

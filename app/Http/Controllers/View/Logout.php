<?php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
namespace App\Http\Controllers\View;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\useractivitiesService;
use App\Libraries\branding;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use Carbon\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class Logout extends Controller {
    //
    protected useractivitiesService|null $activity;
    protected branding $brand;
    protected $titlepage, $path, $domain, $unique, $robots;
    protected $id, $nama, $email, $roles, $pat, $rtk, $filename;
    public function __construct(
        Request $request,
        useractivitiesService $activity,
        branding $brand
    ) {
        $this->brand = $brand;
        $this->activity = $activity;

        $this->titlepage = 'Logout'.$this->brand->getTitlepage();
        $this->path = env('SESSION_PATH', '/');
        $this->domain = env('SESSION_DOMAIN', 'localhosthost:8000');
        $this->unique = fun::random('combwisp', 50);
        $this->robots = 'none, nosnippet, noarchive, notranslate, noimageindex';

        // ?
        $this->id = $request->session()->get('id');
        $this->nama = $request->session()->get('nama');
        $this->email = $request->session()->get('email');
        $this->roles = $request->session()->get('roles');
        $this->pat = $request->session()->get('pat');
        $this->rtk = $request->session()->get('rtk');
        $this->filename = $request->session()->get('fileUDH');

        $this->activity->store([
            'id_user'    => $this->id,
            'ip_address' => $request->ip(),
            'path'       => $request->path(),
            'url'        => $request->fullUrl(),
            'page'       => $this->titlepage,
            'event'      => 'Web - '.$request->method(),
            'deskripsi'  => 'logout : keluar dari sistem admin user : '.$this->nama,
            'properties' => json_encode($request->all())
        ]);
    }

    public function reactView(Request $request) {
        // $domain = '9002-idx-umkmku-1726831788791.cluster-a3grjzek65cxex762e4mwrzl46.cloudworkstations.dev';
        Auth::logout();
        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return Inertia::render('logout/page');
    }

    public function bladeView(Request $request) {
        Auth::logout();
        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home')
                ->cookie('_pas-m5', null, -1, $this->path, $this->domain, true, true, false, 'Strict')
                ->cookie('_pas-m2', null, -1, $this->path, $this->domain, true, true, false, 'Strict')
                ->cookie('_pas-t3', null, -1, $this->path, $this->domain, true, true, false, 'Strict')
                ->cookie('_pas-x4', null, -1, $this->path, $this->domain, true, true, false, 'Strict')
                ->cookie('_pas-sys', null, -1, $this->path, $this->domain, true, true, false, 'Strict')
                ->cookie('_pas-kn', null, -1, $this->path, $this->domain, true, true, false, 'Strict')
                ->cookie('_pas-nq', null, -1, $this->path, $this->domain, true, true, false, 'Strict');

        return view('pages.admin.logout', [
            'title'                => $this->titlepage,
            'appbar_title'         => 'Logout',
            'pathURL'              => url()->current(),
            'breadcrumb'           => '/logout',
            'navval'               => '-',
            'is_breadcrumb_hidden' => 'hidden',
            'robots'               => $this->robots,
            'onetime'              => true,
            'unique'               => $this->unique,
        ]);
    }

    public function __destruct() {
        $this->activity  = null;
        $this->titlepage = null;
        $this->path      = null;
        $this->domain    = null;
        $this->unique    = null;
        $this->robots    = null;
        $this->id        = null;
        $this->nama      = null;
        $this->email     = null;
        $this->roles     = null;
    }
}

<?php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
namespace App\Http\Controllers\View\Admin\Monitor\GuestLogActivities;
use Inertia\Inertia;
use Inertia\Response as Inar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use App\Services\useractivitiesService;
use App\Libraries\branding;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use Exception;
use Meta;

class Page extends Controller {
    //
    protected useractivitiesService|null $activity;
    protected branding $brand;
    protected $titlepage, $path, $domain, $unique, $data;
    protected $id, $nama, $email, $roles, $pat, $rtk, $filename;
    protected $robots;

    public function __construct(
        Request $request,
        branding $brand,
        useractivitiesService $activity,
    ) {
        // ?
        $this->brand = $brand;
        $this->activity = $activity;
        
        // ?
        $this->titlepage = 'Monitor Guest Activities'.$this->brand->getTitlepage();
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
            'deskripsi'  => 'read : melihat semua data monitor user activities.',
            'properties' => json_encode($request->all())
        ]);
    }

    public function reactView(Request $request) {
        meta()->title($this->titlepage)
            ->set('og:title', $this->titlepage)
            ->set('canonical', url()->current())
            ->set('og:url', url()->current())
            ->set('robots', $this->robots)
            ->set('XSRF-TOKEN', csrf_token())
            ->set('__unique__', $this->unique);

        Cookie::queue('__unique__', $this->unique, 1 * 24 * 60 * 60, $this->path, $this->domain, true, true, false, 'None');
        Cookie::queue('XSRF-TOKEN', csrf_token(), 1 * 24 * 60 * 60, $this->path, $this->domain, true, true, false, 'None');

        return Inertia::render('admin/monitor/guestlogactivities/page', [
            'title'   => $this->titlepage,
            'token'   => csrf_token(),
            'unique'  => $this->unique,
            'id'      => $this->id,
            'nama'    => $this->nama,
            'email'   => $this->email,
            'roles'   => $this->roles,
            'pat'     => $this->pat,
            'rtk'     => $this->rtk,
            'path'    => $this->path,
            'domain'  => $this->domain,
        ]);
    }

    public function bladeView(Request $request) {
        $directoryPath = storage_path('app/private/logs/guest');
        $files = File::files($directoryPath);

        // Ambil nama file
        $fileNames = array_map(fn($file) => $file->getFilename(), $files);
        sort($fileNames);

        // Contoh: ambil file tertentu
        $filejson = $request->query('file') ?? '';
        $jsonContent = [];
        $filePath = storage_path('app/private/logs/guest/'.$filejson);
        $file_date = null;
        if($request->query('file') && File::exists($filePath)) {
            $fileNames = null;
            $jsonContent = null;
            $file_date = null;
            $fileContent = file_get_contents($filePath);
            $jsonContent = json_decode($fileContent);

            $file_trim = trim($filejson, '.json');
            $file_date_year = substr($file_trim, 0 ,4);
            $file_date_month = substr($file_trim, 4, 2);
            $file_date_day = substr($file_trim, 6, 2);
            $file_date = $file_date_year.'-'.$file_date_month.'-'.$file_date_day;

            if (json_last_error() !== JSON_ERROR_NONE) {
                dd('JSON decode error: ' . json_last_error_msg());
            }
        }

        return view('pages.admin.monitor.guestlogactivities.page', [
            'title'                => $this->titlepage,
            'appbar_title'         => 'Monitor Guest Activities',
            'pathURL'              => url()->current(),
            'breadcrumb'           => '/admin/monitor/guestlogactivities',
            'navval'               => 'nav-monitor-guestlogactivities',
            'is_breadcrumb_hidden' => 'hidden',
            'robots'               => $this->robots,
            'onetime'              => false,
            'unique'               => $this->unique,
            'id'                   => $this->id,
            'nama'                 => $this->nama,
            'email'                => $this->email,
            'roles'                => $this->roles,
            'filenames'            => $fileNames,
            'filejson'             => $filejson,
            'data'                 => $jsonContent,
            'file_date'            => $file_date,
        ]);
    }

    public function __destruct() {
        $this->activity  = null;
        $this->data      = null;
        $this->titlepage = null;
        $this->path      = null;
        $this->domain    = null;
        $this->unique    = null;
        $this->robots    = null;
        $this->data      = null;
        $this->id        = null;
        $this->nama      = null;
        $this->email     = null;
        $this->roles     = null;
        $this->filename  = null;
    }
}

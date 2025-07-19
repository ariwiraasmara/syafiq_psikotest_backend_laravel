<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers\View\Admin\Variabel\Baru;
use Inertia\Inertia;
use Inertia\Response as Inar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use App\Services\useractivitiesService;
use App\Services\as0001_variabelsettingService;
use App\Libraries\branding;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use Exception;
use Meta;

class Page extends Controller {
    //
    protected as0001_variabelsettingService|null $service;
    protected useractivitiesService|null $activity;
    protected branding $brand;
    protected $titlepage, $path, $domain, $unique, $data;
    protected $id, $nama, $email, $roles, $pat, $rtk, $filename;
    protected $robots;
    public function __construct(
        Request $request,
        branding $brand,
        as0001_variabelsettingService $service,
        useractivitiesService $activity
    ) {
        // ?
        $this->service = $service;
        $this->brand = $brand;
        $this->activity = $activity;

        // ?
        $this->titlepage = 'Variabel Baru | Admin'.$this->brand->getTitlepage();
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
            'deskripsi'  => 'read : sepertinya mau menambah data variabel setting baru?',
            'properties' => json_encode($request->all())
        ]);
    }

    public function reactView(Request $request): Inar|JsonResponse|Collection|array|String|int|null {
        meta()->title($this->titlepage)
            ->set('og:title', $this->titlepage)
            ->set('canonical', url()->current())
            ->set('og:url', url()->current())
            ->set('robots', $this->robots)
            ->set('XSRF-TOKEN', csrf_token())
            ->set('__unique__', $this->unique);

        Cookie::queue('__unique__', $this->unique, 1 * 24 * 60 * 60, $this->path, $this->domain, true, true, false, 'None');
        Cookie::queue('XSRF-TOKEN', csrf_token(), 1 * 24 * 60 * 60, $this->path, $this->domain, true, true, false, 'None');

        return Inertia::render('admin/variabel/baru/page', [
            'title'  => $this->titlepage,
            'token'  => csrf_token(),
            'unique' => $this->unique,
            'id'     => $this->id,
            'nama'   => $this->nama,
            'email'  => $this->email,
            'roles'  => $this->roles,
            'pat'    => $this->pat,
            'rtk'    => $this->rtk,
            'path'   => $this->path,
            'domain' => $this->domain,
        ]);
    }

    public function bladeView(Request $request): View|Response|JsonResponse|Collection|array|String|int|null {
        return view('pages.admin.variabel.baru.page', [
            'title'                => $this->titlepage,
            'appbar_title'         => 'Variabel Baru',
            'pathURL'              => url()->current(),
            'breadcrumb'           => '/admin/variabel-baru',
            'navval'               => 'nav-admin-variabel',
            'is_breadcrumb_hidden' => 'hidden',
            'robots'               => $this->robots,
            'onetime'              => false,
            'unique'               => $this->unique,
            'id'                   => $this->id,
            'nama'                 => $this->nama,
            'email'                => $this->email,
            'roles'                => $this->roles,
        ]);
    }

    public function store(Request $request) {
        try {
            $credentials = $request->validate([
                'unique'   => 'required',
                'variabel' => 'required|string|max:255',
                'values'   => 'required',
            ]);
            if($credentials) {
                $data = $this->service->store([
                    'variabel' => fun::readable($request->variabel),
                    'values'   => fun::readable($request->values),
                ]);
                if($data > 0) {
                    $this->activity->store([
                        'id_user'    => $this->id,
                        'ip_address' => $request->ip(),
                        'path'       => $request->path(),
                        'url'        => $request->fullUrl(),
                        'page'       => $this->titlepage,
                        'event'      => $request->method(),
                        'deskripsi'  => 'create and store : data variabel setting baru.',
                        'properties' => json_encode($request->all())
                    ]);
                    return redirect()->route('admin_variabel_setting', ['sort'=>'variabel', 'by'=>'asc', 'search'=>'-', 'page'=>1]);
                }
                else {
                    return redirect()->route('admin_variabel_baru')->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
                }
            }
            else {
                return redirect()->route('admin_variabel_baru')->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada Admin/Variabel/Page => store!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return redirect()->route('admin_variabel_baru')->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
        }
    }
    
    public function nativeStore(Request $request) {
        try {
            // Use environment variables for database credentials
            // $DB_SERVER = env('DB_SERVER', '103.247.8.134');
            $DB_SERVER   = '103.247.8.134';
            $DB_USERNAME = 'psiy1926_superadmin';
            $DB_PASSWORD = 'Pu5@7-psikotes';
            $DB_NAME     = 'psiy1926_syafiq_psikotest';
    
            // Establish a database connection
            $link = mysqli_connect($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
    
            // Check connection
            if (!$link) {
                throw new Exception('Connection failed: ' . mysqli_connect_error());
            }
    
            // Prepare an insert statement
            $sql = "INSERT INTO as0001_variabelsetting ('variabel', 'values', 'created_at') VALUES (?, ?, ?)";
            return mysqli_prepare($link, $sql);
            if ($stmt = mysqli_prepare($link, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "sss", $param_variabel, $param_values, $param_created_at);
    
                // Set parameters
                $param_variabel = $request->variabel;
                $param_values = $request->values;
                $param_created_at = date('Y-m-d H:i:s');
    
                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    // Records created successfully. Redirect to landing page
                    return redirect()->route('admin_variabel_setting');
                } else {
                    throw new Exception('Execute failed: ' . mysqli_stmt_error($stmt));
                }
            } else {
                throw new Exception('Prepare failed: ' . mysqli_error($link));
            }
        } catch (Exception $e) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As0001VariabelsettingController->nativeStore!', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->route('admin_variabel_baru')->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
        } finally {
            // Close the statement and connection
            if (isset($stmt)) {
                mysqli_stmt_close($stmt);
            }
            if (isset($link)) {
                mysqli_close($link);
            }
        }
    }

    public function __destruct() {
        $this->activity = null;
        $this->service   = null;
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
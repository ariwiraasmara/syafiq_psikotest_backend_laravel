<?php
// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers\View\Admin\Variabel\Baru;
use Inertia\Inertia;
use Inertia\Response as Inar;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use App\Services\as0001_variabelsettingService;
use Illuminate\Support\Facades\Log;
use App\Libraries\myfunction as fun;
use Exception;

class Page extends Controller {
    //
    protected as0001_variabelsettingService $service;
    public function __construct(as0001_variabelsettingService $service) {
        $this->service = $service;
    }

    public function view(Request $request): Inar|JsonResponse|Collection|array|String|int|null {
        return Inertia::render('admin/variabel/baru/page', [
            'title'   => 'Variabel Baru | Admin | Psikotest Online App',
            'pathURL' => url()->current(),
            'robots'  => 'none, nosnippet, noarchive, notranslate, noimageindex',
            'onetime'              => false,
            'unique'               => fun::random('combwisp', 50),
            'nama'                 => $request->session()->get('nama'),
        ]);
    }

    public function bladeView(Request $request): View|Response|JsonResponse|Collection|array|String|int|null {
        return view('pages.admin.variabel.baru.page', [
            'title'                => 'Variabel Baru | Admin | Psikotest Online App',
            'appbar_title'         => 'Variabel Baru',
            'pathURL'              => url()->current(),
            'breadcrumb'           => '/admin/variabel-baru',
            'navval'               => 'nav-admin-variabel',
            'is_breadcrumb_hidden' => 'hidden',
            'robots'               => 'none, nosnippet, noarchive, notranslate, noimageindex',
            'onetime'              => false,
            'unique'               => fun::random('combwisp', 50),
            'nama'                 => $request->session()->get('nama'),
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
                    return redirect('/admin/variabel-setting/variabel/asc/-?page=1');
                }
                else {
                    return redirect('/admin/variabel-baru')->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
                }
            }
            else {
            return redirect('/admin/variabel-baru')->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As0001VariabelsettingController->store!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return redirect('/admin/variabel-baru')->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
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
}
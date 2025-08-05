<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\IsWebAdminAuth;
use App\Http\Middleware\SecurityHeaders;
use App\Libraries\myroute;
use App\Libraries\myfunction as fun;

Route::middleware(
    // 'throttle:250,1',
    SecurityHeaders::class
)->group(function () {
    Route::get('/', myroute::view('Home', 'bladeView'))->name('home');
    Route::get('/peserta/psikotest/kecermatan/hasil/{no_identitas}/{tgl_tes}', myroute::view('Peserta\Psikotest\Kecermatan\Hasil\Page', 'bladeView'))->name('peserta_psikotest_kecermatan_hasil');
    Route::get('/generate-sitemap', myroute::view('MySitemapController', 'generate'))->name('generate_sitemap');
    Route::get('/security/hall-of-fame', myroute::view('SecurityController', 'bladeView_halloffame'))->name('hall_of_fame');
});

Route::middleware(
    'throttle:250,1', // 200 permintaan per menit, mencegah serangan DDoS dalam pengiriman data yang berlebihan
    SecurityHeaders::class
)->group(function () {
    Route::get('/peserta', myroute::view('Peserta\Page', 'bladeView'))->name('peserta');
    
    Route::post('/peserta/setup', myroute::view('Peserta\Page', 'setUpPesertaTes'))
                ->name('peserta_setup');
    if( fun::getRawCookie('ispeserta') ) {
        Route::get('/peserta/psikotest/kecermatan/{sesi}', myroute::view('Peserta\Psikotest\Kecermatan\Page', 'bladeView'))->name('peserta_psikotest_kecermatan');
        Route::post('/peserta-psikotest-kecermatan/{id}', myroute::view('Peserta\Psikotest\Kecermatan\Page', 'store'))->name('peserta_psikotest_kecermatan_store');
        Route::get('/psikotest/kecermatan/pertanyaan/{id}', myroute::API('As2001KecermatanKolompertanyaanController', 'allForTes'))->name('psikotest_kecermatan_pertanyaan');
        Route::get('/psikotest/kecermatan/soaljawaban/{id}', myroute::API('As2002KecermatanSoaljawabanController', 'allForTes'))->name('psikotest_kecermatan_soaljawaban');
    }
});

Route::middleware(
    'throttle:50,1', // 50 permintaan per menit, mencegah serangan DDoS dalam pengiriman data yang berlebihan
    // 'customThrottle:50,1'
    SecurityHeaders::class
)->group(function () {
    Route::get('admin', myroute::view('Admin\Page', 'bladeView'))->name('admin');
    Route::post('admin/login/{type}', myroute::view('Admin\Page', 'login'))->name('admin_login');
    Route::get('logout', myroute::view('Logout', 'bladeView'))->name('admin_logout');
});

Route::middleware([
    'auth',
    'throttle:50,1', // 50 permintaan per menit, mencegah serangan DDoS dalam pengiriman data yang berlebihan
    IsWebAdminAuth::class,
    SecurityHeaders::class
])->group(function () {
    Route::get('/admin/dashboard', myroute::view('Admin\Dashboard\Page', 'bladeView'))->name('admin_dashboard');

    Route::get('/admin/anggota/{sort}/{by}/{search}', myroute::view('Admin\Admin\Page', 'bladeView'))->name('admin_anggota');
    Route::get('/admin-detil/{id}', myroute::view('Admin\Admin\Detil\Page', 'bladeView'))->name('admin_anggota_detil');
    Route::get('/profilku/{email}', myroute::view('Admin\Admin\MyProfil\Page', 'bladeView'))->name('admin_myprofil');
    Route::get('/admin-baru', myroute::view('Admin\Admin\Baru\Page', 'bladeView'))->name('admin_anggota_baru');
    Route::post('/admin-baru', myroute::view('Admin\Admin\Baru\Page', 'store'))->name('admin_anggota_simpan');
    Route::get('/admin-edit/{id}', myroute::view('Admin\Admin\Edit\Page', 'bladeView'))->name('admin_anggota_edit');
    Route::put('/admin-edit/{id}', myroute::view('Admin\Admin\Edit\Page', 'update'))->name('admin_anggota_update');
    Route::post('/admin/update-password/{id}', myroute::view('Admin\Admin\Myprofil\Page', 'updatePassword'))->name('admin_anggota_update_password');
    Route::get('/admin/update-remembertoken/{roles}/{type}', myroute::view('Admin\Admin\Myprofil\Page', 'updateRememberToken'))->name('admin_anggota_update_remembertoken');
    Route::get('/admin/update-pat/{roles}/{type}', myroute::view('Admin\Admin\Myprofil\Page', 'updatePAT'))->name('admin_anggota_update_pat');
    Route::delete('/admin-softdelete/{id}', myroute::view('Admin\Admin\Page', 'softDelete'))->name('admin_anggota_softdelete');
    Route::delete('/admin-harddelete/{id}', myroute::view('Admin\Admin\Page', 'hardDelete'))->name('admin_anggota_harddelete');
    Route::delete('/admin-delete/activities/{id}', myroute::view('Admin\Admin\Page', 'deleteActivities'))->name('admin_anggota_delete_activities');

    Route::get('/admin/blog/{sort}/{by}/{search}', myroute::view('Admin\Blog\Page', 'bladeView'))->name('admin_blog');
    Route::get('/admin/blog-detil/{id}', myroute::view('Admin\Blog\Detil\Page', 'bladeView'))->name('admin_blog_detail');
    Route::get('/admin/blog-baru', myroute::view('Admin\Blog\Baru\Page', 'bladeView'))->name('admin_blog_baru');
    Route::post('/admin/blog-baru', myroute::view('Admin\Blog\Baru\Page', 'store'))->name('admin_blog_store');
    Route::get('/admin/blog-edit/{id}', myroute::view('Admin\Blog\Edit\Page', 'bladeView'))->name('admin_blog_edit');
    Route::put('/admin/blog-edit/{id}', myroute::view('Admin\Blog\Edit\Page', 'update'))->name('admin_blog_update');
    Route::delete('/admin/blog-delete/{id}', myroute::view('Admin\Blog\Page', 'delete'))->name('admin_blog_delete');

    Route::get('/admin/peserta/{sort}/{by}/{search}', myroute::view('Admin\Peserta\Page', 'bladeView'))->name('admin_peserta');
    Route::get('/admin/peserta-edit/{id}', myroute::view('Admin\Peserta\Edit\Page', 'bladeView'))->name('admin_peserta_edit');
    Route::put('/admin/peserta-edit/{id}', myroute::view('Admin\Peserta\Edit\Page', 'update'))->name('admin_peserta_update');
    Route::get('/admin/peserta-detil/{tgl1}/{tgl2}/{id}', myroute::view('Admin\Peserta\Detil\Page', 'bladeView'))->name('admin_peserta_detil');

    Route::get('/admin/psikotest', myroute::view('Admin\Psikotest\Page', 'bladeView'))->name('admin_psikotest');
    Route::get('/admin/psikotest/kecermatan', myroute::view('Admin\Psikotest\Kecermatan\Page', 'bladeView'))->name('admin_psikotest_kecermatan');
    Route::get('/admin/psikotest/kecermatan-baru', myroute::view('Admin\Psikotest\Kecermatan\Baru\Page', 'bladeView'))->name('admin_psikotest_kecermatan_baru');
    Route::post('/admin/psikotest/kecermatan-baru', myroute::view('Admin\Psikotest\Kecermatan\Baru\Page', 'store'))->name('admin_psikotest_kecermatan_store');
    Route::get('/admin/psikotest/kecermatan-edit/{id}', myroute::view('Admin\Psikotest\Kecermatan\Edit\Page', 'bladeView'))->name('admin_psikotest_kecermatan_edit');
    Route::put('/admin/psikotest/kecermatan-edit/{id}', myroute::view('Admin\Psikotest\Kecermatan\Edit\Page', 'update'))->name('admin_psikotest_kecermatan_update');
    Route::delete('/admin/psikotest/kecermatan-delete/{id}', myroute::view('Admin\Psikotest\Kecermatan\Page', 'delete'))->name('admin_psikotest_kecermatan_delete');
    
    Route::get('/admin/psikotest/kecermatan/detil/{id}', myroute::view('Admin\Psikotest\Kecermatan\Detil\Page', 'bladeView'))->name('admin_psikotest_kecermatan_detil');
    Route::get('/admin/psikotest/kecermatan/detil-baru/{id}', myroute::view('Admin\Psikotest\Kecermatan\Detil\Baru\Page', 'bladeView'))->name('admin_psikotest_kecermatan_detil_baru');
    Route::post('/admin/psikotest/kecermatan/detil-baru/{id}', myroute::view('Admin\Psikotest\Kecermatan\Detil\Baru\Page', 'store'))->name('admin_psikotest_kecermatan_detil_store');
    Route::get('/admin/psikotest/kecermatan/detil-edit/{id1}/{id2}', myroute::view('Admin\Psikotest\Kecermatan\Detil\Edit\Page', 'bladeView'))->name('admin_psikotest_kecermatan_detil_edit');
    Route::put('/admin/psikotest/kecermatan/detil-edit/{id1}/{id2}', myroute::view('Admin\Psikotest\Kecermatan\Detil\Edit\Page', 'update'))->name('admin_psikotest_kecermatan_detil_update');
    Route::delete('/admin/psikotest/kecermatan/detil-delete/{id1}/{id2}', myroute::view('Admin\Psikotest\Kecermatan\Detil\Page', 'delete'))->name('admin_psikotest_kecermatan_detil_delete');

    Route::get('admin/monitor/userlog-activities/{sort}/{by}/{search}',  myroute::view('Admin\Monitor\UserLogActivities\Page', 'bladeView'))->name('admin_monitor_userlog_activities');
    Route::get('admin/monitor/guestlog-activities', myroute::view('Admin\Monitor\GuestLogActivities\Page', 'bladeView'))->name('admin_monitor_guestlog_activities');
    Route::get('admin/monitor/userlog-activities/backup/all',  myroute::view('Admin\Monitor\UserLogActivities\Page', 'backup'))->name('admin_monitor_userlog_activities_backup_all');
    Route::delete('admin/monitor-userlog-activities/truncate',  myroute::view('Admin\Monitor\UserLogActivities\Page', 'truncate'))->name('admin_monitor_userlog_activities_truncate');
    Route::get('admin/monitor-userlog-activities-detil/{type}/{id}/{sort}/{by}/{search}',  myroute::view('Admin\Monitor\UserLogActivities\Detil\Page', 'bladeView'))->name('admin_monitor_userlog_activities_detil');
    Route::get('admin/monitor-userlog-activities-detil/backup/{id}',  myroute::view('Admin\Monitor\UserLogActivities\Detil\Page', 'backup'))->name('admin_monitor_userlog_activities_detil_backup');
    Route::delete('admin/monitor-userlog-activities-detil/delete/{id}',  myroute::view('Admin\Monitor\UserLogActivities\Detil\Page', 'delete'))->name('admin_monitor_userlog_activities_detil_delete');

    Route::get('/admin/variabel-setting/{sort}/{by}/{search}', myroute::view('Admin\Variabel\Page', 'bladeView'))->name('admin_variabel_setting');
    Route::get('/admin/variabel-baru',  myroute::view('Admin\Variabel\Baru\Page', 'bladeView'))->name('admin_variabel_baru');
    Route::post('/admin/variabel-baru', myroute::view('Admin\Variabel\Baru\Page', 'store'))->name('admin_variabel_store');
    Route::get('/admin/variabel-edit/{id}', myroute::view('Admin\Variabel\Edit\Page', 'bladeView'))->name('admin_variabel_edit');
    Route::put('/admin/variabel-edit/{id}', myroute::view('Admin\Variabel\Edit\Page', 'update'))->name('admin_variabel_update');
    Route::delete('/admin/variabel-delete/{id}', myroute::view('Admin\Variabel\Page', 'delete'))->name('admin_variabel_delete');
});

Route::get('/mengenai_kami', myroute::view('Aboutus', 'bladeView'))->name('mengenai_kami');
Route::get('/artikel', myroute::view('Artikel', 'bladeView'))->name('artikel');
Route::get('/blog', myroute::view('Admin\Blog\Public\Page', 'bladeView'))->name('blog');
// Route::get('/blog-mencari/{cari}', myroute::view('Admin\Blog\Public\Page', 'bladeView'))->name('blog_search');
Route::get('/blog/{judul}', myroute::view('Admin\Blog\Public\Detil\Page', 'bladeView'))->name('blog_detail');
Route::get('/kontak', myroute::view('Kontak', 'bladeView'))->name('kontak');
Route::get('/layanan', myroute::view('Layanan\Page', 'bladeView'))->name('layanan');
Route::get('/layanan/psikotes-sim', myroute::view('Layanan\PsikotesSIM\Page', 'bladeView'))->name('layanan_psikotessim');
Route::get('/link-psikotes', myroute::view('LinkPsikotes', 'bladeView'))->name('linkpsikotes');

Route::post('/csp-report', myroute::api('Security\CSPReportController', 'store'))
        ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

// routes/web.php
Route::get('/.env', function () {
    abort(403, 'Forbidden');
});


Route::get('/experiment/read-file-json', myroute::view('Experiment', 'read_file_json_reactview'));

Route::get('hello', function(Request $request){
    // Storage::disk('user_admin')->makeDirectory('coba');
    // return url()->current();
    // return csrf_token();
    // return $request->header();
    // return config('app.url');
    return url(':8000'.route('admin'));
});

Route::get('hello-auth', function(Request $request){
    if (Auth::check()) {
        // The user is logged in...
        // return var_dump(Auth());
        // return 'hello... AUTH';
        return $request->session()->all();
    }
    return 'hello... UGH!';
});

Route::get('/test-cookie', function (Request $request) {
    Cookie::queue('isloginnnnnnnnn', true, (60*24*60*60), '/', 'https://psikotesasyik.com', true, true, false, 'none');
    $request->session()->put('session', 'I am SESSION!');
    return response('Test Cookie')->cookie(
        'test_cookie', 'test_value', 60, '/', null, false, true, false, 'none'
    );
});

Route::get('/test-session', function (Request $request) {
    return $request->session()->get('session');
});

Route::get('/coba-file-json', function (Request $request) {
    $filePath = storage_path('logs/guest/20250715.json'); // Use forward slashes for paths
    if (Storage::exists($filePath)) {
        $fileContents = Storage::get($filePath);
        $orders = json_decode($fileContents, true); // Decode JSON to an associative array
        return response()->json($orders); // Return as JSON response
    } else {
        return response()->json(['error' => 'File not found'], 404);
    }
});

// require __DIR__.'/auth.php';

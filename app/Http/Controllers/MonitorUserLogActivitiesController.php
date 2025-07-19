<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use App\Services\userService;
use App\Services\useractivitiesService;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use Exception;
use Meta;

class MonitorUserLogActivitiesController extends Controller {
    //
    protected userService|null $service;
    protected useractivitiesService|null $activity;
    protected $titlepage, $path, $domain, $unique;
    protected $id, $nama, $email, $roles, $pat, $rtk, $filename;
    public function __construct(
        Request $request,
        userService $service,
        useractivitiesService $activity,
    ) {
        // ?
        $this->service  = $service;
        $this->activity = $activity;

        // ?
        $this->path = env('SESSION_PATH', '/');
        $this->domain = env('SESSION_DOMAIN', 'localhosthost:8000');
        $this->unique = fun::random('combwisp', 50);

        // ?
    }

    public function allUser(): Response|JsonResponse|String|int|null {

    }

    public function getUser(): Response|JsonResponse|String|int|null {

    }

    public function backupAll(): Response|JsonResponse|String|int|null {

    }

    public function truncate(): Response|JsonResponse|String|int|null {

    }

    public function backupUser(): Response|JsonResponse|String|int|null {

    }

    public function deleteOneUserAdminActivities(): Response|JsonResponse|String|int|null {

    }

    public function __destruct() {
        $this->service  = null;
        $this->activity = null;
    }
}

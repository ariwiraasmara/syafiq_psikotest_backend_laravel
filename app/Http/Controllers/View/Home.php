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
use App\Libraries\jsr;
use Exception;

class Home extends Controller {
    //
    public function __construct() {
        
    }

    public function view(Request $request): Inar|JsonResponse|Collection|array|String|int|null {
        return Inertia::render('Home', [
            'title'     => 'Psikotest Online App',
            'pathURL'   => url()->current(),
            'robots'    => 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate',
            'onetime'   => true
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

<?php
// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers\View\Admin\Psikotest;
use Inertia\Inertia;
use Inertia\Response as Inar;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use App\Libraries\myfunction as fun;

class Page extends Controller {
    //
    public function view(Request $request): Inar|JsonResponse|Collection|array|String|int|null {
        return Inertia::render('admin/psikotest/page', [
            'title'   => 'Daftar Psikotest | Admin | Psikotest Online App',
            'pathURL' => url()->current(),
            'robots'  => 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate',
            'onetime' => false,
        ]);
    }

    public function bladeView(Request $request): View|Response|JsonResponse|Collection|array|String|int|null {
        return view('pages.admin.psikotest.page', [
            'title'                => 'Daftar Psikotest | Admin | Psikotest Online App',
            'appbar_title'         => 'Daftar Psikotest',
            'pathURL'              => url()->current(),
            'breadcrumb'           => '/admin/psikotest',
            'navval'               => 'nav-admin-psikotest',
            'is_breadcrumb_hidden' => 'hidden',
            'robots'               => 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate',
            'onetime'              => false,
            'unique'               => fun::random('combwisp', 50),
            'nama'                 => $request->session()->get('nama'),
            'psikotest'            => [
                'kecermatan',
                // 'intelegensia'
            ]
        ]);
    }
}

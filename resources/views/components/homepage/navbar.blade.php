@php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
use Illuminate\Support\Facades\URL;
$nonce = request()->attributes->get('csp_nonce');
@endphp
<div class="max-md:hidden sticky flex flex-col items-center justify-center text-center bg-gradient-to-t from-sky-300 to-sky-700 w-full" style="height: 28px;">
    <h2 id="navbar" class="hidden">Navbar</h2>
    <div id="mainmenu" class="flex flex-row justify-between text-sm">
        <div class="lg:flex lg:flex-row text-white">
            <!-- Desktop Main Menu -->
            <div class="">
                <a href="{{ route('home') }}" rel="follow" title="Beranda" class="p-2 rounded-l-xl bg-gradient-to-b hover:bg-gradient-to-t from-sky-300 to-sky-700 border-2 border-blue-700 text-white">
                    Beranda
                </a>
            </div>

            @if(!isset($_COOKIE['ispeserta']))
            <div class="">
                <a href="{{ URL::signedRoute('admin', absolute: true); }}" rel="nofollow, noopener, noreferrer" title="Admin" class="p-2 bg-gradient-to-b hover:bg-gradient-to-t from-sky-300 to-sky-700 border-2 border-blue-700 text-white">
                    Admin
                </a>
            </div>
            @endif

            <div class="">
                <a href="#" id="navbar-desktop-peserta" title="Peserta" class="p-2 bg-gradient-to-b hover:bg-gradient-to-t from-sky-300 to-sky-700 border-2 border-blue-700 text-white">
                    Peserta <ion-icon name="caret-down-outline"></ion-icon>
                </a>
                <div class="flex flex-column text-black">
                    <div id="submenupeserta" class="hidden absolute items-center bg-white shadow-lg mt-2 rounded-lg text-left">
                        <a href="#" id="desktop-peserta" rel="follow" title="Mulai Psikotest" class="px-4 py-2 block border-b-2 border-black hover:bg-gray-300">Mulai Psikotest</a>
                        <a href="#" title="Hasil Tes Psikotest Kecermatan" class="px-4 py-2 block hover:bg-gray-300" onclick="popupHasilTesPsikotestKecermatan()">Hasil Tes Psikotest Kecermatan</a>
                    </div>
                </div>
            </div>

            <div class="">
                <a href="#" id="navbar-desktop-blog" title="Informasi" class="p-2 bg-gradient-to-b hover:bg-gradient-to-t from-sky-300 to-sky-700 border-2 border-blue-700 text-white">
                    Blog <ion-icon name="caret-down-outline"></ion-icon>
                </a>

                <div class="flex flex-column text-black">
                    <div id="submenuinformasi" class="hidden absolute items-center bg-white shadow-lg mt-2 rounded-lg text-left">
                        <a href="{{ route('blog') }}" rel="follow" title="Semua | Blog" class="px-4 py-2 block border-b-2 border-black hover:bg-gray-300">Semua</a>
                        <a href="{{ route('blog').'?kategori=acara' }}" rel="follow" title="Acara | Blog" class="px-4 py-2 block border-b-2 border-black hover:bg-gray-300">Acara</a>
                        <a href="{{ route('blog').'?kategori=artikel' }}" rel="follow" title="Artikel | Blog" class="px-4 py-2 block border-b-2 border-black hover:bg-gray-300">Artikel</a>
                        <a href="{{ route('blog').'?kategori=informasi' }}" rel="follow" title="Informasi | Blog" class="px-4 py-2 block border-b-2 border-black hover:bg-gray-300">Informasi</a>
                        <a href="{{ route('blog').'?kategori=kegiatan' }}" rel="follow" title="Kegiatan | Blog" class="px-4 py-2 block hover:bg-gray-300">Kegiatan</a>
                    </div>
                </div>
            </div>

            <div class="">
                <a href="{{ URL::temporarySignedRoute('mengenai_kami', now()->addMinutes(10)) }}" rel="follow" title="Mengenai Kami" class="p-2 bg-gradient-to-b hover:bg-gradient-to-t from-sky-300 to-sky-700 border-2 border-blue-700 text-white">
                    Mengenai Kami
                </a>
            </div>

            <div class="">
                <a href="{{ URL::temporarySignedRoute('artikel', now()->addMinutes(10)) }}" rel="follow" title="Artikel" class="p-2 bg-gradient-to-b hover:bg-gradient-to-t from-sky-300 to-sky-700 border-2 border-blue-700 text-white">Artikel</a>
            </div>

            <div class="">
                <a href="{{ URL::temporarySignedRoute('layanan', now()->addMinutes(10)) }}" rel="follow" title="Layanan" class="p-2 bg-gradient-to-b hover:bg-gradient-to-t from-sky-300 to-sky-700 border-2 border-blue-700 text-white">
                    Layanan
                </a>
            </div>

            <div class="">
                <a href="{{ URL::temporarySignedRoute('linkpsikotes', now()->addMinutes(10)) }}" rel="follow" title="Link Psikotest" class="p-2 bg-gradient-to-b hover:bg-gradient-to-t from-sky-300 to-sky-700 border-2 border-blue-700 text-white">
                    Link Psikotest
                </a>
            </div>

            <div class="">
                <a href="{{ URL::temporarySignedRoute('kontak', now()->addMinutes(10)) }}" rel="follow" title="Kontak" class="p-2 bg-gradient-to-b hover:bg-gradient-to-t from-sky-300 to-sky-700 border-2 border-blue-700 text-white">
                    Kontak
                </a>
            </div>

            <div class="">
                <a href="{{ URL::temporarySignedRoute('layanan_psikotessim', now()->addMinutes(10)) }}" rel="follow" title="Biro Psikotes SIM" class="p-2 rounded-r-xl bg-gradient-to-b hover:bg-gradient-to-t from-sky-300 to-sky-700 border-2 border-blue-700 text-white">
                    Biro Psikotes SIM
                </a>
            </div>
        </div>
    </div>
</div>
<!-- Mobile Menu Button -->
<div class="lg:hidden font-bold bg-gradient-to-t from-sky-300 to-sky-700 text-black" style="height: 30px;">
    <button type="button" id="navbar-mobile-btn-menu" class="w-full text-left font-bold" onclick="toggleMobileMenu()" style="padding: 3px;">
        <ion-icon name="menu-outline"></ion-icon> Menu
    </button>
</div>
<!-- Mobile Menu -->

<div id="mobile-menu" class="hidden lg:hidden bg-gradient-to-t from-sky-100 to-sky-300 text-black w-full text-left text-sm">
    <div class="flex flex-col">
        <div class="py-2 mb-2 hover:bg-blue-100">
            <a href="{{ route('home') }}" rel="follow" title="Beranda" class="p-2 w-full block">
                <ion-icon name="return-up-forward-outline"></ion-icon> Beranda
            </a>
        </div>

        @if(!isset($_COOKIE['ispeserta']))
        <div class="pb-2 mb-2 hover:bg-blue-100">
            <a href="{{ URL::signedRoute('admin', absolute: true); }}" rel="nofollow, noopener, noreferrer" title="Admin" class="p-2 w-full block">
                <ion-icon name="return-up-forward-outline"></ion-icon> Admin
            </a>
        </div>
        @endif

        <div class="mb-2 hover:bg-blue-100">
            <button type="button" id="navbar-mobile-peserta" title="Peserta" class="p-2 w-full block text-left">
                <ion-icon name="return-up-forward-outline"></ion-icon> Peserta <ion-icon name="caret-down-outline"></ion-icon>
            </button>
            <div id="mobile-submenupeserta" class="ml-6 border-l-2 border-black hidden">
                <a href="#" id="mobile-peserta" rel="follow" title="Mulai Psikotest" class="px-4 py-2 w-full block border-b-2 border-black hover:bg-blue-300">Mulai Psikotest</a>
                <a href="#" title="Hasil Tes Psikotest Kecermatan" class="px-4 py-2 w-full block hover:bg-blue-300" onclick="popupHasilTesPsikotestKecermatan()">Hasil Tes Psikotest Kecermatan</a>
            </div>
        </div>

        <div class="mb-2 hover:bg-blue-100">
            <button type="button" id="navbar-mobile-blog" title="Informasi" class="p-2 w-full block text-left">
                <ion-icon name="return-up-forward-outline"></ion-icon> Blog <ion-icon name="caret-down-outline"></ion-icon>
            </button>
            <div id="mobile-submenuinformasi" class="ml-6 border-l-2 border-black hidden">
                <a href="{{ route('blog') }}" rel="follow" title="Semua | Blog" class="px-4 py-2 w-full block border-b-2 border-black hover:bg-blue-300">Semua</a>
                <a href="{{ route('blog').'?kategori=acara' }}" rel="follow" title="Acara | Blog" class="px-4 py-2 w-full block border-b-2 border-black hover:bg-blue-300">Acara</a>
                <a href="{{ route('blog').'?kategori=artikel' }}" rel="follow" title="Artikel | Blog" class="px-4 py-2 w-full block border-b-2 border-black hover:bg-blue-300">Artikel</a>
                <a href="{{ route('blog').'?kategori=informasi' }}" rel="follow" title="Informasi | Blog" class="px-4 py-2 w-full block border-b-2 border-black hover:bg-blue-300">Informasi</a>
                <a href="{{ route('blog').'?kategori=kegiatan' }}" rel="follow" title="Kegiatan | Blog" class="px-4 py-2 w-full block hover:bg-blue-300">Kegiatan</a>
            </div>
        </div>

        <div class="pb-2 mb-2 hover:bg-blue-100">
            <a href="{{ URL::temporarySignedRoute('artikel', now()->addMinutes(10)); }}" rel="follow" title="Artikel" class="p-2 w-full block">
                <ion-icon name="return-up-forward-outline"></ion-icon> Artikel
            </a>
        </div>

        <div class="pb-2 mb-2 hover:bg-blue-100">
            <a href="{{ URL::temporarySignedRoute('mengenai_kami', now()->addMinutes(10)); }}" rel="follow" title="Mengenai Kami" class="p-2 w-full block">
                <ion-icon name="return-up-forward-outline"></ion-icon> Mengenai Kami
            </a>
        </div>

        <div class="pb-2 mb-2 hover:bg-blue-100">
            <a href="{{ URL::temporarySignedRoute('layanan', now()->addMinutes(10)); }}" rel="follow" title="Layanan" class="p-2 w-full block">
                <ion-icon name="return-up-forward-outline"></ion-icon> Layanan
            </a>
        </div>

        <div class="pb-2 mb-2 hover:bg-blue-100">
            <a href="{{ URL::temporarySignedRoute('linkpsikotes', now()->addMinutes(10)); }}" rel="follow" title="Link Psikotest" class="p-2 w-full block">
                <ion-icon name="return-up-forward-outline"></ion-icon> Link Psikotest
            </a>
        </div>

        <div class="pb-2 mb-2 hover:bg-blue-100">
            <a href="{{ URL::temporarySignedRoute('kontak', now()->addMinutes(10)); }}" rel="follow" title="Kontak" class="p-2 w-full block">
                <ion-icon name="return-up-forward-outline"></ion-icon> Kontak
            </a>
        </div>

        <div class="pb-2 hover:bg-blue-100">
            <a href="{{ URL::temporarySignedRoute('layanan_psikotessim', now()->addMinutes(10)); }}" rel="follow" title="Biro Psikotes SIM" class="p-2 w-full block">
                <ion-icon name="return-up-forward-outline"></ion-icon> Biro Psikotes SIM
            </a>
        </div>
    </div>
</div>

<script nonce="{{ $nonce }}" src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous"></script>
<script defer nonce="{{ $nonce }}" src="https://cdn.jsdelivr.net/npm/crypto-js/index.min.js" integrity="sha512-wAL/CX2oapYVhCeLcpIcdxZJjaVJxLl+XhMXV0ZuD7ZIq4WjjhQ3ZHhC4LWmDny3E9n3Cj6BEpVsuoqAeTmdYQ==" crossorigin="anonymous"></script>
<script defer nonce="{{ $nonce }}" src="https://cdn.jsdelivr.net/npm/js-cookie/dist/js.cookie.min.js" integrity="sha512-nlp9/l96/EpjYBx7EP7pGASVXNe80hGhYAUrjeXnu/fyF5Py0/RXav4BBNs7n5Hx1WFhOEOWSAVjGeC3oKxDVQ==" crossorigin="anonymous"></script>
<script>
    function toPeserta() {
        try {
            const path = `{{ env('SESSION_PATH') }}`; // Use a valid path or domain option if needed
            const domain = `{{ env('SESSION_DOMAIN') }}`;
            Cookies.set('ispeserta', true, { expires: 1, path: path, secure: true, sameSite: 'strict' });
            localStorage.setItem('ispeserta', true);
            window.location.href = "{{ URL::signedRoute('peserta', absolute: true) }}";
        }
        catch(error) {
            console.error(error);
        }
    }

    function toggleMobileMenu() {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    }

    function submenuToggle(submenu) {
        if(submenu == 'submenupeserta') {
            document.getElementById('submenupeserta').classList.toggle('hidden');
            document.getElementById('submenuinformasi').classList.add('hidden');
        } else if(submenu == 'submenuinformasi') {
            document.getElementById('submenupeserta').classList.add('hidden');
            document.getElementById('submenuinformasi').classList.toggle('hidden');
        } else {
            console.error('Invalid submenu');
        }
    }

    function submenuMobileToggle(submenu) {
        if(submenu == 'mobile-submenupeserta') {
            document.getElementById('mobile-submenupeserta').classList.toggle('hidden');
            document.getElementById('mobile-submenuinformasi').classList.add('hidden');
        } else if(submenu == 'mobile-submenuinformasi') {
            document.getElementById('mobile-submenupeserta').classList.add('hidden');
            document.getElementById('mobile-submenuinformasi').classList.toggle('hidden');
        } else {
            console.error('Invalid submenu');
        }
    }

    function popupHasilTesPsikotestKecermatan() {
        Swal.fire({
            title: 'Hasil Tes Psikotest Kecermatan',
            icon: 'info',
            html: `
                <p class="text-black">Isi data terlebih dahulu kemudian "OK" dan Anda akan diarahkan ke halaman hasil tes psikotest kecermatan.</p>
                <input type="number" id="hasiltespsikotestkecermatan-noidentitas" class="p-2 border-2 border-black rounded-lg w-full mt-4" placeholder="No. Identitas..." />
                <input type="date" id="hasiltespsikotestkecermatan-tgltes" class="p-2 border-2 border-black rounded-lg w-full mt-4" placeholder="Tanggal Tes" />
            `,
            focusConfirm: false,
            preConfirm: () => window.location.href = `/public/peserta/psikotest/kecermatan/hasil/${document.getElementById("hasiltespsikotestkecermatan-noidentitas").value}/${document.getElementById("hasiltespsikotestkecermatan-tgltes").value}`,
            allowOutsideClick: true,
            allowEscapeKey: false,
            allowEnterKey: true,
            showCancelButton: true,
            confirmButtonText: 'OK',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
        });
    }

    $('#desktop-peserta').on('click', function() {
        toPeserta();
    });

    $('#mobile-peserta').on('click', function() {
        toPeserta();
    });

    $('#navbar-desktop-peserta').on('click', function() {
        submenuToggle('submenupeserta');
    });

    $('#navbar-mobile-peserta').on('click', function() {
        submenuMobileToggle('mobile-submenupeserta');
    });

    $('#navbar-desktop-blog').on('click', function() {
        submenuToggle('submenuinformasi');
    });

    $('#navbar-mobile-blog').on('click', function() {
        submenuMobileToggle('mobile-submenuinformasi');
    });
</script>
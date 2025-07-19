@php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
@endphp
<div class="bg-black shadow-md max-w-screen w-full fixed" style="bottom: 0px; padding: 5px;">
    <div class="container mx-auto flex flex-row justify-items-center text-center text-white">
        <div class="basis-1/2 w-full" id="nav-admin-dashboard" class="text-center">
            <a href="{{ route('admin_dashboard') }}" rel='follow' title="Halaman Dashboard | Admin" style="padding: 5px">
                <span class="text-xl">
                    <ion-icon name="home-outline"></ion-icon>
                </span><br/>
                <span class="text-base">Dashboard</span>
            </a>
        </div>
        <div class="basis-1/2 w-full" id="nav-admin-peserta" class="text-center">
            <a href="{{ route('admin_peserta', ['sort' => 'nama', 'by' => 'asc', 'search' => '-']) }}?page=1" rel='follow' title="Halaman Peserta | Admin" style="padding: 5px">
                <span class="text-xl">
                    <ion-icon name="people-outline"></ion-icon>
                </span><br/>
                <span class="text-base">Peserta</span>
            </a>
        </div>
    </div>
</div>

<script>
    function active(theid) {
        document.getElementById(theid).classList.add('bg-blue-700');
        document.getElementById(theid).classList.add('rounded-lg');
        document.getElementById(theid).classList.add('font-bold');
    }

    function inactive(theid) {
        document.getElementById(theid).classList.remove('bg-white');
        document.getElementById(theid).classList.remove('rounded-lg');
        document.getElementById(theid).classList.remove('font-bold');
    }

    if("{{ $navval }}" == 'nav-admin-dashboard') {
        active('{{ $navval }}');
        inactive('nav-admin-peserta');
    }
    else if("{{ $navval }}" == 'nav-admin-peserta') {
        active('{{ $navval }}');
        inactive('nav-admin-dashboard');
    }
    else {
        inactive('nav-admin-dashboard');
        inactive('nav-admin-peserta');
    }
</script>
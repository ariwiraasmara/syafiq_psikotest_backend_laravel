@php
// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
@endphp
<div class="bg-black shadow-md max-w-screen w-full fixed" style="bottom: 0px; padding: 5px;">
    <div class="container mx-auto flex justify-between items-center text-white">
        <a href="{{ route('admin_dashboard') }}" id="nav-admin-dashboard" class="text-center" rel='follow' title="Halaman Dashboard | Admin" style="padding: 5px">
            <span class="text-xl">
                <ion-icon name="home-outline"></ion-icon>
            </span><br/>
            <span class="text-base">Dashboard</span>
        </a>
        <a href="{{ route('admin_peserta', ['sort' => 'nama', 'by' => 'asc', 'search' => '-']) }}?page=1" id="nav-admin-peserta" class="text-center" rel='follow' title="Halaman Peserta | Admin" style="padding: 5px">
            <span class="text-xl">
                <ion-icon name="people-outline"></ion-icon>
            </span><br/>
            <span class="text-base">Peserta</span>
        </a>
        <a href="{{ route('admin_psikotest') }}" id="nav-admin-psikotest" class="text-center" rel='follow' title="Halaman Psikotest | Admin" style="padding: 5px">
            <span class="text-xl">
                <ion-icon name="folder-open-outline"></ion-icon>
            </span><br/>
            <span class="text-base">Psikotest</span>
        </a>
        <a href="{{ route('admin_variabel_setting', ['sort' => 'variabel', 'by' => 'asc', 'search' => '-']) }}?page=1" id="nav-admin-variabel" class="text-center" rel='follow' title="Halaman Variabel | Admin" style="padding: 5px">
            <span class="text-xl">
                <ion-icon name="settings-outline"></ion-icon>
            </span><br/>
            <span class="text-base">Variabel</span>
        </a>
    </div>
</div>

<script>
    if("{{ $navval }}" == 'nav-admin-dashboard') {
        document.getElementById('nav-admin-dashboard').classList.add('bg-blue-700');
        document.getElementById('nav-admin-dashboard').classList.add('rounded-lg');
        document.getElementById('nav-admin-peserta').classList.remove('bg-blue-700');
        document.getElementById('nav-admin-peserta').classList.remove('rounded-lg');
        document.getElementById('nav-admin-psikotest').classList.remove('bg-blue-700');
        document.getElementById('nav-admin-psikotest').classList.remove('rounded-lg');
        document.getElementById('nav-admin-variabel').classList.remove('bg-blue-700');
        document.getElementById('nav-admin-variabel').classList.remove('rounded-lg');
    }
    else if("{{ $navval }}" == 'nav-admin-peserta') {
        document.getElementById('nav-admin-dashboard').classList.remove('bg-blue-700');
        document.getElementById('nav-admin-dashboard').classList.remove('rounded-lg');
        document.getElementById('nav-admin-peserta').classList.add('bg-blue-700');
        document.getElementById('nav-admin-peserta').classList.add('rounded-lg');
        document.getElementById('nav-admin-psikotest').classList.remove('bg-blue-700');
        document.getElementById('nav-admin-psikotest').classList.remove('rounded-lg');
        document.getElementById('nav-admin-variabel').classList.remove('bg-blue-700');
        document.getElementById('nav-admin-variabel').classList.remove('rounded-lg');
    }
    else if("{{ $navval }}" == 'nav-admin-psikotest') {
        document.getElementById('nav-admin-dashboard').classList.remove('bg-blue-700');
        document.getElementById('nav-admin-dashboard').classList.remove('rounded-lg');
        document.getElementById('nav-admin-peserta').classList.remove('bg-blue-700');
        document.getElementById('nav-admin-peserta').classList.remove('rounded-lg');
        document.getElementById('nav-admin-psikotest').classList.add('bg-blue-700');
        document.getElementById('nav-admin-psikotest').classList.add('rounded-lg');
        document.getElementById('nav-admin-variabel').classList.remove('bg-blue-700');
        document.getElementById('nav-admin-variabel').classList.remove('rounded-lg');
    }
    else if("{{ $navval }}" == 'nav-admin-variabel') {
        document.getElementById('nav-admin-dashboard').classList.remove('bg-blue-700');
        document.getElementById('nav-admin-dashboard').classList.remove('rounded-lg');
        document.getElementById('nav-admin-peserta').classList.remove('bg-blue-700');
        document.getElementById('nav-admin-peserta').classList.remove('rounded-lg');
        document.getElementById('nav-admin-psikotest').classList.remove('bg-blue-700');
        document.getElementById('nav-admin-psikotest').classList.remove('rounded-lg');
        document.getElementById('nav-admin-variabel').classList.add('bg-blue-700');
        document.getElementById('nav-admin-variabel').classList.add('rounded-lg');
    }
    else {
        document.getElementById('nav-admin-dashboard').classList.remove('bg-blue-700');
        document.getElementById('nav-admin-dashboard').classList.remove('rounded-lg');
        document.getElementById('nav-admin-peserta').classList.remove('bg-blue-700');
        document.getElementById('nav-admin-peserta').classList.remove('rounded-lg');
        document.getElementById('nav-admin-psikotest').classList.remove('bg-blue-700');
        document.getElementById('nav-admin-psikotest').classList.remove('rounded-lg');
        document.getElementById('nav-admin-variabel').classList.remove('bg-blue-700');
        document.getElementById('nav-admin-variabel').classList.remove('rounded-lg');
    }
</script>
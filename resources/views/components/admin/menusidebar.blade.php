<div class="fixed inset-0 hidden" id="menu_sidebar" style="z-index: 999; height: auto;">
    <!-- Sidebar -->
    <div id="" class="relative mx-auto border shadow-lg rounded-md bg-white" style="overflow-y: scroll; overflow-x: scroll;">
        <div id="head" class="flex flex-col shadow-md p-2 border-b-2 border-white bg-black text-white" onclick="window.location.href= `{{ route('admin_myprofil', ['email' => $email]) }}`">
            <div class="flex-1">
                <h2 class="text-lg font-bold">Ari Wiraasmara</h2>
            </div>
            <div class="flex-1">
                <h3 class="text-sm italic">Super Admin</h3>
            </div>
        </div>
        <nav id="body" class="flex-1 overflow-y-auto">
            <ul class="p-2">
                <li class="p-2" id="nav-admin-dashboard">
                    <a href="{{ route('admin_dashboard') }}" rel='follow' title="Halaman Dashboard | Admin">
                        <span class="">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="">Dashboard</span>
                    </a>
                </li>
                <li class="p-2" id="nav-admin-peserta">
                    <a href="{{ route('admin_peserta', ['sort' => 'nama', 'by' => 'asc', 'search' => '-']) }}?page=1" rel='follow' title="Halaman Peserta | Admin">
                        <span class="">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="">Peserta Tes</span>
                    </a>
                </li>
                <li class="p-2" id="nav-admin-blog">
                    <a href="{{ route('admin_blog', ['sort' => 'title', 'by' => 'asc', 'search' => '-']) }}?page=1" rel='follow' title="Halaman Blog | Admin">
                        <span class="">
                            <ion-icon name="file-tray-outline"></ion-icon>
                        </span>
                        <span class="">Blog</span>
                    </a>
                </li>
                @if($roles == 1)
                    <li class="p-2">
                        <span class="">
                            <ion-icon name="desktop-outline"></ion-icon>
                        </span>
                        <span class="">Monitor</span>

                        <ul class="border-t-2 border-b-2 border-white">
                            <li class="p-2 ml-2" id="nav-monitor-userlogactivities">
                                <a href="{{ route('admin_monitor_userlog_activities', ['sort' => 'Users.name', 'by' => 'asc', 'search' => '-', 'page'=>1]) }}" rel='follow' title="Halaman Monitor User Log Activities | Admin">
                                    <span class="text-base">User Log Activities</span>
                                </a>
                            </li>
                            <li class="p-2 ml-2" id="nav-monitor-guestlogactivities">
                                <a href="{{ route('admin_monitor_guestlog_activities') }}" rel='follow' title="Halaman Monitor Guest Log Activities | Admin">
                                    <span class="">Guest Log Activities</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="p-2">
                        <span class="">
                            <ion-icon name="settings-outline"></ion-icon>
                        </span>
                        <span class="">Setting</span>
                        <ul class="border-t-2 border-b-2 border-white">
                            <li class="p-2 ml-2" id="nav-admin-anggota">
                                <a href="{{ route('admin_anggota', ['sort' => 'name', 'by' => 'asc', 'search' => '-']) }}?page=1" rel='follow' title="Halaman Admin | Admin">
                                    <span class="text-base">Admin</span>
                                </a>
                            </li>
                            <li class="p-2 ml-2" id="nav-admin-psikotest">
                                <a href="{{ route('admin_psikotest') }}" rel='follow' title="Halaman Psikotest | Admin">
                                    <span class="text-base">Psikotest</span>
                                </a>
                            </li>
                            <li class="p-2 ml-2" id="nav-admin-variabel">
                                <a href="{{ route('admin_variabel_setting', ['sort' => 'variabel', 'by' => 'asc', 'search' => '-']) }}?page=1" rel='follow' title="Halaman Variabel | Admin">
                                    <span class="text-base">Variabel</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                <li class="p-2">
                    <a href="{{ route('admin_logout'); }}" rel='follow' title="Logout | Admin">
                        <span class="">
                            <ion-icon name="log-out-outline"></ion-icon>
                        </span>
                        <span class="">Logout</span>
                    </a>
                </li>
                <li class="p-2" onclick="hideSidebar()">
                    <span class="">
                        <ion-icon name="close-outline"></ion-icon>
                    </span>
                    <span class="">Tutup</span>
                </li>
            </ul>
        </nav>
    </div>
</div>

<script>
    function active(theid) {
        document.getElementById(theid).classList.add('bg-blue-700');
        document.getElementById(theid).classList.add('rounded-lg');
        document.getElementById(theid).classList.add('text-white');
        document.getElementById(theid).classList.add('font-bold');
    }

    function inactive(theid) {
        document.getElementById(theid).classList.remove('bg-white');
        document.getElementById(theid).classList.remove('rounded-lg');
        document.getElementById(theid).classList.remove('font-bold');
        document.getElementById(theid).classList.remove('text-white');
        document.getElementById(theid).classList.add('text-black');
    }

    if('{{ $navval }}' == 'nav-admin-dashboard') {
        active('{{ $navval }}');
        inactive('nav-admin-peserta');
        inactive('nav-admin-psikotest');
        inactive('nav-admin-variabel');
        inactive('nav-monitor-userlogactivities');
    }
    else if('{{ $navval }}' == 'nav-admin-peserta') {
        active('{{ $navval }}');
        inactive('nav-admin-dashboard');
        inactive('nav-admin-psikotest');
        inactive('nav-admin-variabel');
        inactive('nav-monitor-userlogactivities');
    }
    else if('{{ $navval }}' == 'nav-admin-psikotest') {
        active('{{ $navval }}');
        inactive('nav-admin-dashboard');
        inactive('nav-admin-peserta');
        inactive('nav-admin-variabel');
        inactive('nav-monitor-userlogactivities');
    }
    else if('{{ $navval }}' == 'nav-admin-variabel') {
        active('{{ $navval }}');
        inactive('nav-admin-dashboard');
        inactive('nav-admin-peserta');
        inactive('nav-admin-psikotest');
        inactive('nav-monitor-userlogactivities');
    }
    else if('{{ $navval }}' == 'nav-monitor-userlogactivities') {
        active('{{ $navval }}');
        inactive('nav-admin-dashboard');
        inactive('nav-admin-peserta');
        inactive('nav-admin-psikotest');
        inactive('nav-admin-variabel');
    }
    else {
        inactive('nav-admin-dashboard');
        inactive('nav-admin-peserta');
        inactive('nav-admin-psikotest');
        inactive('nav-admin-variabel');
        inactive('nav-monitor-userlogactivities');
    }
</script>
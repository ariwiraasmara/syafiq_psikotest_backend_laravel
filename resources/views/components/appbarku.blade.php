@php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
@endphp
<h1 class='hidden'>Halaman {{ $appbar_title }} | Admin</h1>
<div class="bg-black p-4 shadow-md max-w-screen" style="z-index: 10;">
    <div class="mx-auto flex justify-between items-center">
        <div class="text-white text-lg font-bold">
            @if($link_back == '' || $link_back == null || $link_back == 'null' || $link_back == '#')
                @if($roles == 1)
                    @if($sidebar)
                        <span onclick="showSidebar()">
                            <ion-icon name="menu-outline"></ion-icon>
                        </span>
                    @endif
                @endif
                <span class="">{{ $appbar_title }}</span>
            @else
                <a href="{{ $link_back }}">
                    <span class="hidden">Kembali</span>
                    <ion-icon name="arrow-back-outline"></ion-icon>
                </a>
                <span class="ml-2">{{ $appbar_title }}</span>
            @endif
        </div>
        @auth()
            @if($roles > 1)
                <div class="flex space-x-4 relative">
                    <button type="button" class="text-white hover:text-gray-200 rounded" onclick="opentoggleMenuSessionAdmin()">
                        <ion-icon name="ellipsis-vertical-outline"></ion-icon>
                    </button>
                    <div id="sessionmenuadmin" class="hidden absolute bg-white shadow-lg rounded-lg text-left max-w-s overflow-hidden" style="right: 1%; z-index: 9; width: 150px;">
                        <button type="button" class="text-left block px-4 py-2 text-black hover:bg-gray-200 w-full" onclick="profilku()">
                            <ion-icon name="person-circle-outline"></ion-icon> {{ $nama }}
                        </button>
                        <button type="button" class="text-left block px-4 py-2 text-black hover:bg-gray-200 w-full" onclick="window.location.href = `{{ route('admin_logout'); }}`">
                            <ion-icon name="log-out-outline"></ion-icon> Logout
                        </button>
                        <button type="button" class="text-left block px-4 py-2 text-black hover:bg-gray-200 w-full" onclick="closetoggleMenuSessionAdmin()">
                            <ion-icon name="close-outline"></ion-icon> Tutup
                        </button>
                    </div>
                </div>
            @endif
        @endauth
    </div>
</div>

@if($roles > 1)
    <script>
        function profilku() {
            window.location.href = `{{ route('admin_myprofil', ['email' => $email]) }}`;
        }

        function opentoggleMenuSessionAdmin() {
            document.getElementById('sessionmenuadmin').classList.toggle('hidden');
        }

        function closetoggleMenuSessionAdmin() {
            const menu = document.getElementById('sessionmenuadmin');
            const button = document.querySelector('.bg-blue-500');
            // if (!menu.contains(event.target) && !button.contains(event.target)) {
                menu.classList.add('hidden');
            // }
        }

        // Close the menu if clicked outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('sessionmenuadmin');
            const button = document.querySelector('.bg-blue-500');
            if (!menu.contains(event.target) && !button.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });
    </script>
@else
    <script>
        function showSidebar() {
            document.getElementById('menu_sidebar').classList.remove('hidden');
        }

        function hideSidebar() {
            document.getElementById('menu_sidebar').classList.add('hidden');
        }
    </script>
@endif
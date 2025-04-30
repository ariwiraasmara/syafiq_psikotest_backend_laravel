@php
// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
@endphp
<div class="bg-black p-4 shadow-md max-w-screen" style="z-index: 10;">
    <div class="container mx-auto flex justify-between items-center">
        <div class="text-white text-lg font-bold">
            @if($link_back == '' || $link_back == null || $link_back == 'null' || $link_back == '#')
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
        <div class="flex space-x-4 relative">
            <button type="button" class="bg-blue-500 text-white hover:text-gray-200 rounded" onclick="opentoggleMenuSessionAdmin()">
                <ion-icon name="ellipsis-vertical-outline"></ion-icon>
            </button>
            <div id="sessionmenuadmin" class="hidden absolute bg-white shadow-lg rounded-lg text-left max-w-xs overflow-hidden" style="right: 1%; z-index: 9;">
                <button type="button" class="text-left block px-4 py-2 text-black hover:bg-gray-200 w-full" onclick="closetoggleMenuSessionAdmin()">{{ $nama }}</button>
                <button type="button" class="text-left block px-4 py-2 text-black hover:bg-gray-200 w-full" onclick="window.location.href = '/logout'">Logout</button>
                <button type="button" class="text-left block px-4 py-2 text-black hover:bg-gray-200 w-full" onclick="closetoggleMenuSessionAdmin()">Tutup</button>
            </div>
        </div>
        @endauth
    </div>
</div>

<script>
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
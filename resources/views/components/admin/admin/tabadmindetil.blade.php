@php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
@endphp
<div class="mt-0 w-full bg-white rounded-lg shadow-xl">
    <div class="border-b border-gray-500">
        <div class="flex justify-center">
            <button id="tab-0" class="w-full py-2 border-b-2 border-transparent hover:border-gray-700" onclick="showTab(0)">
                Device History
            </button>
        </div>
    </div>
    <div id="panel-0" class="p-4 hidden" style="width: 100%;">
        <!-- Content for Grafik -->
        @component('components.admin.admin.tabeldevicehistorydetail', [
            'data'   => $data_device,
            'nourut' => 1,
            'session_roles' => $session_roles,
            'user_roles'    => $user_roles
        ]) @endcomponent
    </div>
</div>

<script>
    function showTab(index) {
        const panels = document.querySelectorAll('[id^="panel-"]');
        const tabs = document.querySelectorAll('[id^="tab-"]');
        
        panels.forEach((panel, i) => {
            if (i === index) {
                panel.classList.remove('hidden');
                tabs[i].classList.add('border-current');
                tabs[i].classList.add('font-bold');
                tabs[i].classList.add('bg-gray-500');
            } else {
                panel.classList.add('hidden');
                tabs[i].classList.remove('border-current');
                tabs[i].classList.remove('font-bold');
                tabs[i].classList.remove('bg-gray-500');
            }
        });
    }
</script>
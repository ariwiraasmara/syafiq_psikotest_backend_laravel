@php
// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
@endphp
<div class="w-full">
    <div class="border-b border-gray-500">
        <div class="flex justify-center">
            <button id="tab-0" class="w-full py-2 border-b-2 border-transparent hover:border-gray-700" onclick="showTab(0)">
                Tabel
            </button>
            <button id="tab-1" class="w-full py-2 border-b-2 border-transparent hover:border-gray-700" onclick="showTab(1)">
                Grafik
            </button>
        </div>
    </div>
    <div id="panel-0" class="p-4" style="width: 100%;">
        <!-- Content for Tabel -->
        @component('components.admin.peserta.tabelhasilpsikotestpesertadetil', [
            'unique'     => $unique,
            'peserta_id' => $peserta_id,
            'hasiltes'   => $hasiltes
        ]) @endcomponent
    </div>
    <div id="panel-1" class="p-4 hidden" style="width: 100%;">
        <!-- Content for Grafik -->
        @component('components.admin.peserta.grafikhasilpsikotestkecermatan_peserta', [
            'unique'     => $unique,
            'peserta_id' => $peserta_id,
            'hasiltes'   => $hasiltes
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
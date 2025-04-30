@php
// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
@endphp
<div class="items-center p-2 text-center border-b-2 border-white justify-items-center bg-gradient-to-t from-sky-300 to-sky-700">
    <div class="grid grid-cols-3 gap-4 justify-self-center">
        <div class="">
            <button type="button" class="p-2 hover:border-t-2 hover:border-white">
                Beranda
            </button>
        </div>
        <div class="">
            <button type="button" class="p-2 hover:border-t-2 hover:border-white" onClick="window.location.href='/admin'">
                Admin
            </button>
        </div>
        <div class="relative">
            <button type="button" class="p-2 hover:border-t-2 hover:border-white" onClick="toggleSubMenuPeserta()">
                Peserta
            </button>
            <div id="submenupeserta" class="hidden absolute bg-white shadow-lg mt-2 rounded-lg text-left">
                <button type="button" class="text-left block px-4 py-2 text-gray-800" onclick="toPeserta()">Mulai Psikotest</button>
                <button type="button" class="text-left block px-4 py-2 text-gray-800" onclick="popupHasilTesPsikotestKecermatan()">Hasil Tes Psikotest Kecermatan</button>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleSubMenuPeserta() {
        const submenu = document.getElementById('submenupeserta');
        submenu.classList.toggle('hidden');
    }

    function toPeserta() {
        try {
            const pathDomain = '/'; // Use a valid path or domain option if needed
            Cookies.set('ispeserta', true, { expires: 6, path: pathDomain, secure: true, sameSite: 'strict' });
            localStorage.setItem('ispeserta', true);
            // route('peserta');
            window.location.href = '/peserta';
        }
        catch(error) {
            console.error(error);
        }
    }

    function popupHasilTesPsikotestKecermatan() {
        Swal.fire({
            title: 'Hasil Tes Psikotest Kecermatan',
            text: 'Anda akan diarahkan ke halaman hasil tes psikotest kecermatan.',
            icon: 'info',
            html: `
                <input type="number" id="hasiltespsikotestkecermatan-noidentitas" class="swal2-input" placeholder="No. Identitas..." />
                <input type="date" id="hasiltespsikotestkecermatan-tgltes" class="swal2-input" placeholder="Tanggal Tes" />
            `,
            focusConfirm: false,
            preConfirm: () => window.location.href = `/peserta/psikotest/kecermatan/hasil/${document.getElementById("hasiltespsikotestkecermatan-noidentitas").value}/${document.getElementById("hasiltespsikotestkecermatan-tgltes").value}`,
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
</script>
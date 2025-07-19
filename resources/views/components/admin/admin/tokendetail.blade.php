@php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
@endphp
<div class="text-wrap">
    <p><span class="font-bold">Name :</span> {{ $data['name'] }}</p>

    @if($session_roles == 1)
        <p><span class="font-bold">Token :</span> {{ $data['token'] }}</p>
        <p><span class="font-bold">Abilities :</span> {{ $data['abilities'] }}</p>
    @endif

    <p><span class="font-bold">Terakhir Digunakan :</span> {{ $data['last_used_at'] }}</p>
    <p><span class="font-bold">Tanggal Kadaluarsa :</span> {{ $data['expires_at'] }}</p>
    <p><span class="font-bold">Tanggal Dibuat :</span> {{ $data['created_at'] }}</p>
    <p><span class="font-bold">Tanggal Diperbaharui :</span> {{ $data['updated_at'] }}</p>
</div>

@if($user_roles == $session_roles)
    <div class="mt-4 italic">
        <button type="button" class="mt-2 p-2 w-full block bg-blue-500 text-white rounded-lg shadow-xl" onclick="modalToken2()">
            Perbaharui
        </button>
    </div>

    <script>
        async function modalToken2() {
            Swal.fire({
                title: "Update Token 2?",
                text: "Setelah Klik 'OK' Anda Akan Logout",
                icon: "info",
                showConfirmButton: true,
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href= `{{ route('admin_anggota_update_pat', ['roles' => $user_roles, 'type' => 'php']); }}`;
                }
            });
        }
    </script>
@endif
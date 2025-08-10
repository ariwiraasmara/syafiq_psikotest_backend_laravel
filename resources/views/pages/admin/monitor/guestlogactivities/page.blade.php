@php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
@endphp
@php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
use App\Libraries\myfunction;

$style_content = 'margin-bottom: 60px;';
$style_fab = 'margin-bottom: 23px;';
$style_paging = 'bottom: 1px; margin-bottom: 0px; padding: 10px;';

if($roles > 1) {
    $style_content = 'margin-bottom: 130px;';
    $style_fab = 'margin-bottom: 90px;';
    $style_paging = 'bottom: 1px; margin-bottom: 70px; padding: 10px;';
}
@endphp
@extends('layouts.app')
@section('content')
    @component('components.appbarku', [
        'nama'         => $nama,
        'email'        => $email,
        'sidebar'      => true,
        'link_back'    => route('admin_monitor_userlog_activities', ['sort' => 'Users.name', 'by' => 'asc', 'search' => '-', 'page' => 1]),
        'appbar_title' => $appbar_title,
        'roles'        => $roles,
        'navval'       => $navval,
        'email'        => $email
    ]) @endcomponent

    <div id="user-activities" class="p-4">
        <div class="">
            <span class="font-bold underline">Pilih Berkasnya dulu...</span>
            <select id="" class="p-2 w-full block bg-white text-black rounded-md" onchange="loadLogFile(this.value)">
                <option value="" disabled selected>Pilih Berkas Monitor...</option>
                <option value="" disabled>-----</option>
                @if(!empty($filenames))
                    @foreach($filenames as $item)
                        <option value="{{ $item }}">{{ $item }}</option>
                    @endforeach
                @endif
            </select>
        </div>

        <div class="mt-6" style="width: 100%; overflow-x: scroll;">
            @if($filejson)
                <div class="font-bold mb-2">{{ $filejson }}, {{ $file_date }}</div>
            @endif
            <table class="bg-white text-black shadow-xl border-spacing-2 table-auto" style="width: 100%; overflow-x: scroll;">
                <thead>
                    <tr>
                        <th class="text-center font-bold" style="padding: 5px; border: 3px solid #000;">Waktu</th>
                        <th class="text-center font-bold" style="padding: 5px; border: 3px solid #000;">IP Address</th>
                        <th class="text-center font-bold" style="padding: 5px; border: 3px solid #000;">Device</th>
                        <th class="text-center font-bold" style="padding: 5px; border: 3px solid #000;">OS</th>
                        <th class="text-center font-bold" style="padding: 5px; border: 3px solid #000;">Browser</th>
                        <th class="text-center font-bold" style="padding: 5px; border: 3px solid #000;">Path</th>
                        <th class="text-center font-bold" style="padding: 5px; border: 3px solid #000;">Halaman</th>
                        <th class="text-center font-bold" style="padding: 5px; border: 3px solid #000;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if($data)
                        @foreach($data as $entry)
                            <tr>
                                <td class="text-center" style="padding: 5px; border-right: 1px solid #eee; border-bottom: 1px solid #ddd;">{{ $entry->tanggal ?? '-' }}</td>
                                <td style="padding: 5px; border-right: 1px solid #eee; border-bottom: 1px solid #ddd;">{{ $entry->perangkat->ip_address ?? '-' }}</td>
                                <td style="padding: 5px; border-right: 1px solid #eee; border-bottom: 1px solid #ddd;">{{ $entry->perangkat->device->type ?? '-' }}</td>
                                <td style="padding: 5px; border-right: 1px solid #eee; border-bottom: 1px solid #ddd;">{{ $entry->perangkat->operation_system->name ?? '-' }}</td>
                                <td style="padding: 5px; border-right: 1px solid #eee; border-bottom: 1px solid #ddd;">{{ $entry->perangkat->browser->name ?? '-' }}</td>
                                <td style="padding: 5px; border-right: 1px solid #eee; border-bottom: 1px solid #ddd;">{{ $entry->aktifitas->path ?? '-' }}</td>
                                <td style="padding: 5px; border-right: 1px solid #eee; border-bottom: 1px solid #ddd;">{{ $entry->aktifitas->kunjungan_terakhir_halaman ?? '-' }}</td>
                                <td style="padding: 5px; border-right: 1px solid #eee; border-bottom: 1px solid #ddd;">{{ $entry->aktifitas->deskripsi ?? '-' }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8">
                                <div class="mt-4 text-center font-bold text-xl">
                                    Tidak ada data aktivitas
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    @if($roles == 1)
    @component('components.admin.menusidebar', ['navval' => $navval, 'email' => $email, 'roles' => $roles]) @endcomponent
    @endif
    @component('components.footer', ['hidden' => 'hidden', 'otherCSS' => '']) @endcomponent

    <script>
        function loadLogFile(filename) {
            // Ganti sesuai routing Laravel-mu
            window.location.href = `{{ route('admin_monitor_guestlog_activities'); }}?file=` + filename;
        }
    </script>
@endsection
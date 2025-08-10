@php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
@endphp
<div style="width: 100%; overflow-x: scroll;">
    <table class="border-spacing-2 table-auto" style="width: 100%; overflow-x: scroll;">
        <thead>
            <tr style="border-bottom: 3px solid #000;">
                <th style="border-right: 2px solid #000; padding: 3px;" class="text-center">No.</th>
                <th style="border-right: 2px solid #000; padding: 3px;" class="">Tanggal Terakhir Login</th>
                <th style="border-right: 2px solid #000; padding: 3px;" class="">IP Address</th>
                <th style="border-right: 2px solid #000; padding: 3px;">User Agent</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
                <tr style="border-bottom: 1px solid #aaa;" class="hover:bg-gray-400">
                    <td style="border-right: 2px solid #000; padding-left: 10px; padding-right: 10px;" class="border-black border-r-2 text-right">{{ $nourut; }}</td>
                    <td style="border-right: 2px solid #000; padding-left: 10px; padding-right: 10px;" class="border-black border-r-2">{{ $item['last_login']; }}</td>
                    <td style="border-right: 2px solid #000; padding-left: 10px; padding-right: 10px;" class="border-black border-r-2">{{ $item['ip_address']; }}</td>
                    <td style="border-right: 2px solid #000; padding-left: 10px; padding-right: 10px;">{{ $item['user_agent']; }}</td>
                </tr>
                @php $nourut++; @endphp
            @endforeach
        </tbody>
        @if($user_roles == $session_roles)
            <tfoot>
                <tr>
                    <th colspan="4">
                        <button type="button" class="p-2 w-full block bg-red-700 text-white rounded-lg shadow-xl">
                            <ion-icon name="trash-outline"></ion-icon>
                        </button>
                    </th>
                </tr>
            </tfoot>
        @endif
    </table>
</div>
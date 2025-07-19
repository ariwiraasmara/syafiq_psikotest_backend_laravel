{{--
! Copyright @
! PT. Solusi Psikologi Banten
! Syafiq Marzuki
! Syahri Ramadhan Wiraasmara (ARI)
--}}
<div class="text-center fixed w-full bg-black text-white" style="bottom: 1px; margin-bottom: 70px; padding: 10px;">
    <div>
        <span class='mr-2'>Halaman </span>
        <select id="select-page" class="border-2 border-white bg-white rounded-md text-black text-right" onchange="toPage()" style="width 80px; height: 30px;">
            @for($x = 1; $x <= $lastpage; $x++)
                <option value="{{ $x }}" @if($x == $currentpage) selected @endif>
                    {{$x}}
                </option>
            @endfor
        </select>
        <span class='ml-2'>/ {{ $lastpage }}</span>
    </div>
    <div class="hidden">
        @for($x = 1; $x <= $lastpage; $x++)
            <a href="{{ $link.'/'.$currentpage.'/'.$sort.'/'.$by.'/'.$search }}" rel="follow" title="{{ 'Halaman '.$x }}">
                {{$x}}
            </a>
        @endfor
    </div>

    <script>
        function toPage() {
            let page = document.getElementById('select-page').value;
            window.location.href = `{{ $link.'/${page}'.'/'.$sort.'/'.$by.'/'.$search }}`;
        }
    </script>
</div>
@php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
@endphp
<div class="border-4 mt-4 rounded-lg w-full border-black p-2 content-center bg-gray-400" id="{{ 'soalgroup-'.$id }}">
    <div class='text-center' style="font-size: 20px;">
        <span class="mr-4">{{ $soal1 }}</span>
        <span class="mr-4">{{ $soal2 }}</span>
        <span class="mr-4">{{ $soal3 }}</span>
        <span class="mr-4">{{ $soal4 }}</span>
        <span class="">.....</span>
    </div>

    <div class="justify-center text-center mt-2" id="{{ 'jawabangroup-'.$id }}">
        <span class="mr-2 radioku">
            <input  type="radio" id="{{ 'jawaban-a-'.$no }}" name="{{ 'jawaban-no-'.$id }}"
                    value="{{ $jawabanA; }}"
                    onchange="handleChange_nilaiTotal(event, {{ $id }}, {{ $kuncijawaban; }})"
            />
            <label class="checkmark" for="jawaban-a" style="margin-left: -3px;">A</label>
        </span>

        <span class="mr-2 radioku">
            <input  type="radio" id="{{ 'jawaban-b-'.$no }}" name="{{ 'jawaban-no-'.$id }}"
                    value="{{ $jawabanB; }}"
                    onchange="handleChange_nilaiTotal(event, {{ $id }}, {{ $kuncijawaban; }})"
            />
            <label class="checkmark" for="jawaban-b" style="margin-left: -3px;">B</label>
        </span>

        <span class="mr-2 radioku">
            <input  type="radio" id="{{ 'jawaban-c-'.$no }}" name="{{ 'jawaban-no-'.$id }}"
                    value="{{ $jawabanC; }}"
                    onchange="handleChange_nilaiTotal(event, {{ $id }}, {{ $kuncijawaban; }})"
            />
            <label class="checkmark" for="jawaban-c" style="margin-left: -3px;">C</label>
        </span>

        <span class="mr-2 radioku">
            <input  type="radio" id="{{ 'jawaban-d-'.$no }}" name="{{ 'jawaban-no-'.$id }}"
                    value="{{ $jawabanD; }}"
                    onchange="handleChange_nilaiTotal(event, {{ $id }}, {{ $kuncijawaban; }})"
            />
            <label class="checkmark" for="jawaban-d" style="margin-left: -3px;">D</label>
        </span>

        <span class="mr-2 radioku">
            <input  type="radio" id="{{ 'jawaban-e-'.$no }}" name="{{ 'jawaban-no-'.$id }}"
                    value="{{ $jawabanE; }}"
                    onchange="handleChange_nilaiTotal(event, {{ $id }}, {{ $kuncijawaban; }})"
            />
            <label class="checkmark" for="jawaban-e" style="margin-left: -3px;">E</label>
        </span>
    </div>
</div>
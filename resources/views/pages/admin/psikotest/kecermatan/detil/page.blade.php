{{--
! Copyright @
! PT. Solusi Psikologi Banten
! Syafiq Marzuki
! Syahri Ramadhan Wiraasmara (ARI)
--}}
@php
    use App\Libraries\myfunction;
    $page = @$_GET['page'];
    $numbertable = 0;
    if($page == 1) $numbertable = 1;
    else if($page == 2) $numbertable = 11;
    else if($page == 3) $numbertable = 21;
    else if($page == 4) $numbertable = 31;
    else if($page == 5) $numbertable = 41;
    else if($page == 6) $numbertable = 51;
    else if($page == 7) $numbertable = 61;
    else if($page == 8) $numbertable = 71;
    else if($page == 9) $numbertable = 81;
    else if($page == 10) $numbertable = 91;
    else $numbertable = 0;
@endphp
@extends('layouts.app')
@section('content')
    @component('components.appbarku', [
        'nama'         => $nama,
        'email'        => $email,
        'sidebar'      => false,
        'link_back'    => route('admin_psikotest_kecermatan'),
        'appbar_title' => $appbar_title,
        'roles'        => $roles
    ]) @endcomponent

    <div class="p-4 text-black" style="margin-bottom: 0px;">
        <div class="mb-0 text-black">
            <h1 class='hidden'>Halaman {{ $appbar_title }} | Admin</h1>

            <h2 class='font-bold'>Detil Psikotest Kecermatan</h2>
            <h2 class="font-bold">Pertanyaan {{ $pertanyaan['kolom_x'].' : ['.
                $pertanyaan['nilai_A'].', '.
                $pertanyaan['nilai_B'].', '.
                $pertanyaan['nilai_C'].', '.
                $pertanyaan['nilai_D'].', '.
            ' ]'; }}

                <span class='ml-4'>
                    <a href="{{ route('admin_psikotest_kecermatan_edit', ['id' => $id]); }}" rel='nofollow' title='Edit Data Pertanyaan'>
                        <span class="hidden">Edit Data Pertanyaan</span>
                        <span class="mr-2"><ion-icon name="pencil-outline"></ion-icon></span>
                    </a>
                </span>
            </h2>

            <div id="" class="mt-4 rounded-lg bg-white border-2 border-black" style="width: 100%; overflow-x: scroll;">
                <table class="border-spacing-2 table-auto" style="width: 100%; overflow-x: scroll;">
                    <thead>
                        <tr>
                            <th class="p-2" style="width: 10%; border-bottom: 2px solid #000; border-right: 2px solid #000;">#</th>
                            <th class="p-2" style="width: 25%; border-bottom: 2px solid #000; border-right: 2px solid #000;">Soal</th>
                            <th class="p-2" style="width: 25%; border-bottom: 2px solid #000; border-right: 2px solid #000;">Jawaban</th>
                            <th class="p-2" style="width: 20%; border-bottom: 2px solid #000;" colspan="2">Edit / Delete</th>
                        </tr>
                    </thead>

                    <tbody id="data-body">
                        @forelse($jawaban as $data)
                            <tr>
                                <td class="text-center p-2" style="border-bottom: 1px solid #aaa; border-right: 2px solid #000;">{{ $numbertable; }}</td>
                                <td class="text-center p-2" style="border-bottom: 1px solid #aaa; border-right: 2px solid #000;">
                                    {{ $data['soal_jawaban']['soal'][0][0]; }},
                                    {{ $data['soal_jawaban']['soal'][0][1]; }},
                                    {{ $data['soal_jawaban']['soal'][0][2]; }},
                                    {{ $data['soal_jawaban']['soal'][0][3]; }}
                                </td>
                                <td class="text-center p-2" style="border-bottom: 1px solid #aaa; border-right: 2px solid #000;">
                                    {{ $data['soal_jawaban']['jawaban']; }}
                                </td>
                                <td class="text-center p-2" style="border-bottom: 1px solid #aaa; border-right: 2px solid #000;">
                                    <a href="{{ route('admin_psikotest_kecermatan_detil_edit', ['id1' => $id, 'id2' => myfunction::enval($data['id'], true)]); }}" rel="nofollow" title="{{ 'Edit Soal & Jawaban ' }}">
                                        <ion-icon name="pencil-outline"></ion-icon>
                                        <span class="hidden">Edit</span>
                                    </a>
                                </td>
                                <td class="text-center p-2" style="border-bottom: 1px solid #aaa;">
                                    <span onclick="fDelete('{{ $id }}', '{{ myfunction::enval($data['id'], true); }}', '{{ $data['soal_jawaban']['soal'][0][0]; }}', '{{ $data['soal_jawaban']['soal'][0][1]; }}', '{{ $data['soal_jawaban']['soal'][0][2]; }}', '{{ $data['soal_jawaban']['soal'][0][3]; }}', '{{ $data['soal_jawaban']['jawaban']; }}')">
                                        <ion-icon name="trash-outline"></ion-icon>
                                        <span class="hidden">Delete</span>
                                    </span>
                                </td>
                            </tr>
                            @php $numbertable++; @endphp
                        @empty
                            <tr>
                                <td colspan="5" class="text-center p-2">
                                    <h2 class="font-bold text-center text-lg text-black">
                                        Data Peserta Kosong!<br/>Belum Ada Data!
                                    </h2>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                    <tfooter id="data-footer">
                        <tr>
                            <td colspan="5" class="text-center p-2" style="border-top: 2px solid #000;">
                                <span class='mr-2'>Halaman </span>
                                <select id="select-page" class="rounded-lg border-2 border-black text-black text-right" onchange="pageChange(this.value)" style="width: 80px; height: 30px;">
                                    @for($x = 1; $x <= $lastpage; $x++)
                                        <option value="{{ $x }}" @if($x == $page) selected @endif>{{ $x }}</option>
                                    @endfor
                                </select>
                                <span id="txt-lastpage" class='ml-2'>{{ '/ '.$lastpage; }} </span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" class="text-center p-2">
                                <button type="button" style="border: 2px solid #000; border-radius: 100px; padding-top: 10px; padding-bottom: 10px; padding-right: 18px; padding-left: 18px; font-size: 20px;" onclick="toAdd(parseInt('{{ $lastpage }}'))">
                                    +
                                </button>
                            </td>
                        </tr>
                    </tfooter>
                </table>
            </div>
        </div>
    </div>

    @component('components.footer', ['hidden' => 'hidden', 'otherCSS' => '']) @endcomponent

    <script>
        const baseUrl = "{{ route('admin_psikotest_kecermatan_detil', ['id' => 'ID', 'page' => 'PAGE']) }}";

        function pageChange(value) {
            window.location.href= `/public/admin/psikotest/kecermatan/detil/{{ $id }}?page=${value}`;
            const newUrl = baseUrl.replace('ID', '{{ $id }}')
                                .replace('PAGE', value);
            window.location.href = newUrl;
        }

        function toAdd(currentpage) {
            try {
                sessionStorage.setItem('admin_psikotest_kecermatan_tabellastpage', DOMPurify.sanitize(currentpage));
                window.location.href = `{{ route('admin_psikotest_kecermatan_detil_baru', ['id' => $id]) }}`;
            }
            catch(err) {
                console.info('Terjadi Error DetilPsikotestKecermatanDetil-toAdd', err);
            }
        }

        async function fDelete(id1, id2, soalA, soalB, soalC, soalD, jawaban) {
            if(validator.isBase64(id1) && validator.isBase64(id2)) {
                const urlDelete = `{{ route('admin_psikotest_kecermatan_detil_delete', ['id1' => 'ID1', 'id2' => 'ID2']) }}`;
                const newUrl = urlDelete.replace('ID1', DOMPurify.sanitize(id1))
                                        .replace('ID2', DOMPurify.sanitize(id2));
                Swal.fire({
                    title: "Anda yakin ingin menghapus data soal dan jawaban ini?",
                    html: `Soal : ${DOMPurify.sanitize(soalA)}, ${DOMPurify.sanitize(soalB)}, ${DOMPurify.sanitize(soalC)}, ${DOMPurify.sanitize(soalD)}<br/>Jawaban : ${DOMPurify.sanitize(jawaban)}`,
                    showConfirmButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Ya",
                    cancelButtonText: "Batalkan",
                    icon: "warning",
                    showLoaderOnConfirm: true,
                    preConfirm: async () => {
                        try {
                            axios.defaults.withCredentials = true;
                            axios.defaults.withXSRFToken = true;
                            const csrfToken = await axios.get(`/sanctum/csrf-cookie`,  {
                                withCredentials: true,  // Mengirimkan cookie dalam permintaan
                            });
                            const response = await axios.delete(newUrl, {
                                withCredentials: true,  // Mengirimkan cookie dalam permintaan
                                headers: {
                                    'Content-Type': 'application/json',
                                    'XSRF-TOKEN': csrfToken,
                                    'tokenlogin': '{{ $unique; }}',
                                }
                            });
                            if(response.data.success) {
                                setTimeout(() => {
                                    refresh();
                                }, 1000);
                            }
                        } catch (error) {
                            console.info('Terjadi Error DetilPsikotestKecermatanDetil-fDelete', error);
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Terhapus!",
                            text: "Data Telah Berhasil Dihapus",
                            icon: "success"
                        }).then((res2) => {
                            if (res2.isConfirmed) {
                                location.reload();
                            }
                        });
                    }
                });
            }
            else {
                alert('Invalid Credentials!');
            }
        }
    </script>
@endsection
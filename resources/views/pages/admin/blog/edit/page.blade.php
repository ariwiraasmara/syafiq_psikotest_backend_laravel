{{--
! Copyright @
! PT. Solusi Psikologi Banten
! Syafiq Marzuki
! Syahri Ramadhan Wiraasmara (ARI)
--}}
@extends('layouts.app')
@section('content')
    @component('components.appbarku', [
        'nama'         => $nama,
        'email'        => $email,
        'link_back'    => route('admin_blog', ['sort' => 'name', 'by' => 'asc', 'search' => '-']).'?page=1',
        'appbar_title' => $appbar_title,
        'sidebar'      => true,
        'roles'        => $roles,
        'navval'       => $navval
    ]) @endcomponent

    <div class="p-4 text-black" style="margin-bottom: 0px;">
        <h2 class='hidden'>Content {{ $appbar_title }} | Admin</h1>
        <div class="">
            <form action="{{ route('admin_blog_update', ['id' => $id]) }}" method="POST">
                @method('PUT')
                @csrf()
                <input type="hidden" id="unique" name="unique" value="{{ $unique }}" readonly />
                
                <div class="">
                    <span class="font-bold">Status :</span>
                    <input type="radio" id="status-draft" name="status" value="draft" class="ml-2 form-radio" required onclick="isDate('status-draft')" @if($data['status'] == 'draft') checked @endif /> <label for="status-draft" class="">Draft</label>
                    <input type="radio" id="status-public" name="status" value="public" class="ml-4 form-radio" required onclick="isDate('status-public')" @if($data['status'] == 'public') checked @endif /> <label for="status-public" class="">Publikasikan</label>
                </div>

                <div class="mt-4">
                    <span class="font-bold w-full block">Judul</span>
                    <input  type="text" id="txt-title" name="title" required focused
                            class="w-full block shadow-xl p-2 rounded-lg text-black"
                            style="background-color: rgba(255, 255, 255, 1)"
                            value="{{ $data['title']; }}"
                    />
                </div>

                <div class="mt-4 ">
                    <span class="font-bold w-full block">Kategori</span>
                    <select id="select-category" name="category" required class="p-2 bg-white text-black rounded-lg shadow-xl w-full block">
                        <option value="" disabled selected>-- Pilih Kategori --</option>
                        <option value="" disabled>----------</option>
                        <option value="Acara" @if($data['category'] == 'Acara') selected @endif>Acara</option>
                        <option value="Artikel" @if($data['category'] == 'Artikel') selected @endif>Artikel</option>
                        <option value="Informasi" @if($data['category'] == 'Informasi') selected @endif>Informasi</option>
                        <option value="Kegiatan" @if($data['category'] == 'Kegiatan') selected @endif>Kegiatan</option>
                    </select>
                </div>

                <div id="isdate" class="mt-4">
                    <span class="font-bold w-full block">Tanggal Publikasi</span>
                    <input type="datetime-local" id="txt-date" name="tgl_publikasi" class="w-full block shadow-xl p-2 bg-white rounded-lg text-black" value="{{ $data['created_at'] }}" readonly />
                </div>

                <div class="mt-4 bg-white text-black rounded-lg shadow-lg">
                    <textarea id="summernote" name="content">{!! $data['content'] !!}</textarea>
                </div>

                <div class="">
                    <button type="submit" name="submit" value="simpan" class="mt-4 p-2 bg-blue-700 hover:bg-blue-500 shadow-xl text-white rounded-lg text-center w-full">
                        Simpan
                    </button>

                    <button type="button" class="mt-4 p-2 bg-pink-700 hover:bg-pink-500 shadow-xl text-white rounded-lg text-center w-full" onclick="window.location.href = `{{ route('admin_blog', ['sort' => 'name', 'by' => 'asc', 'search' => '-']).'?page=1' }}`">
                        Kembali
                    </button>
                </div>

                @if(session('error'))
                    <div class="bg-red-700 text-white text-center uppercase mt-4 rounded-lg p-4">
                        Terjadi Kesalahan! <br/>
                        Tidak dapat menyimpan data!
                    </div>
                @endif
            </form>
        </div>
    </div>

    @component('components.footer', ['hidden' => 'hidden', 'otherCSS' => '']) @endcomponent
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
    <script>
        function isDate(id) {
            const id_status = document.getElementById(id);
            if(id_status.value == 'draft') {
                document.getElementById('isdate').classList.add('hidden');
            }
            else {
                document.getElementById('isdate').classList.remove('hidden');
            }
        }

        $('#summernote').summernote({
            placeholder: 'Ketik tulisanmu disini...',
            tabsize: 2,
            height: 150,
            toolbar: [
                ['style', ['style']],
                ['font', [
                    'fontname',
                    'fontsize',
                    'fontsizeunit',
                    'color',
                    'forecolor',
                    'backcolor',
                    'bold',
                    'italic',
                    'underline',
                    'strikethrough',
                    'superscript',
                    'subscript',
                    'clear',
                    ]
                ],
                ['color', ['color']],
                ['para', [
                    'style',
                    'ul',
                    'ol',
                    'paragraph',
                    'height'
                    ]
                ],
                ['table', ['table']],
                ['insert', [
                    'link',
                    'picture',
                    'video',
                    'hr']
                ],
                ['view', [
                    'fullscreen',
                    'codeview',
                    'help']
                ]
            ],
            codeviewFilter: true,
            codeviewIframeFilter: true,
            fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Georgia', 'Helvetica Neue', 'Impact', 'Lucida Sans Unicode', 'Tahoma', 'Times New Roman', 'Verdana'],
            fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '20', '22', '24', '26', '28', '30', '32', '34', '36', '38', '40', '42', '44', '46', '48', '50', '52', '54', '56', '58', '60', '62', '64', '66', '68', '70', '72', '74', '76', '78', '80', '82', '84', '86', '88', '90', '92', '94', '96', '98', '100',],
            fontSizeUnits: ['px', 'pt']
        });
    </script>
@endsection
{{--
! Copyright @
! Syafiq
! Syahri Ramadhan Wiraasmara (ARI)
--}}
@extends('layouts.app')
@section('content')
    @component('components.appbarku', [
        'link_back' => '/admin/variabel-setting/variabel/asc/-?page=1',
        'appbar_title' => $appbar_title,
    ]) @endcomponent

    <div class="p-4 text-black" style="margin-bottom: 120px;">
        <h1 class='hidden'>Halaman {{ $appbar_title }} | Admin</h1>

        <div class="">
            <form action="{{ '/admin/variabel-edit/'.$id }}" method="POST">
                @method('PUT')
                @csrf()
                <input type="hidden" id="unique" name="unique" value="{{ $unique }}" readonly />

                <input  type="text" id="txt-variabel" name="variabel" required focused
                        placeholder="Variabel..." label="Variabel..." value="{{ $data[0]['variabel']; }}"
                        class="w-full mt-4 border-white border-2 p-2 rounded-lg text-white"
                        style="background-color: rgba(0, 0, 0, 0.5)"
                />

                <input  type="text" id="txt-values" name="values" required focused
                        placeholder="Nilai..." label="Nilai..." value="{{ $data[0]['values']; }}"
                        class="w-full mt-4 border-white border-2 p-2 rounded-lg text-white"
                        style="background-color: rgba(0, 0, 0, 0.5)"
                />

                <div class="mt-4">
                    <button type="submit" class="p-2 border-2 border-white bg-blue-700 hover:bg-blue-500 text-white rounded-lg text-center w-full">
                        Simpan
                    </button>

                    <button type="button" class="mt-4 p-2 border-2 border-white bg-pink-700 hover:bg-pink-500 text-white rounded-lg text-center w-full" onclick="window.location.href = '/admin/variabel-setting'">
                        Kembali
                    </button>
                </div>
            </form>
        </div>
    </div>

    @component('components.footer', ['hidden' => 'hidden', 'otherCSS' => '']) @endcomponent

    <script>
        async function submit() {
            // e.preventDefault();
            // setLoading(true);
            try {
                const nid = DOMPurify.sanitize(sessionStorage.getItem('admin_variabel_id'))
                const nvariabel = DOMPurify.sanitize(document.getElementById('txt-variabel').value);
                const nvalues = DOMPurify.sanitize(document.getElementById('txt-values').value);
                axios.defaults.withCredentials = true;
                axios.defaults.withXSRFToken = true;
                const csrfToken = await axios.get(`/sanctum/csrf-cookie`, {
                    withCredentials: true,  // Mengirimkan cookie dalam permintaan
                });
                const response = await axios.put(`/api/variabel-setting/${nid}`, {
                    variabel: nvariabel,
                    values: nvalues
                }, {
                    withCredentials: true,  // Mengirimkan cookie dalam permintaan
                    headers: {
                        'Content-Type': 'application/json',
                        'XSRF-TOKEN': csrfToken,
                        'islogin' : DOMPurify.sanitize(localStorage.getItem('islogin')),
                        'isadmin' : DOMPurify.sanitize(localStorage.getItem('isadmin')),
                        'Authorization': `Bearer ${DOMPurify.sanitize(localStorage.getItem('pat'))}`,
                        'remember-token': DOMPurify.sanitize(localStorage.getItem('remember-token')),
                        'tokenlogin': '{{ $unique; }}',
                        'email' : DOMPurify.sanitize(localStorage.getItem('email')),
                        '--unique--': 'I am unique!',
                        'isvalid': 'VALID!',
                        'isallowed': true,
                        'key': 'key',
                        'values': 'values',
                        'isdumb': 'no',
                        'challenger': 'of course',
                        'pranked': 'absolutely'
                    }
                });
                console.log('response', response);
                if(response.data.success) {
                    // router.push('/admin/variabel?page=1');
                    setTimeout(() => {
                        window.location.href = '/admin/variabel/1';
                    }, 3000);
                }
                else {
                    alert('Terjadi Kesalahan Variabel');
                }
            }
            catch(err) {
                console.log('Terjadi Error AdminVariabel-submit:', err);
            }
            // setLoading(false);
        }
    </script>
@endsection
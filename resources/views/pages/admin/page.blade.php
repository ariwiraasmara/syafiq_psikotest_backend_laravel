{{--
! Copyright @
! PT. Solusi Psikologi Banten
! Syafiq Marzuki
! Syahri Ramadhan Wiraasmara (ARI)
--}}
@php
$nonce = request()->attributes->get('csp_nonce');
use App\Libraries\myfunction;
@endphp
@extends('layouts.app')
<style>
body {
    background-color: rgba(200, 200, 255, 0.9);
    background-image: image-set(
        url('../images/bg19.webp') type('image/webp'),
        url('../images/bg19.png') type('image/png')
    );
    background-attachment: fixed;
    font-family: Georgia, Helvetica, sans-serif;
    background-size: cover;
    background-position: center bottom;
}
</style>
@section('content')
    <div class="grid grid-rows-[20px_1fr_20px] items-center justify-items-center min-h-screen p-8 pb-20 gap-16 sm:p-20 font-[family-name:var(--font-geist-sans)]" >
        <div class="flex flex-col gap-8 row-start-2 items-center sm:items-start">
            <div class="form-entry">
                <form id="form-login" method="POST" action="{{ route('admin_login', ['type' => 'php']) }}">
                    <h2 class="text-2xl text-bold uppercase font-bold text-center text-black">Login</h2>
                    <div class='form_admin_peserta text-left'>
                        <input  type="email" id="email" name="email" required
                                placeholder="Email..." label="Email..."
                                class="w-full mt-4 border-black border-2 p-2 rounded-lg text-black"
                        />
                        <input  type="password" id="password" name="password" required
                                placeholder="Password..." label="Password..."
                                class="w-full mt-4 border-black border-2 p-2 rounded-lg text-black"
                        />
                    </div>

                    @if(session('error'))
                        <div class="mt-4 font-bold text-center underline" style="color: rgba(200, 0, 0, 0.9);">
                            @php echo session('error') @endphp
                        </div>
                    @endif

                    @if(!empty($try_login))
                        <div class="mt-4 font-bold text-center underline" style="color: rgba(200, 0, 0, 0.9);">
                            Tunggu {{ $try_login['waiting_time'] / 60 / 60 }} jam sebelum mencoba lagi.
                        </div>
                    @endif

                    <div class="mt-4 grid grid-cols-2 gap-4 justify-self-center">
                        <button type="submit" id="btn-form-login-submit" class="p-2 bg-blue-700 hover:bg-blue-500 shadow-xl text-white rounded-lg text-center">
                            Login
                        </button>

                        <button type="button" id="btn-form-login-back" class="p-2 bg-pink-700 hover:bg-pink-500 shadow-xl text-white rounded-lg text-center">
                            Kembali
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @component('components.footer', ['hidden' => '', 'otherCSS' => '']) @endcomponent

    <script nonce="{{ $nonce }}" src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous"></script>
    <script defer nonce="{{ $nonce }}" src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js" integrity="sha512-h9644v03pHqrIHThkvXhB2PJ8zf5E9IyVnrSfZg8Yj8k4RsO4zldcQc4Bi9iVLUCCsqNY0b4WXVV4UB+wbWENA==" crossorigin="anonymous"></script>
    <script defer nonce="{{ $nonce }}" src="https://cdn.jsdelivr.net/npm/crypto-js/index.min.js" integrity="sha512-wAL/CX2oapYVhCeLcpIcdxZJjaVJxLl+XhMXV0ZuD7ZIq4WjjhQ3ZHhC4LWmDny3E9n3Cj6BEpVsuoqAeTmdYQ==" crossorigin="anonymous"></script>
    <script defer nonce="{{ $nonce }}" src="https://cdn.jsdelivr.net/npm/jsencrypt/lib/index.js" ></script>
    <script defer nonce="{{ $nonce }}" src="https://cdn.jsdelivr.net/npm/validator/validator.min.js" integrity="sha512-D1UQZu1TzZtC8ZwtjDngmaTnXcPXKRdgWSqLxfsW9eY3kWcJV8AN0BP+taOmhyoOJe4io2BjkvSrskYZ2OSQ8A==" crossorigin="anonymous"></script>
    <script defer nonce="{{ $nonce }}" src="https://cdn.jsdelivr.net/npm/dompurify/dist/purify.min.js" integrity="sha512-YlctBG9PGZIhh9keoqI3eZkQM9T8QUbiBi7qNYAO/TUEo8jqWX5pLp5+x1cKRQDRzJ/lyGyJ9WUVNIRduxIIFw==" crossorigin="anonymous"></script>
    <script defer nonce="{{ $nonce }}">
        document.getElementById("btn-form-login-back").addEventListener("click", function (e) {
            e.preventDefault(); // Mencegah pengiriman form secara default
            window.location.href= `{{ route('home') }}`;
        });

        async function submit(email, password) {
            try {
                axios.defaults.withCredentials = true;
                axios.defaults.withXSRFToken = true;
                const getKey = await axios.get(`{{ route('api_public_pem') }}`,  {
                    withCredentials: true,  // Mengirimkan cookie dalam permintaan
                    headers: {
                        'XSRF-TOKEN': '{{ csrf_token(); }}',
                        'Content-Type': 'application/json',
                    }
                });

                if (!getKey) throw new Error("Public key tidak tersedia");

                let encryptor = new JSEncrypt();
                encryptor.setPublicKey(publicKey);

                const encryptedEmail = encryptor.encrypt(email);
                const encryptedPassword = encryptor.encrypt(password);

                if (!encryptedEmail || !encryptedPassword) {
                    throw new Error("Gagal mengenkripsi data");
                }

                const response = await axios.post(`{{ route('admin_login', ['type' => 'js']) }}`, {
                    _token: '{{ csrf_token() }}',
                    email: encryptedEmail,
                    password: encryptedPassword,
                }, {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    withCredentials: true,
                });

                console.log(response.data);
                alert(response.data.message || "Login berhasil");
            }
            catch (err) {
                console.error("Error saat login:", err);
                alert("Gagal login: " + (err.response?.data?.message || err.message));
            }
        }

        document.getElementById("btn-form-login-submit").addEventListener("click", function (e) {
            e.preventDefault();
            const email = DOMPurify.sanitize(document.getElementById("email").value);
            const password = DOMPurify.sanitize(document.getElementById("password").value);

            if (!validator.isEmail(email)) {
                alert("Email tidak valid");
                return;
            }

            if (validator.isEmpty(password)) {
                alert("Password harus minimal 6 karakter");
                return;
            }

            submit(email, password);
        });
    </script>
@endsection

{{--
! Copyright @
! Syafiq
! Syahri Ramadhan Wiraasmara (ARI)
--}}
@extends('layouts.app')
<style>
body {
    background-color: rgba(200, 200, 255, 0.9);
    background-image: url(https://fruitthemes.com/demo/impressive-wordpress-theme/wp-content/uploads/sites/2/2018/06/pexels-photo-247474.jpeg);
    background-attachment: fixed;
    font-family: Georgia, Helvetica, sans-serif;
}
</style>
@section('content')
    <div class="grid grid-rows-[20px_1fr_20px] items-center justify-items-center min-h-screen p-8 pb-20 gap-16 sm:p-20 font-[family-name:var(--font-geist-sans)]" >
        <div class="flex flex-col gap-8 row-start-2 items-center sm:items-start">
            <div class="form-entry">
                <form action="{{ route('admin_login', ['type'=>'php']) }}" method="POST">
                    @csrf()
                    <h2 class="text-2xl text-bold uppercase font-bold text-center text-black">Login</h2>
                    <div class='form_admin_peserta text-left'>
                        <input  type="email" id="email" name="email" required focused
                                placeholder="Email..." label="Email..."
                                class="w-full mt-4 border-black border-2 p-2 rounded-lg text-black"
                        />
                        <input  type="password" id="password" name="password" required focused
                                placeholder="Password..." label="Password..."
                                class="w-full mt-4 border-black border-2 p-2 rounded-lg text-black"
                        />
                    </div>

                     @if(session('error'))
                        <div class="mt-4 font-bold text-center underline" style="color: rgba(200, 0, 0, 0.9);">
                            @php echo session('error') @endphp
                        </div>
                    @endif

                    <div class="mt-4 grid grid-cols-2 gap-4 justify-self-center">
                        <button type="submit" class="p-2 bg-blue-700 hover:bg-blue-500 shadow-xl text-white rounded-lg text-center">
                            Login
                        </button>

                        <button type="button" class="p-2 bg-pink-700 hover:bg-pink-500 shadow-xl text-white rounded-lg text-center" onclick="window.location.href= '{{ route('home') }}'">
                            Kembali
                        </button>
                    </div>
                 </form>
            </div>
        </div>
    </div>

    @component('components.footer', ['hidden' => '', 'otherCSS' => '']) @endcomponent
@endsection

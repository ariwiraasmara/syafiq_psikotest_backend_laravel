@php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
    use App\Libraries\myfunction;
@endphp
<div class="p-2 pb-6 text-items-center background-welcome">
    <h2 class="mt-4 text-2xl text-center font-bold underline"></h2>

    <div class="mt-10">
        <div class="mt-4 grid md:grid-cols-3 gap-2 text-black section-line">
            <div class="xs:mt-4 p-2 mx-4 bg-lp-white-glasses rounded-lg shadow-xl">
                <h3 class="font-bold text-center">Psikotes SIM</h3>
                <div class="mt-2 flex flex-col items-center justify-center text-center">
                    <picture class="block text-center">
                        <source srcset="{{ asset('images/bg6.webp') }}" type="image/webp" />
                        <img src="{{ asset('images/bg6.png') }}" loading="lazy" width="300" height="300" class="rounded-xl" title="Psikotes SIM" alt="Psikotes SIM" />
                    </picture>
                </div>
                <p class="mt-2">
                    PT. SOLUSI Psikologi Banten membantu pihak pemerintah daerah, khususnya Kepolisian Daerah (POLDA) Banten dalam psikotes pembuatan Surat Izin Mengemudi (SIM) baik untuk pembuatan baru dan perpanjangan SIM.
                </p>
            </div>

            <div class="xs:mt-4 p-2 mx-4 bg-lp-white-glasses rounded-lg shadow-xl">
                <h3 class="font-bold text-center">Psikotes Online & Offline</h3>
                <div class="mt-2 flex flex-col items-center justify-center text-center">
                    <picture class="block text-center">
                        <source srcset="{{ asset('images/bg7.webp') }}" type="image/webp" />
                        <img src="{{ asset('images/bg7.png') }}" loading="lazy" width="300" height="300" class="rounded-xl" title="Psikotes Online & Offline" alt="Psikotes Online & Offline" />
                    </picture>
                </div>
                <p class="mt-2">
                    PT. SOLUSI Psikologi Banten telah bekerja sama dengan banyak sekolah, kampus, dan perusahaan yang ada di wilayah Banten untuk memberikan layanan psikotes untuk pendidikan dan psikotes industri.
                </p>
            </div>

            <div class="xs:mt-4 p-2 mx-4 bg-lp-white-glasses rounded-lg shadow-xl">
                <h3 class="font-bold text-center">Konsultasi Online & Offline</h3>
                <div class="mt-2 flex flex-col items-center justify-center text-center">
                    <picture class="block text-center">
                        <source srcset="{{ asset('images/bg8.webp') }}" type="image/webp" />
                        <img src="{{ asset('images/bg8.png') }}" loading="lazy" width="300" height="300" class="rounded-xl" title="Konsultasi Online & Offline" alt="Konsultasi Online & Offline" />
                    </picture>
                </div>
                <p class="mt-2">
                    PT. SOLUSI Psikologi Banten telah banyak membantu klien-klien kami dalam berbagai permasalahan psikologi, baik masalah personal, pernikahan, kelainan, dan perkembangan karir
                </p>
            </div>
        </div>

        <div class="mt-4 grid grid-cols-2 gap-2 text-black section-line">
            <div class="bg-lp-white-glasses p-2 mx-4 rounded-md shadow-xl">
                <div class="p-2 flex flex-col items-center justify-center text-center">
                    <picture class="block text-center">
                        <source srcset="{{ asset('images/Syafiq_Marzuki.webp') }}" type="image/webp" />
                        <img src="{{ asset('images/Syafiq_Marzuki.png') }}" loading="lazy" width="200" height="200" class="rounded-full shadow-xl" width="200" height="350" title="Syafiq Marzuki, Psikolog" alt="Syafiq Marzuki, Psikolog" />
                    </picture>
                </div>
                <p class="mt-2 text-lg">PT. SOLUSI Psikologi Banten Siap membantu permasalahan Psikologi anda dengan sepenuh hati!</p>
                <div class="mt-2 text-right">Syafiq Marzuki, Psikolog</div>
            </div>
            <div class="bg-lp-white-glasses p-2 mx-4 rounded-md shadow-xl">
                <div class="p-2 flex flex-col items-center justify-center text-center">
                    <picture class="block text-center">
                        <source srcset="{{ asset('images/Muhtar.webp') }}" type="image/webp" />
                        <img src="{{ asset('images/Muhtar.png') }}" loading="lazy" width="200" height="200" class="rounded-full shadow-xl" width="200" height="350" title="Muhtar, Marketing dan IT Support" alt="Muhtar, Marketing dan IT Support" />
                    </picture>
                </div>
                <p class="mt-2 text-lg">PT. SOLUSI Psikologi Banten siap membantu anda dengan segala pelayanan terbaik yang kami miliki, baik Online dan Ofline.</p>
                <div class="mt-2 text-right">Muhtar, Marketing dan IT Support</div>
            </div>
        </div>

        <div class="mt-4">
            @if(($data_blog == null) || ($data_blog == '') || $data_blog == [])
                <div class="p-4 bg-white text-black text-center shadow-xl rounded-lg">
                    <h3 class="font-bold text-xl underline">Tidak Ada Informasi Terbaru</h3>
                </div>
            @else
                <h3 class="bg-lp-white-glasses text-black font-bold underline p-2 mt-4 mx-4">Informasi Terbaru...</h3>

                <div class="grid md:grid-cols-3 gap-2 text-black">
                    @foreach($data_blog as $blog)
                        <a href="{{ route('blog_detail', ['judul' => $blog['title']]) }}" title="{{ $blog['title'] }}" class="bg-lp-white-glasses p-4 mx-4 mb-4 rounded-sm shadow-xl" rel="follow">
                            <h4 class="text-xl font-bold mb-2">{{ $blog['title']; }}</h4>
                            <p class="text-wrap">{{ substr($blog['content'], 0, 100).'.....' }}</p>
                            <div class="mt-2 border-t-2 border-black text-xs">
                                <h5 class="font-bold">Kategori: {{ $blog['category']; }}</h5>
                                <h5 class="font-bold">Penulis: {{ $blog['name']; }}</h5>
                                <h5 class="italic">Dibuat: {{ myfunction::formatTimestamp($blog['created_at']); }}</h3>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-4 text-right">
                    <a href="{{ route('blog') }}" rel="follow" class="bg-blue-700 rounded-lg p-2 text-white text-center shadow-xl">
                        Informasi Lainnya <ion-icon name="chevron-forward-outline"></ion-icon>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
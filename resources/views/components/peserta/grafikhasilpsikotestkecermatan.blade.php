@php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
@endphp
<div class="p-2 bg-white rounded-lg border-2 text-black mt-6 border-black ">
    <h4 class="hidden">Hasil Grafik Psikotest Kecermatan</h4>
    <canvas id="chartPsikotestKecermatan"></canvas>
    {{-- Disini seharusnya menampilkan grafik psikotest kecermatan dengan menggunakan library Chart.js dan props yang diterima dari parent component. --}}
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('chartPsikotestKecermatan').getContext('2d');

        const labels = [
            'Kolom 1',
            'Kolom 2',
            'Kolom 3',
            'Kolom 4',
            'Kolom 5',
        ];

        const data = {
            labels: labels,
            datasets: [
                {
                    label: 'Hasil',
                    data: [
                        {{ $hasil_kolom1 }},
                        {{ $hasil_kolom2 }},
                        {{ $hasil_kolom3 }},
                        {{ $hasil_kolom4 }},
                        {{ $hasil_kolom5 }},
                    ],
                    fill: false,
                    borderColor: 'rgba(255, 50, 50, 1)',
                    tension: 0.1,
                    pointBackgroundColor: 'rgba(255, 50, 50, 1)',
                    pointRadius: 5,
                },
                {
                    label: 'Waktu',
                    data: [
                        {{ $waktu_kolom1 }},
                        {{ $waktu_kolom2 }},
                        {{ $waktu_kolom3 }},
                        {{ $waktu_kolom4 }},
                        {{ $waktu_kolom5 }},
                    ],
                    fill: false,
                    borderColor: 'rgba(100, 50, 255, 1)',
                    tension: 0.1,
                    pointBackgroundColor: 'rgba(100, 50, 255, 1)',
                    pointRadius: 5,
                },
            ]
        };

        const options = {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Grafik Hasil Psikotest Kecermatan',
                    color: '#000',
                    font: {
                        size: 18,
                    },
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.dataset.label}: ${context.raw}`;
                        },
                    },
                },
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Kolom',
                        color: '#000',
                    },
                },
                y: {
                    title: {
                        display: true,
                        text: 'Nilai',
                        color: '#000',
                    },
                    beginAtZero: true,
                },
            },
        };

        new Chart(ctx, {
            type: 'line',
            data: data,
            options: options,
        });
    });
</script>
@php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
@endphp
<div class="p-4 rounded-lg mt-4 mb-4 bg-white border-2 border-black w-full">
    <h2 class="font-bold text-center underline">Grafik Psikotest Kecermatan</h2>

    @if($hasiltes->isEmpty())
        <div>
            <h3 class="text-center font-bold text-black">Cari Datanya Dulu...</h3>
        </div>
    @else
    <div>
        <div id="chartContainerNilai" style="overflow-x: scroll; width: 100%;">
            <canvas id="chartPsikotestKecermatan_Nilai"></canvas>
        </div>

        <div id="chartContainerWaktu" class="mt-6 border-t-2 border-black" style="overflow-x: scroll; width: 100%;">
            <canvas id="chartPsikotestKecermatan_Waktu"></canvas>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const hasiltes = @json($hasiltes);

            const labels = hasiltes.map(item => item.tgl_ujian);

            const dataset_nilai = {
                labels: labels,
                datasets: [
                    {
                        label: 'Hasil Nilai Kolom 1',
                        data: hasiltes.map(item => item.hasilnilai_kolom_1),
                        borderColor: 'rgba(255, 0, 0, 1)',
                        backgroundColor: 'rgba(255, 0, 0, 0.2)',
                        fill: false,
                    },
                    {
                        label: 'Hasil Nilai Kolom 2',
                        data: hasiltes.map(item => item.hasilnilai_kolom_2),
                        borderColor: 'rgba(0, 162, 0, 1)',
                        backgroundColor: 'rgba(0, 162, 0, 0.2)',
                        fill: false,
                    },
                    {
                        label: 'Hasil Nilai Kolom 3',
                        data: hasiltes.map(item => item.hasilnilai_kolom_3),
                        borderColor: 'rgba(0, 0, 255, 1)',
                        backgroundColor: 'rgba(0, 0, 255, 0.2)',
                        fill: false,
                    },
                    {
                        label: 'Hasil Nilai Kolom 4',
                        data: hasiltes.map(item => item.hasilnilai_kolom_4),
                        borderColor: 'rgba(255, 255, 0, 1)',
                        backgroundColor: 'rgba(255, 255, 0, 0.2)',
                        fill: false,
                    },
                    {
                        label: 'Hasil Nilai Kolom 5',
                        data: hasiltes.map(item => item.hasilnilai_kolom_5),
                        borderColor: 'rgba(255, 0, 255, 1)',
                        backgroundColor: 'rgba(255, 0, 255, 0.2)',
                        fill: false,
                    },
                ],
            };

            const dataset_waktu = {
                labels: labels,
                datasets: [
                    {
                        label: 'Lama Pengerjaan Kolom 1',
                        data: hasiltes.map(item => item.waktupengerjaan_kolom_1),
                        borderColor: 'rgba(255, 0, 0, 1)',
                        backgroundColor: 'rgba(255, 0, 0, 0.2)',
                        fill: false,
                    },
                    {
                        label: 'Lama Pengerjaan Kolom 2',
                        data: hasiltes.map(item => item.waktupengerjaan_kolom_2),
                        borderColor: 'rgba(0, 162, 0, 1)',
                        backgroundColor: 'rgba(0, 162, 0, 0.2)',
                        fill: false,
                    },
                    {
                        label: 'Lama Pengerjaan Kolom 3',
                        data: hasiltes.map(item => item.waktupengerjaan_kolom_3),
                        borderColor: 'rgba(0, 0, 255, 1)',
                        backgroundColor: 'rgba(0, 0, 255, 0.2)',
                        fill: false,
                    },
                    {
                        label: 'Lama Pengerjaan Kolom 4',
                        data: hasiltes.map(item => item.waktupengerjaan_kolom_4),
                        borderColor: 'rgba(255, 255, 0, 1)',
                        backgroundColor: 'rgba(255, 255, 0, 0.2)',
                        fill: false,
                    },
                    {
                        label: 'Lama Pengerjaan Kolom 5',
                        data: hasiltes.map(item => item.waktupengerjaan_kolom_5),
                        borderColor: 'rgba(255, 0, 255, 1)',
                        backgroundColor: 'rgba(255, 0, 255, 0.2)',
                        fill: false,
                    },
                ],
            };

            const options_nilai = {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Hasil Nilai',
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
                            text: 'Tanggal Ujian',
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

            const options_waktu = {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Waktu Lama Pengerjaan',
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
                            text: 'Tanggal Ujian',
                            color: '#000',
                        },
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Waktu',
                            color: '#000',
                        },
                        beginAtZero: true,
                    },
                },
            };

            const ctx1 = document.getElementById('chartPsikotestKecermatan_Nilai').getContext('2d');
            const ctx2 = document.getElementById('chartPsikotestKecermatan_Waktu').getContext('2d');

            new Chart(ctx1, {
                type: 'line',
                data: dataset_nilai,
                options: options_nilai,
            });

            new Chart(ctx2, {
                type: 'line',
                data: dataset_waktu,
                options: options_waktu,
            });

            // Detect if the device is mobile and adjust orientation
            function adjustOrientation() {
                const isMobile = window.innerWidth <= 768; // Example threshold for mobile devices
                const chartContainerNilai = document.getElementById('chartContainerNilai');
                const chartContainerWaktu = document.getElementById('chartContainerWaktu');

                if (isMobile) {
                    chartContainerNilai.style.width = '1500px'; // Set a larger width for horizontal scrolling
                    chartContainerWaktu.style.width = '1500px';
                } else {
                    chartContainerNilai.style.width = '100%'; // Reset to full width for larger screens
                    chartContainerWaktu.style.width = '100%';
                }
            }

            // Initial check
            adjustOrientation();

            // Adjust on window resize
            window.addEventListener('resize', adjustOrientation);
        });
    </script>
    @endif
</div>
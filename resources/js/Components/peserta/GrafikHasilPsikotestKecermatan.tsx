// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
import * as React from 'react';
import PropTypes from 'prop-types';
import { Line } from 'react-chartjs-2';
import { Chart as ChartJS, CategoryScale, LinearScale, LineElement, PointElement, Title, Tooltip, Legend } from 'chart.js';
// Registrasi komponen Chart.js
ChartJS.register(CategoryScale, LinearScale, LineElement, PointElement, Title, Tooltip, Legend);

interface GrafikHasilPsikotestKecermatan {
    // Define any props you expect to pass to the component here
    // For example: title?: string;
    hasilnilai_kolom_1: number;
    hasilnilai_kolom_2: number;
    hasilnilai_kolom_3: number;
    hasilnilai_kolom_4: number;
    hasilnilai_kolom_5: number;
    waktupengerjaan_kolom_1: number;
    waktupengerjaan_kolom_2: number;
    waktupengerjaan_kolom_3: number;
    waktupengerjaan_kolom_4: number;
    waktupengerjaan_kolom_5: number;
}

GrafikHasilPsikotestKecermatan.propTypes = {
    hasilnilai_kolom_1: PropTypes.number,
    hasilnilai_kolom_2: PropTypes.number,
    hasilnilai_kolom_3: PropTypes.number,
    hasilnilai_kolom_4: PropTypes.number,
    hasilnilai_kolom_5: PropTypes.number,
    waktupengerjaan_kolom_1: PropTypes.number,
    waktupengerjaan_kolom_2: PropTypes.number,
    waktupengerjaan_kolom_3: PropTypes.number,
    waktupengerjaan_kolom_4: PropTypes.number,
    waktupengerjaan_kolom_5: PropTypes.number,
};

export default function GrafikHasilPsikotestKecermatan(props: GrafikHasilPsikotestKecermatan) {
    // Daftar label untuk grafik (Kolom)
    const label: any = [
        'Kolom 1',
        'Kolom 2',
        'Kolom 3',
        'Kolom 4',
        'Kolom 5',
    ];

    // Menyusun dataset secara dinamis berdasarkan nilai kolom yang ada di props
    const dataset: any = {
        label: 'Hasil Psikotest Kecermatan',
        datasets: [
            {
                label: 'Hasil Nilai',
                data: [
                    props.hasilnilai_kolom_1,
                    props.hasilnilai_kolom_2,
                    props.hasilnilai_kolom_3,
                    props.hasilnilai_kolom_4,
                    props.hasilnilai_kolom_5,
                ],
                fill: false,
                borderColor: 'rgba(255, 10, 100, 1)',
                tension: 0.1,
                pointBackgroundColor: 'rgba(255, 10, 100, 1)',
                pointRadius: 5,
            },
            {
                label: 'Lama Pengerjaan',
                data: [
                    props.waktupengerjaan_kolom_1,
                    props.waktupengerjaan_kolom_2,
                    props.waktupengerjaan_kolom_3,
                    props.waktupengerjaan_kolom_4,
                    props.waktupengerjaan_kolom_5,
                ],
                fill: false,
                borderColor: 'rgba(100, 10, 255, 1)',
                tension: 0.1,
                pointBackgroundColor: 'rgba(100, 10, 255, 1)',
                pointRadius: 5,
            },
        ]
    };

    // Menyusun data chart
    const chartData: any = {
        labels: label,
        datasets: dataset.datasets,
    };

    // Opsi konfigurasi untuk grafik
    const optionsData: any = {
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
                    label: (context: any) => {
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

    return (
        <React.StrictMode>
            <div className={`props.textColor`}>
                <h4 className='hidden'>Grafik Hasil Psikotest Kecermatan</h4>
                <Line data={chartData} options={optionsData} />
            </div>
        </React.StrictMode>
    );
}

// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara
import axios from 'axios';
import * as React from 'react';
import PropTypes from 'prop-types';
import Button from '@mui/material/Button';
import TextField from '@mui/material/TextField';
import CircularProgress from '@mui/material/CircularProgress';

import RestartAltIcon from '@mui/icons-material/RestartAlt';
import SearchIcon from '@mui/icons-material/Search';

import { Line } from 'react-chartjs-2';
import { Chart as ChartJS, CategoryScale, LinearScale, LineElement, PointElement, Title, Tooltip, Legend } from 'chart.js';
// Registrasi komponen Chart.js
ChartJS.register(CategoryScale, LinearScale, LineElement, PointElement, Title, Tooltip, Legend);

import DOMPurify from 'dompurify';

interface GrafikHasilPsikotestKecermatan_Peserta {
    // Define any props you expect to pass to the component here
    // For example: title?: string;
    peserta_id: string;
    no_identitas: string;
    email: string;
    token: string;
    unique: string;
    pat: string;
    rtk: string;
    textColor: string;
    borderColor: string;
    data: any;
}

GrafikHasilPsikotestKecermatan_Peserta.propTypes = {
    peserta_id: PropTypes.string,
    no_identitas: PropTypes.string,
    email: PropTypes.string,
    token: PropTypes.string,
    unique: PropTypes.string,
    pat: PropTypes.string,
    rtk: PropTypes.string,
    textColor: PropTypes.string,
    borderColor: PropTypes.string,
    data: PropTypes.any,
};

export default function GrafikHasilPsikotestKecermatan_Peserta(props: GrafikHasilPsikotestKecermatan_Peserta) {
    const [dataLoading, setDataLoading] = React.useState(false);
    const hasiltes: any = props.data;
    console.info(hasiltes);

    const labels: any = hasiltes.map((item: any) => item.tgl_ujian);
    console.info('labels', labels);

    const dataset_nilai: any = {
        labels: labels,
        datasets: [
            {
                label: 'Hasil Nilai Kolom 1',
                data: hasiltes.map((item: any) => item.hasilnilai_kolom_1),
                borderColor: 'rgba(255, 0, 0, 1)',
                backgroundColor: 'rgba(255, 0, 0, 0.2)',
                fill: false,
                tension: 0.3
            },
            {
                label: 'Hasil Nilai Kolom 2',
                data: hasiltes.map((item: any) => item.hasilnilai_kolom_2),
                borderColor: 'rgba(0, 162, 0, 1)',
                backgroundColor: 'rgba(0, 162, 0, 0.2)',
                fill: false,
                tension: 0.3
            },
            {
                label: 'Hasil Nilai Kolom 3',
                data: hasiltes.map((item: any) => item.hasilnilai_kolom_3),
                borderColor: 'rgba(0, 0, 255, 1)',
                backgroundColor: 'rgba(0, 0, 255, 0.2)',
                fill: false,
                tension: 0.3
            },
            {
                label: 'Hasil Nilai Kolom 4',
                data: hasiltes.map((item: any) => item.hasilnilai_kolom_4),
                borderColor: 'rgba(255, 255, 0, 1)',
                backgroundColor: 'rgba(255, 255, 0, 0.2)',
                fill: false,
                tension: 0.3
            },
            {
                label: 'Hasil Nilai Kolom 5',
                data: hasiltes.map((item: any) => item.hasilnilai_kolom_5),
                borderColor: 'rgba(255, 0, 255, 1)',
                backgroundColor: 'rgba(255, 0, 255, 0.2)',
                fill: false,
                tension: 0.3
            },
        ],
    };
    console.info('dataset_nilai', dataset_nilai);

    const dataset_waktu: any = {
        labels: labels,
        datasets: [
            {
                label: 'Lama Pengerjaan Kolom 1',
                data: hasiltes.map((item: any) => item.waktupengerjaan_kolom_1),
                borderColor: 'rgba(255, 0, 0, 1)',
                backgroundColor: 'rgba(255, 0, 0, 0.2)',
                fill: false,
                tension: 0.3
            },
            {
                label: 'Lama Pengerjaan Kolom 2',
                data: hasiltes.map((item: any) => item.waktupengerjaan_kolom_2),
                borderColor: 'rgba(0, 162, 0, 1)',
                backgroundColor: 'rgba(0, 162, 0, 0.2)',
                fill: false,
                tension: 0.3
            },
            {
                label: 'Lama Pengerjaan Kolom 3',
                data: hasiltes.map((item: any) => item.waktupengerjaan_kolom_3),
                borderColor: 'rgba(0, 0, 255, 1)',
                backgroundColor: 'rgba(0, 0, 255, 0.2)',
                fill: false,
                tension: 0.3
            },
            {
                label: 'Lama Pengerjaan Kolom 4',
                data: hasiltes.map((item: any) => item.waktupengerjaan_kolom_4),
                borderColor: 'rgba(255, 255, 0, 1)',
                backgroundColor: 'rgba(255, 255, 0, 0.2)',
                fill: false,
                tension: 0.3
            },
            {
                label: 'Lama Pengerjaan Kolom 5',
                data: hasiltes.map((item: any) => item.waktupengerjaan_kolom_5),
                borderColor: 'rgba(255, 0, 255, 1)',
                backgroundColor: 'rgba(255, 0, 255, 0.2)',
                fill: false,
                tension: 0.3
            },
        ],
    };
    console.info('dataset_waktu', dataset_waktu);

    const options_nilai: any = {
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
                    label: function(context: any) {
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
    console.info('options_nilai', options_nilai);

    const options_waktu: any = {
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
                    label: function(context: any) {
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
    console.info('options_waktu', options_waktu);

    const chartDataNilai: any = {
        labels: labels,
        datasets: dataset_nilai,
    };
    console.info('chartDataNilai', chartDataNilai);

    const chartDataWaktu: any = {
        labels: labels,
        datasets: dataset_waktu,
    };
    console.info('chartDataWaktu', chartDataWaktu);

    return (
        <React.StrictMode>
            <div className={`${props.textColor}`}>
                {/**!grafik error?!**/}
                {parseInt(props.data.length) > 0 ? (
                    <div className='bg-slate-50 p-2 rounded-md text-black'>
                        <Line data={chartDataNilai} options={options_nilai} />
                    </div>
                ) : (
                    dataLoading ? (
                        <div className='text-center font-bold'>
                            Sedang Memuat Data..<br/>
                            Mohon Harap Tunggu...<br/>
                            <CircularProgress color="info" size={50} />
                        </div>
                    ) : (
                        <div>Click Tombol "Batal & Refresh" terlebih dahulu untuk mendapatkan data ini..</div>
                    )
                )}
            </div>
        </React.StrictMode>
    );
}

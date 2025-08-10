// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
'use client';
import Layout from '@/Layouts/layout.tsx';
import axios from 'axios';
import * as React from 'react';
import PropTypes from 'prop-types';
import CircularProgress from '@mui/material/CircularProgress';

import Appbarku from '@/components/Appbarku.tsx';
import NavBreadcrumb from '@/components/NavBreadcrumb.tsx';
import Footer from '@/components/Footer.tsx';
import TabelHasilPsikotestKecermatan from '@/components/peserta/TabelHasilPsikotestKecermatan.tsx';
import GrafikHasilPsikotestKecermatan from '@/components/peserta/GrafikHasilPsikotestKecermatan.tsx';

import DOMPurify from 'dompurify';

interface PesertaPsikotestKecermatanHasil {
    // Define any props you expect to pass to the component here
    // For example: title?: string;
    data: any;
    no_identitas: string;
    tgl_tes: string;
    nama: string;
    pat: string;
    rtk: string;
    email: string;
    id: string;
}

PesertaPsikotestKecermatanHasil.propTypes = {
    data: PropTypes.any,
    no_identitas: PropTypes.string,
    tgl_tes: PropTypes.string,
};

export default function PesertaPsikotestKecermatanHasil(props: PesertaPsikotestKecermatanHasil) {
    const textColor: string|any = DOMPurify.sanitize(localStorage.getItem('text-color'));
    const textColorRGB: string|any = DOMPurify.sanitize(localStorage.getItem('text-color-rgb'));
    const borderColor: string|any = DOMPurify.sanitize(localStorage.getItem('border-color'));
    const borderColorRGB: string|any = DOMPurify.sanitize(localStorage.getItem('border-color-rgb'));
    
    const [dataPeserta, setDataPeserta] = React.useState<any>([]);
    const [dataHasiltes, setDataHasiltes] = React.useState<any>([]);
    const [loading, setLoading] = React.useState<boolean>(false);
    const paramIdentitas: number = parseInt(props.no_identitas);
    const paramTgl_tes: string = props.tgl_tes;

    const getData = async () => {
        setLoading(true); // Menandakan bahwa proses loading sedang berjalan
        try {
            setDataPeserta(props.data.peserta[0]);
            setDataHasiltes(props.data.hasiltes[0]);
        }
        catch(err) {
            console.info('Terjadi Error PesertaPsikotestKecermatanHasil-getData:', err);
        }
        setLoading(false);
    };

    // eslint-disable-next-line react-hooks/exhaustive-deps
    React.useEffect(() => {
        getData();
    }, []);

    // console.table('Data Peserta', dataPeserta);
    // console.table('Data Hasil Psikotest Kecermatan Peserta', dataHasiltes);

    const MemoAppbarku = React.memo(function Memo() {
        return(
            <Appbarku user={''} headTitle="Hasil Psikotest Kecermatan" isback={true} url={`/`} />
        );
    });

    const MemoNavBreadcrumb = React.memo(function Memo() {
        return(
            <NavBreadcrumb content={`Peserta / Psikotest / Kecermatan / Hasil`} hidden={`hidden`} />
        );
    });

    const MemoFooter = React.memo(function Memo() {
        return(
            <Footer hidden={``} otherCSS={''} />
        );
    });

    return(
        <Layout>
            <MemoAppbarku />
            <MemoNavBreadcrumb />
            <div className={`p-4 text-${textColor}`}>
                <h1 className='hidden'>Halaman Hasil Psikotest Kecermatan Peserta {dataPeserta.nama}</h1>
                {loading ? (
                    <h2 className='text-center'>
                        <p><span className='font-bold text-2lg'>
                            Sedang memuat data... Mohon Harap Tunggu...
                        </span></p>
                        <CircularProgress color="info" size={50} />
                    </h2>
                ) : (
                    <div>
                        <div className='p-0 border-b-2 border-black mb-5 pb-4'>
                            <h2 className='p-0 font-bold underline text-lg'>Profil Peserta</h2>
                            <p className='p-0'>
                                <span className="font-bold">Nama :</span> {dataPeserta.nama}
                            </p>
                            <p className='p-0'>
                                <span className="font-bold">No. Identitas :</span> {paramIdentitas}
                            </p>
                            <p className='p-0'>
                                <span className="font-bold">Email :</span> {dataPeserta.email}
                            </p>
                            <p className='p-0'>
                                <span className="font-bold">Tanggal Lahir :</span> {dataPeserta.tgl_lahir}
                            </p>
                            <p className='p-0'>
                                <span className="font-bold">Usia :</span> {dataPeserta.usia}
                            </p>
                            <p className='p-0'>
                                <span className="font-bold">Asal : </span> {dataPeserta.asal}
                            </p>
                            <p className='p-0'>
                                <span className="font-bold">Tanggal Tes : </span> {dataHasiltes.tgl_ujian}
                            </p>
                        </div>
                        <h3 className='hidden'>Peserta : {dataPeserta.nama}</h3>
                        <div className={`mt-4`}>
                            <TabelHasilPsikotestKecermatan
                                    hasilnilai_kolom_1={dataHasiltes.hasilnilai_kolom_1}
                                    hasilnilai_kolom_2={dataHasiltes.hasilnilai_kolom_2}
                                    hasilnilai_kolom_3={dataHasiltes.hasilnilai_kolom_3}
                                    hasilnilai_kolom_4={dataHasiltes.hasilnilai_kolom_4}
                                    hasilnilai_kolom_5={dataHasiltes.hasilnilai_kolom_5}
                                    waktupengerjaan_kolom_1={dataHasiltes.waktupengerjaan_kolom_1}
                                    waktupengerjaan_kolom_2={dataHasiltes.waktupengerjaan_kolom_2}
                                    waktupengerjaan_kolom_3={dataHasiltes.waktupengerjaan_kolom_3}
                                    waktupengerjaan_kolom_4={dataHasiltes.waktupengerjaan_kolom_4}
                                    waktupengerjaan_kolom_5={dataHasiltes.waktupengerjaan_kolom_5}
                                />
                        </div>
                        <div className={`mt-4 p-2 rounded-lg bg-white shadow-xl`}>
                            <GrafikHasilPsikotestKecermatan
                                tgl_tes={paramTgl_tes}
                                hasilnilai_kolom_1={dataHasiltes.hasilnilai_kolom_1}
                                hasilnilai_kolom_2={dataHasiltes.hasilnilai_kolom_2}
                                hasilnilai_kolom_3={dataHasiltes.hasilnilai_kolom_3}
                                hasilnilai_kolom_4={dataHasiltes.hasilnilai_kolom_4}
                                hasilnilai_kolom_5={dataHasiltes.hasilnilai_kolom_5}
                                waktupengerjaan_kolom_1={dataHasiltes.waktupengerjaan_kolom_1}
                                waktupengerjaan_kolom_2={dataHasiltes.waktupengerjaan_kolom_2}
                                waktupengerjaan_kolom_3={dataHasiltes.waktupengerjaan_kolom_3}
                                waktupengerjaan_kolom_4={dataHasiltes.waktupengerjaan_kolom_4}
                                waktupengerjaan_kolom_5={dataHasiltes.waktupengerjaan_kolom_5}
                            />
                        </div>
                    </div>
                )}
            </div>
            <MemoFooter />
        </Layout>
    );
}
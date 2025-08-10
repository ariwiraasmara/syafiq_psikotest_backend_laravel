// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
'use client';
import Layoutadmin from '@/Layouts/Layoutadmin';
import axios from 'axios';
import * as React from 'react';
import CircularProgress from '@mui/material/CircularProgress';

import Myhelmet from '@/components/Myhelmet.jsx';
import Appbarku from '@/components/Appbarku.jsx';
import NavBreadcrumb from '@/components/NavBreadcrumb.jsx';
import ListPeserta from '@/components/admin/ListPeserta.jsx';
import Footer from '@/components/Footer.jsx';

import { readable, random } from '@/libraries/myfunction';
import DOMPurify from 'dompurify';

export default function AdminDashboard(props) {
    const textColor = DOMPurify.sanitize(localStorage.getItem('text-color'));
    const textColorRGB = DOMPurify.sanitize(localStorage.getItem('text-color-rgb'));
    const borderColor = DOMPurify.sanitize(localStorage.getItem('border-color'));
    const borderColorRGB = DOMPurify.sanitize(localStorage.getItem('border-color-rgb'));
    const [nama, setNama] = React.useState('');
    const [loading, setLoading] = React.useState(false);


    // eslint-disable-next-line react-hooks/exhaustive-deps
    React.useEffect(() => {
        setNama(DOMPurify.sanitize(localStorage.getItem('nama')));
    }, [nama]);
    // console.log(data);
    console.table('Data Peserta Terbaru', props.data);

    if(loading) {
        return (
            <h2 className={`text-center p-8 font-bold text-2lg text-${textColor}`}>
                <p>Sedang memuat data...<br/></p>
                <p>Mohon Harap Tunggu...</p>
                <CircularProgress color="info" size={50} />
            </h2>
        );
    }

    const MemoHelmet = React.memo(function Memo() {
        return(
            <Myhelmet
                title={props.title}
                pathURL={props.pathURL}
                robots={props.robots}
                onetime={props.onetime}
            />
        );
    });

    const MemoAppbarku = React.memo(function Memo() {
        return(
            <Appbarku headTitle="Dashboard" />
        );
    });

    const MemoNavBreadcrumb = React.memo(function Memo() {
        return(
            <NavBreadcrumb content={`Admin / Dashboard`} hidden={`hidden`} />
        );
    });

    const MemoFooter = React.memo(function Memo() {
        return(
            <Footer hidden={`hidden`} />
        );
    });

    return (
        <>
            <Layoutadmin>
                <MemoHelmet />
                <MemoAppbarku />
                <MemoNavBreadcrumb />
                <div className={`p-4 mb-14 text-${textColor}`}>
                    <div>
                        <h1 className="hidden">Halaman Dashboard | Admin</h1>
                        <h2 className={`text-xl font-bold`}>Selamat Datang, {nama}</h2>
                    </div>
                    <div className="mt-4">
                        <h2 className="font-bold">Daftar 10 Peserta Tes Psikotest Terbaru</h2>
                        {loading ? (
                            <h2 className={`text-center ${textColor}`}>
                                <p><span className='font-bold text-2lg'>
                                    Sedang memuat data... Mohon Harap Tunggu...
                                </span></p>
                                <CircularProgress color="info" size={50} />
                            </h2>
                        ) : (
                            <ListPeserta listpeserta={props.data} isLatest={true} textColor={textColor} borderColor={borderColor} />
                        )}
                    </div>
                </div>
                <MemoFooter />
            </Layoutadmin>
        </>
    )
}
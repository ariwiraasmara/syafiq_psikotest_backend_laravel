// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
'use client';
import Layoutadmin from '@/Layouts/Layoutadmin.tsx';
import axios from 'axios';
import * as React from 'react';
import PropTypes from 'prop-types';
import CircularProgress from '@mui/material/CircularProgress';

import Appbarku from '@/components/Appbarku.tsx';
import NavBreadcrumb from '@/components/NavBreadcrumb.tsx';
import ListPeserta from '@/components/admin/ListPeserta.tsx';
import Footer from '@/components/Footer.tsx';

import DOMPurify from 'dompurify';

interface AdminDashboard {
    // Define any props you expect to pass to the component here
    // For example: title?: string;
    title : string;
    token: string;
    unique : string;
    nama : string;
    data : any;
}

AdminDashboard.propTypes = {
    title : PropTypes.string,
    token : PropTypes.string,
    unique : PropTypes.string,
    nama : PropTypes.string,
    data : PropTypes.any,
};

export default function AdminDashboard(props: AdminDashboard) {
    const textColor: string|any = DOMPurify.sanitize(localStorage.getItem('text-color'));
    const textColorRGB: string|any = DOMPurify.sanitize(localStorage.getItem('text-color-rgb'));
    const borderColor: string|any = DOMPurify.sanitize(localStorage.getItem('border-color'));
    const borderColorRGB: string|any = DOMPurify.sanitize(localStorage.getItem('border-color-rgb'));
    
    const [nama, setNama] = React.useState<string>('');
    const [loading, setLoading] = React.useState<boolean>(false);

    // eslint-disable-next-line react-hooks/exhaustive-deps
    React.useEffect(() => {
        setNama(DOMPurify.sanitize(sessionStorage.getItem('nama')));
    }, [nama]);
    // console.table('Data Peserta Terbaru', props.data);

    if(loading) {
        return (
            <h2 className={`text-center p-8 font-bold text-2lg text-${textColor}`}>
                <p>Sedang memuat data...<br/></p>
                <p>Mohon Harap Tunggu...</p>
                <CircularProgress color="info" size={50} />
            </h2>
        );
    }

    const MemoAppbarku = React.memo(function Memo() {
        return(
            <Appbarku headTitle={'Dashboard'} user={props.nama} url={''} isback={false}  />
        );
    });

    const MemoNavBreadcrumb = React.memo(function Memo() {
        return(
            <NavBreadcrumb content={`Admin / Dashboard`} hidden={`hidden`} />
        );
    });

    const MemoFooter = React.memo(function Memo() {
        return(
            <Footer hidden={`hidden`} otherCSS={''} />
        );
    });

    return (
        <>
            <Layoutadmin navvar={1}>
                <MemoAppbarku />
                <MemoNavBreadcrumb />
                <div className={`p-4 mb-14 text-${textColor}`}>
                    <div>
                        <h1 className="hidden">Halaman Dashboard | Admin</h1>
                        <h2 className={`text-xl font-bold`}>Selamat Datang, {props.nama}</h2>
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
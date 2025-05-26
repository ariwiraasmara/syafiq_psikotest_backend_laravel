// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
'use client';
import Layoutadmin from '@/Layouts/Layoutadmin.tsx';
import axios from 'axios';
import * as React from 'react';
import PropTypes from 'prop-types';
import Swal from 'sweetalert2';

import Fab from '@mui/material/Fab';
import Link from '@mui/material/Link';
import CircularProgress from '@mui/material/CircularProgress';

import AddIcon from '@mui/icons-material/Add';
import EditIcon from '@mui/icons-material/Edit';
import DeleteIcon from '@mui/icons-material/Delete';

import Appbarku from '@/components/Appbarku.tsx';
import NavBreadcrumb from '@/components/NavBreadcrumb.tsx';
import Footer from '@/components/Footer.tsx';

import DOMPurify from 'dompurify';
import validator from 'validator';

interface AdminPsikotestKecermatan {
    // Define any props you expect to pass to the component here
    // For example: title?: string;
    title: string;
    token: string;
    unique: string;
    nama: string;
    email: string;
    pat: string;
    rtk: string;
}

AdminPsikotestKecermatan.propTypes = {
    title: PropTypes.string,
    token: PropTypes.string,
    unique: PropTypes.string,
    nama: PropTypes.string,
    email: PropTypes.string,
    pat: PropTypes.string,
    rtk: PropTypes.string,
};

export default function AdminPsikotestKecermatan(props: AdminPsikotestKecermatan) {
    const textColor: string|any = DOMPurify.sanitize(localStorage.getItem('text-color'));
    const textColorRGB: string|any = DOMPurify.sanitize(localStorage.getItem('text-color-rgb'));
    const borderColor: string|any = DOMPurify.sanitize(localStorage.getItem('border-color'));
    const borderColorRGB: string|any = DOMPurify.sanitize(localStorage.getItem('border-color-rgb'));
    
    const [loading, setLoading] = React.useState(false);
    const [data, setData] = React.useState<any>([]);

    const linkStyle = {
        color: textColorRGB
    }

    const getData = async () => {
        setLoading(true);
        try {
            const token: string = props.token;
            const pat: string = props.pat;
            const rtk: string = props.rtk;
            const csrfToken = await axios.get(`/sanctum/csrf-cookie`, {
                withCredentials: true,  // Mengirimkan cookie dalam permintaan
            });
            const response = await axios.get(`/api/kecermatan-kolompertanyaan`, {
                withCredentials: true,  // Mengirimkan cookie dalam permintaan
                headers: {
                    'Content-Type': 'application/json',
                    'XSRF-TOKEN': csrfToken,
                    'islogin' : DOMPurify.sanitize(localStorage.getItem('islogin')),
                    'isadmin' : DOMPurify.sanitize(localStorage.getItem('isadmin')),
                    'Authorization': `Bearer ${pat}`,
                    'remember-token': rtk,
                    'tokenlogin': props.unique,
                    'email' : props.email,
                    '--unique--': 'I am unique!',
                    'isvalid': 'VALID!',
                    'isallowed': true,
                    'key': 'key',
                    'values': 'values',
                    'isdumb': 'no',
                    'challenger': 'of course',
                    'pranked': 'absolutely'
                }
            });
            // console.info('response', response);
            if(response.data.data !== null) setData(response.data.data);
            else setData(null);
        } catch (err) {
            console.info('Terjadi Error PsikotestKecermatan-getData', err);
        }
        setLoading(false);
    }

    // eslint-disable-next-line react-hooks/exhaustive-deps
    React.useEffect(() => {
        getData();
    }, []);
    // console.table('tabel psikotest kecermatan', data);

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
            <Appbarku user={props.nama} headTitle="Psikotest Kecermatan" isback={true} url={`/admin/psikotest`} />
        );
    });

    const MemoNavBreadcrumb = React.memo(function Memo() {
        return(
            <NavBreadcrumb content={`Admin / Psikotest / Kecermatan`} hidden={`hidden`} />
        );
    });

    const MemoFooter = React.memo(function Memo() {
        return(
            <Footer hidden={`hidden`} otherCSS={''} />
        );
    });

    const onDetil = (id: number) => {
        setLoading(true);
        // sessionStorage.setItem('admin_psikotest_kecermatan_id', DOMPurify.sanitize(id));
        window.location.href = `/admin/psikotest/kecermatan/detil/1`;
    }

    const toAdd = (e: any) => {
        e.preventDefault();
        setLoading(true);
        window.location.href = `/admin/psikotest/kecermatan-baru`;
    }

    // const toEdit = (e, id, kolom_x, nilai_a, nilai_b, nilai_c, nilai_d, nilai_e) => {
    const toEdit = (e: any, id: number) => {
        e.preventDefault()
        setLoading(true);
        // sessionStorage.setItem('admin_psikotest_kecermatan_id', DOMPurify.sanitize(id));
        // sessionStorage.setItem('admin_psikotest_kecermatan_kolom_x', DOMPurify.sanitize(kolom_x));
        // sessionStorage.setItem('admin_psikotest_kecermatan_nilai_A', DOMPurify.sanitize(nilai_a));
        // sessionStorage.setItem('admin_psikotest_kecermatan_nilai_B', DOMPurify.sanitize(nilai_b));
        // sessionStorage.setItem('admin_psikotest_kecermatan_nilai_C', DOMPurify.sanitize(nilai_c));
        // sessionStorage.setItem('admin_psikotest_kecermatan_nilai_D', DOMPurify.sanitize(nilai_d));
        // sessionStorage.setItem('admin_psikotest_kecermatan_nilai_E', DOMPurify.sanitize(nilai_e));
        window.location.href = `/admin/psikotest/kecermatan-edit/${id}`;
    }

    const fDelete = async (e: any, id: number, kolom_x: string) => {
        e.preventDefault();
        if(validator.isInt(id.toString(), {min: 1, gt: 0})) {
            Swal.fire({
                title: "Anda yakin ingin menghapus data Psikotest Kecermatan ini?",
                html: `Semua data <b>${kolom_x}</b> yang ada didalamnya juga akan terhapus!`,
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: "Ya",
                cancelButtonText: "Batalkan",
                icon: "warning",
                showLoaderOnConfirm: true,
                preConfirm: async () => {
                    try {
                        const token: string = props.token;
                        const pat: string = props.pat;
                        const rtk: string = props.rtk;
                        axios.defaults.withCredentials = true;
                        axios.defaults.withXSRFToken = true;
                        const csrfToken = await axios.get(`/sanctum/csrf-cookie`);
                        await axios.delete(`/api/kecermatan/kolompertanyaan/${DOMPurify.sanitize(id)}`, {
                            withCredentials: true,
                            headers: {
                                'Content-Type': 'application/json',
                                'XSRF-TOKEN': csrfToken,
                                'islogin' : DOMPurify.sanitize(localStorage.getItem('islogin')),
                                'isadmin' : DOMPurify.sanitize(localStorage.getItem('isadmin')),
                                'Authorization': `Bearer ${pat}`,
                                'remember-token': rtk,
                                'tokenlogin': props.unique,
                                'email' : props.email,
                                '--unique--': 'I am unique!',
                                'isvalid': 'VALID!',
                                'isallowed': true,
                                'key': 'key',
                                'values': 'values',
                                'isdumb': 'no',
                                'challenger': 'of course',
                                'pranked': 'absolutely'
                            }
                        });
                        // Hapus item dari state variabels setelah sukses
                        setData((prev: any) => prev.filter((item: any) => item.id !== id));
                    } catch (error) {
                        console.info('Terjadi Error AdminPsikotestKecermatan-fDelete', error);
                        // Swal.showValidationMessage(`Terjadi Error AdminPsikotestKecermatan-fDelete: ${error}`);
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Terhapus!",
                        text: "Data Telah Berhasil Dihapus",
                        icon: "success"
                    });
                }
            });
        }
        else {
            alert('Invalid Credentials!');
        }
    };

    return (
        <Layoutadmin navvar={3}>
            <MemoAppbarku />
            <MemoNavBreadcrumb />
            <div className={`p-4 mb-14 text-${textColor}`}>
                <h1 className='hidden'>Halaman Psikotest Kecermatan | Admin</h1>
                {loading ? (
                    <h2 className='text-center'>
                        <p>
                            <span className='font-bold text-2lg'>
                                Sedang memuat data... Mohon Harap Tunggu...
                            </span>
                        </p>
                        <CircularProgress color="info" size={50} />
                    </h2>
                ) : (
                    data ? (
                        data.map((data: any, index: number) => (
                            <div className={`bg-slate-50 border-b-2 p-3 rounded-t-md mt-2 text-${textColor} border-${borderColor}`} key={index}>
                                <div className="static flex flex-row justify-between">
                                    <Link rel='follow' title={`Psikotest Kecermatan ${data.kolom_x}`} onClick={() => onDetil(data.id)} href={`/admin/psikotest/kecermatan/detil/1`} key={index}>
                                        <div className={`order-first text-${textColor}`}>
                                            <h2>{data.kolom_x}</h2>
                                        </div>
                                    </Link>
                                    <div className="order-last">
                                        <span className='mr-6'>
                                            <Link
                                                sx={linkStyle}
                                                rel='nofollow'
                                                title={`Edit Data`}
                                                // onClick={(e) => toEdit(e, data.id, data.kolom_x, data.nilai_A, data.nilai_B, data.nilai_C, data.nilai_D, data.nilai_E)}
                                                onClick={(e: any) => toEdit(e, parseInt(data.id))}
                                                href="#"
                                            >
                                                <EditIcon />
                                            </Link>
                                        </span>
                                        <Link
                                            sx={linkStyle}
                                            rel='nofollow'
                                            title={`Delete Data`}
                                            onClick={(e) => fDelete(e, parseInt(data.id), data.kolom_x)}
                                            href="#"
                                        >
                                            <DeleteIcon />
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        ))
                    ) : (
                        <h2 className='font-bold text-center text-lg'>
                            Belum Ada Data<br/>
                            Data Kosong!
                        </h2>
                    )
                )}
            </div>
            <Fab sx={{
                position: 'absolute',
                bottom: '13%',
                right: '3%',
            }} color="primary" aria-label="add" rel='nofollow' title='Tambah Data Baru' href='#' onClick={(e) => toAdd(e)} >
                <AddIcon />
            </Fab>
            <MemoFooter />
        </Layoutadmin>
    )
}
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
'use client';
import Layoutadmin from '@/Layouts/Layoutadmin.jsx';
import axios from 'axios';
import * as React from 'react';
import Swal from 'sweetalert2';

import Fab from '@mui/material/Fab';
import Link from '@mui/material/Link';
import CircularProgress from '@mui/material/CircularProgress';

import AddIcon from '@mui/icons-material/Add';
import EditIcon from '@mui/icons-material/Edit';
import DeleteIcon from '@mui/icons-material/Delete';

import Myhelmet from '@/components/Myhelmet.jsx';
import Appbarku from '@/components/Appbarku.jsx';
import NavBreadcrumb from '@/components/NavBreadcrumb.jsx';
import Footer from '@/components/Footer.jsx';

import { readable, random } from '@/libraries/myfunction';
import DOMPurify from 'dompurify';
import validator from 'validator';
export default function PsikotestKecermatan(props) {
    const textColor = DOMPurify.sanitize(localStorage.getItem('text-color'));
    const textColorRGB = DOMPurify.sanitize(localStorage.getItem('text-color-rgb'));
    const borderColor = DOMPurify.sanitize(localStorage.getItem('border-color'));
    const borderColorRGB = DOMPurify.sanitize(localStorage.getItem('border-color-rgb'));
    const [loading, setLoading] = React.useState(false);
    const [data, setData] = React.useState([]);

    const linkStyle = {
        color: textColorRGB
    }

    const getData = async () => {
        setLoading(true);
        try {
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
                    'Authorization': `Bearer ${DOMPurify.sanitize(localStorage.getItem('pat'))}`,
                    'remember-token': DOMPurify.sanitize(localStorage.getItem('remember-token')),
                    'tokenlogin': random('combwisp', 50),
                    'email' : DOMPurify.sanitize(localStorage.getItem('email')),
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
            setData(response.data.data);
        } catch (err) {
            console.info('Terjadi Error PsikotestKecermatan-getData', err);
        }
        setLoading(false);
    }

    // eslint-disable-next-line react-hooks/exhaustive-deps
    React.useEffect(() => {
        getData();
    }, []);

    console.table('tabel psikotest kecermatan', data);

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
            <Appbarku headTitle="Psikotest Kecermatan" isback={true} url={`/admin/psikotest`} />
        );
    });

    const MemoNavBreadcrumb = React.memo(function Memo() {
        return(
            <NavBreadcrumb content={`Admin / Psikotest / Kecermatan`} hidden={`hidden`} />
        );
    });

    const MemoFooter = React.memo(function Memo() {
        return(
            <Footer hidden={`hidden`} />
        );
    });

    const onDetil = (id) => {
        setLoading(true);
        sessionStorage.setItem('admin_psikotest_kecermatan_id', DOMPurify.sanitize(id));
        // router.push(`/admin/psikotest/kecermatan/detil?page=1`);
        window.location.href = `/admin/psikotest/kecermatan/detil/1`;
    }

    const toAdd = (e) => {
        e.preventDefault();
        setLoading(true);
        // router.push(`/admin/psikotest/kecermatan/baru`);
        window.location.href = `/admin/psikotest/kecermatan-baru`;
    }

    const toEdit = (e, id, kolom_x, nilai_a, nilai_b, nilai_c, nilai_d, nilai_e) => {
        e.preventDefault()
        setLoading(true);
        sessionStorage.setItem('admin_psikotest_kecermatan_id', DOMPurify.sanitize(id));
        sessionStorage.setItem('admin_psikotest_kecermatan_kolom_x', DOMPurify.sanitize(kolom_x));
        sessionStorage.setItem('admin_psikotest_kecermatan_nilai_A', DOMPurify.sanitize(nilai_a));
        sessionStorage.setItem('admin_psikotest_kecermatan_nilai_B', DOMPurify.sanitize(nilai_b));
        sessionStorage.setItem('admin_psikotest_kecermatan_nilai_C', DOMPurify.sanitize(nilai_c));
        sessionStorage.setItem('admin_psikotest_kecermatan_nilai_D', DOMPurify.sanitize(nilai_d));
        sessionStorage.setItem('admin_psikotest_kecermatan_nilai_E', DOMPurify.sanitize(nilai_e));
        // router.push(`/admin/psikotest/kecermatan/edit`);
        window.location.href = `/admin/psikotest/kecermatan-edit`;
    }

    const fDelete = async (e, id, kolom_x) => {
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
                                'Authorization': `Bearer ${DOMPurify.sanitize(localStorage.getItem('pat'))}`,
                                'remember-token': DOMPurify.sanitize(localStorage.getItem('remember-token')),
                                'tokenlogin': random('combwisp', 50),
                                'email' : DOMPurify.sanitize(localStorage.getItem('email')),
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
                        setData((prev) => prev.filter((item) => item.id !== id));
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
    <>
        <Layoutadmin>
            <MemoHelmet />
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
                        data.map((data, index) => (
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
                                                onClick={(e) => toEdit(e, data.id, data.kolom_x, data.nilai_A, data.nilai_B, data.nilai_C, data.nilai_D, data.nilai_E)}
                                                href="#"
                                            >
                                                <EditIcon />
                                            </Link>
                                        </span>
                                        <Link
                                            sx={linkStyle}
                                            rel='nofollow'
                                            title={`Delete Data`}
                                            onClick={(e) => fDelete(e, data.id, data.kolom_x)}
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
    </>
    )
}
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
'use client';
import Layoutadmindetil from '@/Layouts/Layoutadmindetil.tsx';
import axios from 'axios';
import * as React from 'react';
import PropTypes from 'prop-types';
import Box from '@mui/material/Box';
import Button from '@mui/material/Button';
import TextField from '@mui/material/TextField';
import CircularProgress from '@mui/material/CircularProgress';

import Appbarku from '@/components/Appbarku.tsx';
import NavBreadcrumb from '@/components/NavBreadcrumb.tsx';
import Footer from '@/components/Footer.tsx';

import validator from 'validator';
import DOMPurify from 'dompurify';

interface AdminPsikotestKecermatan {
    // Define any props you expect to pass to the component here
    // For example: title?: string;
    title: string;
    token: string;
    unique: string;
    nama: string;
    pat: string;
    rtk: string;
    email: string;
    page: string;
    id: number;
    data: any;
}

AdminPsikotestKecermatan.propTypes = {
    title: PropTypes.string,
    token: PropTypes.string,
    unique: PropTypes.string,
    nama: PropTypes.string,
    pat: PropTypes.string,
    rtk: PropTypes.string,
    email: PropTypes.string,
    page: PropTypes.string,
    id: PropTypes.string,
    data: PropTypes.any,
};

export default function AdminPsikotestKecermatan(props: AdminPsikotestKecermatan) {
    const textColor: string|any = DOMPurify.sanitize(localStorage.getItem('text-color'));
    const textColorRGB: string|any = DOMPurify.sanitize(localStorage.getItem('text-color-rgb'));
    const borderColor: string|any = DOMPurify.sanitize(localStorage.getItem('border-color'));
    const borderColorRGB: string|any = DOMPurify.sanitize(localStorage.getItem('border-color-rgb'));
    
    const [loading, setLoading] = React.useState(false);
    const [nid, setNid] = React.useState(DOMPurify.sanitize(sessionStorage.getItem('admin_psikotest_kecermatan_id')));
    const [kolom_x, setKolom_x] = React.useState(DOMPurify.sanitize(sessionStorage.getItem('admin_psikotest_kecermatan_kolom_x')));
    const urlBack: string = `/admin/psikotest/kecermatan`;

    const styledTextField = {
        '& .MuiOutlinedInput-notchedOutline': {
            color: 'rgba(255, 255, 255, 1)',
            borderRadius: 3,
        },
        '& .MuiInputLabel-root.MuiInputLabel-shrink': {
            color: 'rgba(255, 255, 255, 1)',
        },
        '& .MuiOutlinedInput-input': {
            color: '#fff',
        },
        '& .MuiOutlinedInput-placeholder': {
            color: '#fff',
        },
        '&:hover .MuiOutlinedInput-notchedOutline': {
            // borderColor: 'rgba(255, 255, 255, 0.8)', // warna hover
        },
        '&:hover .MuiInputLabel-root': {
            color: '#fff', // warna hover
        },
        '& .MuiFormHelperText-root': {
            color: '#fff',  // Warna helper text
        },
        background: 'rgba(0, 0, 0, 0.6)',
        borderRadius: 3,
    }

    const styledButton = {
        borderRadius: 3
    }

    const [nilai_A, setNilai_A] = React.useState<number>(0);
    const handleChange_nilai_A = (event: any) => {
        event.preventDefault();
        setNilai_A(parseInt(DOMPurify.sanitize(event.target.value)));
    }
    
    const [nilai_B, setNilai_B] = React.useState<number>(0);
    const handleChange_nilai_B = (event: any) => {
        event.preventDefault();
        setNilai_B(parseInt(DOMPurify.sanitize(event.target.value)));
    }
    
    const [nilai_C, setNilai_C] = React.useState<number>(0);
    const handleChange_nilai_C = (event: any) => {
        event.preventDefault();
        setNilai_C(parseInt(DOMPurify.sanitize(event.target.value)));
    }
    
    const [nilai_D, setNilai_D] = React.useState<number>(0);
    const handleChange_nilai_D = (event: any) => {
        event.preventDefault();
        setNilai_D(parseInt(DOMPurify.sanitize(event.target.value)));
    }
    
    const [nilai_E, setNilai_E] = React.useState<number>(0);
    const handleChange_nilai_E = (event: any) => {
        event.preventDefault();
        setNilai_E(parseInt(DOMPurify.sanitize(event.target.value)));
    }

    const getData = async() => {
        setLoading(true);
        try {
            // setNid(sessionStorage('admin_psikotest_kecermatan_id'));
            // setKolom_x(sessionStorage('admin_psikotest_kecermatan_kolom_x'));
            // setNilai_A(DOMPurify.sanitize(sessionStorage.getItem('admin_psikotest_kecermatan_nilai_A')));
            // setNilai_B(DOMPurify.sanitize(sessionStorage.getItem('admin_psikotest_kecermatan_nilai_B')));
            // setNilai_C(DOMPurify.sanitize(sessionStorage.getItem('admin_psikotest_kecermatan_nilai_C')));
            // setNilai_D(DOMPurify.sanitize(sessionStorage.getItem('admin_psikotest_kecermatan_nilai_D')));
            // setNilai_E(DOMPurify.sanitize(sessionStorage.getItem('admin_psikotest_kecermatan_nilai_E')));
            setNilai_A(parseInt(props.data.nilai_A));
            setNilai_B(parseInt(props.data.nilai_B));
            setNilai_C(parseInt(props.data.nilai_C));
            setNilai_D(parseInt(props.data.nilai_D));
            setNilai_E(parseInt(props.data.nilai_E));
        }
        catch(err) {
            console.error('Terjadi Error Kesalahan PsikotestKecermatanEdit-getData', err);
        }
        setLoading(false);
    };

    // eslint-disable-next-line react-hooks/exhaustive-deps
    React.useEffect(() => {
        getData();
    }, []);

    if(loading) {
        return (
            <h2 className='text-center p-8'>
                <p><span className='font-bold text-2lg'>
                    Sedang memuat data... Mohon Harap Tunggu...
                </span></p>
                <CircularProgress color="info" size={50} />
            </h2>
        );
    }

    const submit = async (e: any) => {
        e.preventDefault();
        setLoading(true);
        try {
            const validNumberRange = {
                min : 1,
                max : 9
            };
            if( validator.isInt(nilai_A.toString(), validNumberRange) &&
                validator.isInt(nilai_B.toString(), validNumberRange) &&
                validator.isInt(nilai_C.toString(), validNumberRange) &&
                validator.isInt(nilai_D.toString(), validNumberRange) &&
                validator.isInt(nilai_E.toString(), validNumberRange)
            ) {
                const token: string = props.token;
                const pat: string = props.pat;
                const rtk: string = props.rtk;
                axios.defaults.withCredentials = true;
                axios.defaults.withXSRFToken = true;
                const csrfToken = await axios.get(`/sanctum/csrf-cookie`, {
                    withCredentials: true,  // Mengirimkan cookie dalam permintaan
                });
                const response = await axios.put(`/api/kecermatan/kolompertanyaan/${DOMPurify.sanitize(nid)}`, {
                    nilai_A: nilai_A,
                    nilai_B: nilai_B,
                    nilai_C: nilai_C,
                    nilai_D: nilai_D,
                    nilai_E: nilai_E,
                }, {
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
                console.log('response', response);
                if(response.data.success) {
                    window.location.href = urlBack;
                }
                else {
                    alert('Terjadi Error : Tidak Dapat Menyimpan Data!');
                }
            }
            else {
                alert('Invalid Credentials!');
            }
        }
        catch(er) {
            console.log('Terjadi Error Kesalahan PsikotestKecermatanEdit-submit', er);
        }
        setLoading(false);
    };

    const cancel = (e: any) => {
        e.preventDefault();
        try {
            // sessionStorage.removeItem('psikotest_kecermatan_id');
            // sessionStorage.removeItem('psikotest_kecermatan_kolom_x');
            // sessionStorage.removeItem('psikotest_kecermatan_nilai_A');
            // sessionStorage.removeItem('psikotest_kecermatan_nilai_B');
            // sessionStorage.removeItem('psikotest_kecermatan_nilai_C');
            // sessionStorage.removeItem('psikotest_kecermatan_nilai_D');
            // sessionStorage.removeItem('psikotest_kecermatan_nilai_E');
            window.location.href = urlBack;
        }
        catch(err) {
            console.info('Terjadi Error Kesalahan PsikotestKecermatanEdit-cancel:', err);
        }
    };
    
    const MemoAppbarku = React.memo(function Memo() {
        return(
            <Appbarku user={props.nama} headTitle="Psikotest Kecermatan Edit" isback={true} url={urlBack} />
        );
    });

    const MemoNavBreadcrumb = React.memo(function Memo() {
        return(
            <NavBreadcrumb content={`Admin / Psikotest/ Kecermatan / Edit`} hidden={`hidden`} />
        );
    });

    const MemoFooter = React.memo(function Memo() {
        return(
            <Footer hidden={`hidden`} otherCSS={''} />
        );
    });

    return(
        <Layoutadmindetil>
            <MemoNavBreadcrumb />
            <MemoAppbarku />
            <div className={`p-4 ${borderColor}`}>
                <h1 className='hidden'>Halaman Tambah Psikotest Kecermatan Baru | Admin</h1>
                <h2 className={`text-${textColor}`}>
                    <span className='font-bold'>Edit Data Kolom : {kolom_x}</span>
                </h2>
                <Box component="form"
                    sx={{ '& > :not(style)': { marginTop: 2, width: '100%' } }}
                    onSubmit={(e: any) => submit(e)}
                    noValidate
                    autoComplete="off">
                    <TextField  type="number" id="nilai_a" variant="outlined"
                                placeholder="Nilai A..." label="Nilai A..."
                                fullWidth sx={styledTextField}
                                onChange={handleChange_nilai_A}
                                defaultValue={nilai_A} />
                    <TextField  type="number" id="nilai_b" variant="outlined"
                                placeholder="Nilai B..." label="Nilai B..."
                                fullWidth sx={styledTextField}
                                onChange={handleChange_nilai_B}
                                defaultValue={nilai_B} />
                    <TextField  type="number" id="nilai_c" variant="outlined"
                                placeholder="Nilai C..." label="Nilai C..."
                                fullWidth sx={styledTextField}
                                onChange={handleChange_nilai_C}
                                defaultValue={nilai_C} />
                    <TextField  type="number" id="nilai_d" variant="outlined"
                                placeholder="Nilai D..." label="Nilai D..."
                                fullWidth sx={styledTextField}
                                onChange={handleChange_nilai_D}
                                defaultValue={nilai_D} />
                    <TextField  type="number" id="nilai_e" variant="outlined"
                                placeholder="Nilai E..." label="Nilai E..."
                                fullWidth sx={styledTextField}
                                onChange={handleChange_nilai_E}
                                defaultValue={nilai_E} />
                    <Box>
                        <Button variant="contained" size="large" fullWidth color="primary" type="submit" sx={styledButton}>
                            Simpan
                        </Button>
                    </Box>
                    <Box>
                        <Button variant="contained" size="large" fullWidth color="secondary" onClick={(e: any) => cancel(e)} rel='follow' title='Kembali' href={urlBack} type="button" sx={styledButton}>
                            Batal
                        </Button>
                    </Box>
                </Box>
            </div>
            <MemoFooter />
        </Layoutadmindetil>
    );
}
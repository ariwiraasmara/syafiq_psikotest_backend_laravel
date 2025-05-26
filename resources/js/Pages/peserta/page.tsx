// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
'use client';
import './style.css';
import Layout from '@/Layouts/layout.tsx';
import axios from 'axios';
import * as React from 'react';
import PropTypes from 'prop-types';
import Box from '@mui/material/Box';
import Button from '@mui/material/Button';
import TextField from '@mui/material/TextField';
import Link from '@mui/material/Link';
import CircularProgress from '@mui/material/CircularProgress';
import InputAdornment from '@mui/material/InputAdornment';

import NavBreadcrumb from '@/components/NavBreadcrumb.tsx';
import Footer from '@/components/Footer.tsx';

import Cookies from 'js-cookie';
import validator from 'validator';
import DOMPurify from 'dompurify';

interface Peserta {
    // Define any props you expect to pass to the component here
    // For example: title?: string;
    title: string;
    token: string;
    unique: string;
    path: string;
    domain: string;
}

Peserta.propTypes = {
    title: PropTypes.string,
    token: PropTypes.string,
    unique: PropTypes.string,
    path: PropTypes.string,
    domain: PropTypes.string,
};

export default function Peserta(props: Peserta) {
    const textColor: string|any = DOMPurify.sanitize(localStorage.getItem('text-color'));
    const textColorRGB: string|any = DOMPurify.sanitize(localStorage.getItem('text-color-rgb'));
    const borderColor: string|any = DOMPurify.sanitize(localStorage.getItem('border-color'));
    const borderColorRGB: string|any = DOMPurify.sanitize(localStorage.getItem('border-color-rgb'));
    
    const [loading, setLoading] = React.useState<boolean>(false);
    const [tgl_tes, setTgl_tes] = React.useState<string>('');
    const [datex, isDatex] = React.useState<boolean>(false);
    const [sesiPsikotestKecermatan, setSesiPsikotestKecermatan] = React.useState(0);
    const [isSession, setIsSession] = React.useState<boolean>(false);

    const getDate = new Date();
    const year = getDate.getFullYear();
    const month = getDate.getMonth() + 1;
    const date = getDate.getDate();
    const today = `${year}-${month}-${date}`;

    const [nama, setNama] = React.useState<string>('');
    const [no_identitas, setNo_identitas] = React.useState<string>('');
    const [email, setEmail] = React.useState<string>('');
    const [tgl_lahir, setTgl_lahir] = React.useState<string>('');
    const [asal, setAsal] = React.useState<string>('');

    const styledTextField: any = {
        '& .MuiOutlinedInput-notchedOutline': {
            color: '#fff',
            borderRadius: 3,
        },
        '& .MuiInputLabel-root.MuiInputLabel-shrink': {
            color: '#fff',
        },
        '& .MuiOutlinedInput-input': {
            color: '#fff',
        },
        '& .MuiOutlinedInput-placeholder': {
            color: '#fff',
        },
        '&:hover .MuiOutlinedInput-notchedOutline': {
            // borderColor: 'rgba(0, 0, 0, 0.8)', // warna hover
        },
        '&:hover .MuiInputLabel-root': {
            color: '#aaa', // warna hover
        },
        '& .MuiFormHelperText-root': {
            color: '#fff',  // Warna helper text
        },
        '& .MuiFormLabel-root': {
            color: '#fff',  // Warna helper text
        },
        color: '#fff',
        marginTop: 2,
        borderRadius: 3,
        background: 'rgba(0, 0, 0, 0.45)',
    }

    const styledButton: any = {
        borderRadius: 3
    }

    const checkData = () => {
        setLoading(true);
        try {
            localStorage.setItem('islogin', 'false');
            localStorage.setItem('isadmin', 'false');
            localStorage.removeItem('islogin');
            localStorage.removeItem('isadmin');
            localStorage.removeItem('email');
            localStorage.removeItem('nama');
            localStorage.removeItem('pat');
            localStorage.removeItem('csrfToken');
            sessionStorage.removeItem('peserta_id');
            sessionStorage.removeItem('psikotest_kecermatan_id');
            sessionStorage.removeItem('variabel_id');
            sessionStorage.removeItem('variabel_variabel');
            sessionStorage.removeItem('variabel_values');

            if(sessionStorage.getItem('nama_peserta_psikotest')) setNama(sessionStorage.getItem('nama_peserta_psikotest'));
            if(sessionStorage.getItem('no_identitas_peserta_psikotest')) setNo_identitas(sessionStorage.getItem('no_identitas_peserta_psikotest'));
            if(sessionStorage.getItem('email_peserta_psikotest')) setEmail(sessionStorage.getItem('email_peserta_psikotest'));
            if(sessionStorage.getItem('tgl_lahir_peserta_psikotest')) setTgl_lahir(sessionStorage.getItem('tgl_lahir_peserta_psikotest'));
            if(sessionStorage.getItem('asal_peserta_psikotest')) setAsal(sessionStorage.getItem('asal_peserta_psikotest'));
            if(localStorage.getItem('tgl_tes_peserta_psikotest')) {
                setTgl_tes(localStorage.getItem('tgl_tes_peserta_psikotest'));
                isDatex(true);
            }
            if(sessionStorage.getItem('sesi_psikotest_kecermatan')) {
                setSesiPsikotestKecermatan(sessionStorage.getItem('sesi_psikotest_kecermatan'));
                setIsSession(true);
            }
        }
        catch(err) {
            console.info('Terjadi Erro Peserta-checkData:', err);
            setLoading(false);
        }
        setLoading(false);
    };

    const MemoNavBreadcrumb = React.memo(function Memo() {
        return(
            <NavBreadcrumb content={`Peserta`} hidden={`hidden`} />
        );
    });

    const MemoFooter = React.memo(function Memo() {
        return(
            <Footer hidden={''} otherCSS={`bottom-1 w-full`} />
        );
    });

    const handleChange_Nama = (event: any) => {
        event.preventDefault();
        setNama(event.target.value);
    }

    const handleChange_No_identitas = (event: any) => {
        event.preventDefault();
        setNo_identitas(event.target.value);
    }

    const handleChange_Email = (event: any) => {
        event.preventDefault();
        setEmail(event.target.value);
    }

    const handleChange_Tgl_lahir = (event: any) => {
        event.preventDefault();
        setTgl_lahir(event.target.value);
    }

    const handleChange_Asal = (event: any) => {
        event.preventDefault();
        setAsal(event.target.value);
    }

    const submit = async (e: any) => {
        e.preventDefault();
        setLoading(true);
        try {
            if (!nama || !no_identitas || !tgl_lahir) {
                alert('Nama, No Identitas, dan Tanggal Lahir harus diisi.');
            }
            else {
                const token: string = props.token;
                const unique: string = props.unique;
                axios.defaults.withCredentials = true;
                axios.defaults.withXSRFToken = true;
                const csrfToken = await axios.get(`/sanctum/csrf-cookie`, {
                    withCredentials: true,  // Mengirimkan cookie dalam permintaan
                });
                const response = await axios.post(`/peserta/setup`, {
                    _token: token,
                    _unique: unique,
                    nama: nama,
                    no_identitas: no_identitas,
                    email: email,
                    tgl_lahir: tgl_lahir,
                    asal: asal,
                    tgl_tes: tgl_tes
                }, {
                    withCredentials: true,  // Mengirimkan cookie dalam permintaan
                    headers: {
                        'XSRF-TOKEN': token,
                        'Content-Type': 'application/json',
                        'tokenlogin': unique,
                    }
                });
                // console.info('response', response.data);
                if(parseInt(response.data.success) > 0) {
                    const cookieRules = {
                        path: props.path,
                        domain: props.domain,
                        expires : 1,
                        sameSite : 'strict',
                        secure : true,
                    };

                    Cookies.set('ispeserta', true, cookieRules);
                    sessionStorage.setItem('id_peserta_psikotest', response.data.encrypted_user_data.id);
                    sessionStorage.setItem('nama_peserta_psikotest', response.data.encrypted_user_data.nama);
                    sessionStorage.setItem('no_identitas_peserta_psikotest', response.data.encrypted_user_data.no_identitas);
                    sessionStorage.setItem('email_peserta_psikotest', response.data.encrypted_user_data.email);
                    sessionStorage.setItem('tgl_lahir_peserta_psikotest', response.data.encrypted_user_data.tgl_lahir);
                    sessionStorage.setItem('asal_peserta_psikotest', response.data.encrypted_user_data.asal);
                    sessionStorage.setItem('sesi_psikotest_kecermatan', 1);
                    localStorage.setItem('tgl_tes_peserta_psikotest', today);
                    window.location.href = '/peserta/psikotest/kecermatan/1';
                }
                else if(response.data.success === 'datex') {
                    isDatex(true);
                    if(sessionStorage.getItem('sesi_psikotest_kecermatan') > 0 && sessionStorage.getItem('sesi_psikotest_kecermatan') < 6) {
                        isSession(true);
                        sessionStorage.setItem('sesi_psikotest_kecermatan', 1);
                    }
                }
                else {
                    alert('Terjadi Error: Tidak Dapat Setup Data!');
                }
            }
        }
        catch(err) {
            console.info('Terjadi Error Peserta-submit:', err);
        }
        setLoading(false);
    }

    const continueSession = (e: any) => {
        e.preventDefault();
        setLoading(true);
        try {
            sessionStorage.setItem(`sesi_psikotest_kecermatan`, '1');
            sessionStorage.removeItem(`nilai_total_psikotest_kecermatan_kolom1`);
            sessionStorage.removeItem(`nilai_total_psikotest_kecermatan_kolom2`);
            sessionStorage.removeItem(`nilai_total_psikotest_kecermatan_kolom3`);
            sessionStorage.removeItem(`nilai_total_psikotest_kecermatan_kolom4`);
            sessionStorage.removeItem(`nilai_total_psikotest_kecermatan_kolom5`);
            sessionStorage.removeItem(`sisawaktu_pengerjaan_peserta_psikotest_kecermatan_sesi1`);
            sessionStorage.removeItem(`sisawaktu_pengerjaan_peserta_psikotest_kecermatan_sesi2`);
            sessionStorage.removeItem(`sisawaktu_pengerjaan_peserta_psikotest_kecermatan_sesi3`);
            sessionStorage.removeItem(`sisawaktu_pengerjaan_peserta_psikotest_kecermatan_sesi4`);
            sessionStorage.removeItem(`sisawaktu_pengerjaan_peserta_psikotest_kecermatan_sesi5`);
            window.location.href = '/peserta/psikotest/kecermatan/1';
        }
        catch(err) {
            console.info('Terjadi Error Peserta-continueSession:', err);
            setLoading(false);
        }
        setLoading(false);
    }

    const onBack = (e: any) => {
        e.preventDefault();
        setLoading(true);
        try {
            localStorage.removeItem(`ispeserta`);
            localStorage.removeItem(`tgl_tes_peserta_psikotest`);
            sessionStorage.removeItem(`sesi_psikotest_kecermatan`);
            sessionStorage.removeItem(`id_peserta_psikotest`);
            sessionStorage.removeItem(`nama_peserta_psikotest`);
            sessionStorage.removeItem(`no_identitas_peserta_psikotest`);
            sessionStorage.removeItem(`email_peserta_psikotest`);
            sessionStorage.removeItem(`tgl_lahir_peserta_psikotest`);
            sessionStorage.removeItem(`asal_peserta_psikotest`);
            sessionStorage.removeItem(`nilai_total_psikotest_kecermatan_kolom1`);
            sessionStorage.removeItem(`nilai_total_psikotest_kecermatan_kolom2`);
            sessionStorage.removeItem(`nilai_total_psikotest_kecermatan_kolom3`);
            sessionStorage.removeItem(`nilai_total_psikotest_kecermatan_kolom4`);
            sessionStorage.removeItem(`nilai_total_psikotest_kecermatan_kolom5`);
            sessionStorage.removeItem(`sisawaktu_pengerjaan_peserta_psikotest_kecermatan_sesi1`);
            sessionStorage.removeItem(`sisawaktu_pengerjaan_peserta_psikotest_kecermatan_sesi2`);
            sessionStorage.removeItem(`sisawaktu_pengerjaan_peserta_psikotest_kecermatan_sesi3`);
            sessionStorage.removeItem(`sisawaktu_pengerjaan_peserta_psikotest_kecermatan_sesi4`);
            sessionStorage.removeItem(`sisawaktu_pengerjaan_peserta_psikotest_kecermatan_sesi5`);
            window.location.href= '/';
        }
        catch(err) {
            console.info('Terjadi Error Peserta-onBack:', err);
            setLoading(false);
        }
        setLoading(false);
    }

    const FormIsSession = () => {
        if(datex) {
            // console.info('today', tgl_tes);
            // console.info('tgl_tes', today);
            // console.info('isSession', isSession);
            if(isSession) {
                // console.info('sesiPsikotestKecermatan', sesiPsikotestKecermatan);
                return(
                    <div className="grid grid-rows-[20px_1fr_20px] items-center justify-items-center min-h-screen p-8 pb-20 gap-16 sm:p-20 font-[family-name:var(--font-geist-sans)]">
                        <div className="flex flex-col gap-8 row-start-2 items-center sm:items-start shadow-2xl">
                            <Box component="form"
                                className="form-entry"
                                onSubmit={(e: any) => continueSession(e)}
                                noValidate
                                autoComplete="off"
                            >
                                <div className=''>
                                    <h1 className='font-bold underline text-2lg uppercase text-black'>Anda masih punya sesi!</h1>
                                    <Box sx={{marginTop: 2}}>
                                        <Button variant="contained" size="large" fullWidth color="primary" type="submit" sx={styledButton}>
                                            Lanjut
                                        </Button>
                                    </Box>
                                    <Box sx={{marginTop: 2}}>
                                        <Button variant="contained" size="large" fullWidth color="secondary" onClick={(e: any) => onBack(e)} rel='follow' title='Kembali' href='/' type="button" sx={styledButton}>
                                            Kembali
                                        </Button>
                                    </Box>
                                </div>
                            </Box>
                        </div>
                    </div>
                );
            }
            else {
                return(
                    <div className="grid grid-rows-[20px_1fr_20px] items-center justify-items-center min-h-screen p-8 pb-20 gap-16 sm:p-20 font-[family-name:var(--font-geist-sans)]" >
                        <div className="flex flex-col gap-8 row-start-2 items-center sm:items-start text-center">
                            <Link rel='follow' title='Kembali' href='/' onClick={(e: any) => onBack(e)} sx={{ color: 'white' }}>
                                <div className="form-entry">
                                    <h1 className={`font-bold underline text-2lg uppercase text-black`}>
                                        Silahkan datang esok hari lagi!
                                    </h1>
                                    <h2 className={`mt-4 underline uppercase text-black`}>
                                        Silahkan Klik disini untuk kembali ke halaman Beranda
                                    </h2>
                                </div>
                            </Link>
                        </div>
                    </div>
                );
            }
        }
    }

    // eslint-disable-next-line react-hooks/exhaustive-deps
    React.useEffect(() => {
        checkData();
    }, []);

    document.addEventListener('keydown', (e) => {
        const handlePreventDevTools = (e: any) => {
            if (e.key === 'F12' || (e.ctrlKey && e.shiftKey && e.key === 'I')) {
                e.preventDefault();
                // alert('Developer Tools telah dinonaktifkan!');
            }
        }

        window.addEventListener('keydown', handlePreventDevTools);

        return () => {
            window.removeEventListener('keydown', handlePreventDevTools);
        };
    });

    if(loading) {
        return (
            <h2 className={`text-center p-8 text-${textColor}`}>
                <p><span className='font-bold text-2lg'>
                    Sedang memuat data... Mohon Harap Tunggu...
                </span></p>
                <CircularProgress color="info" size={50} />
            </h2>
        );
    }
    else if(datex) {
        return(
            <>
                <MemoNavBreadcrumb />
                <FormIsSession />
                <MemoFooter />
            </>
        );
    }
    else {
        return (
            <Layout>
                <MemoNavBreadcrumb />
                <div className="items-center justify-items-center p-8">
                    <div className="row-start-2 items-center">
                        <Box component="form"
                            className="form-entry"
                            onSubmit={(e: any) => submit(e)}
                            noValidate
                            autoComplete="off">
                            <h1 className="hidden">Halaman Formulir Peserta Psikotest</h1>
                            <h2 className="text-2xl text-bold uppercase font-bold text-center text-black">Peserta</h2>
                            <div className=''>
                                <TextField  type="text" id="nama" variant="outlined" required
                                            placeholder="Nama..." label="Nama..."
                                            helperText="Wajib diisi"
                                            onChange = {(event: any)=> handleChange_Nama(event)}
                                            defaultValue={nama}
                                            fullWidth sx={styledTextField} />
                                <TextField  type="number" id="no_identitas" variant="outlined" required
                                            placeholder="Nomor Identitas... (NIK / NIP / NISN)" label="Nomor Identitas... (NIK / NIP / NISN)"
                                            helperText="Wajib diisi"
                                            onChange = {(event: any)=> handleChange_No_identitas(event)}
                                            defaultValue={no_identitas}
                                            fullWidth sx={styledTextField} />
                                <TextField  type="text" id="Email" variant="outlined"
                                            placeholder="Email..." label="Email..."
                                            onChange = {(event: any)=> handleChange_Email(event)}
                                            defaultValue={email}
                                            fullWidth sx={styledTextField} />
                                <TextField  type="date" id="tgl_lahir" variant="outlined" required focused
                                            placeholder="Tanggal Lahir..." label="Tanggal Lahir..."
                                            helperText="Wajib diisi"
                                            onChange = {(event: any)=> handleChange_Tgl_lahir(event)}
                                            defaultValue={tgl_lahir}
                                            fullWidth sx={styledTextField} />
                                <TextField  type="text" id="asal" variant="outlined"
                                            placeholder="Asal..." label="Asal..."
                                            onChange = {(event: any)=> handleChange_Asal(event)}
                                            defaultValue={asal}
                                            fullWidth sx={styledTextField} />
                            </div>
                            <div className="mt-4 grid grid-cols-2 gap-4 justify-self-center">
                                <Button variant="contained" size="large" fullWidth color="primary" type="submit" sx={styledButton}>
                                    Lanjut
                                </Button>
                                <Button variant="contained" size="large" fullWidth color="secondary" onClick={(e) => onBack(e)} rel="follow" title="Beranda" href="/" type="button" sx={styledButton}>
                                    Kembali
                                </Button>
                            </div>
                        </Box>
                    </div>
                </div>
                <MemoFooter />
            </Layout>
        );
    }
}
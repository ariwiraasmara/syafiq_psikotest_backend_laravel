// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
'use client';
import Layoutadmindetil from '@/Layouts/Layoutadmindetil.jsx';
import axios from 'axios';
import * as React from 'react';

import CircularProgress from '@mui/material/CircularProgress';
import Box from '@mui/material/Box';
import Button from '@mui/material/Button';
import TextField from '@mui/material/TextField';

import Myhelmet from '@/components/Myhelmet.jsx';
import Appbarku from '@/components/Appbarku.jsx';
import NavBreadcrumb from '@/components/NavBreadcrumb.jsx';
import Footer from '@/components/Footer.jsx';

import { readable, random } from '@/libraries/myfunction';
import validator from 'validator';
import DOMPurify from 'dompurify';

export default function AdminPesertaEdit(props) {
    const textColor = DOMPurify.sanitize(localStorage.getItem('text-color'));
    const textColorRGB = DOMPurify.sanitize(localStorage.getItem('text-color-rgb'));
    const borderColor = DOMPurify.sanitize(localStorage.getItem('border-color'));
    const borderColorRGB = DOMPurify.sanitize(localStorage.getItem('border-color-rgb'));
    const [loading, setLoading] = React.useState(false);
    const [idpeserta, setIdpeserta] = React.useState(0);
    const [nama, setNama] = React.useState('');
    const [no_identitas, setNo_identitas] = React.useState('');
    const [email, setEmail] = React.useState('');
    const [tgl_lahir, setTgl_lahir] = React.useState('');
    const [asal, setAsal] = React.useState('');

    const styledTextField = {
        '& .MuiOutlinedInput-notchedOutline': {
            border: `2px solid ${borderColor}`,
            color: textColor,
        },
        '& .MuiInputLabel-root': {
            color: textColor,
        },
        '& .MuiOutlinedInput-input': {
            color: textColor,
        },
        '& .MuiOutlinedInput-placeholder': {
            color: textColor,
        },
        '&:hover .MuiOutlinedInput-notchedOutline': {
            borderColor: borderColor, // warna hover
        },
        '&:hover .MuiInputLabel-root': {
            color: textColor, // warna hover
        },
    }

    const getData = () => {
        setLoading(true);
        try {
            setIdpeserta(DOMPurify.sanitize(sessionStorage.getItem('admin_id_peserta')));
            setNama(DOMPurify.sanitize(sessionStorage.getItem('admin_nama_peserta')));
            setNo_identitas(DOMPurify.sanitize(sessionStorage.getItem('admin_noidentitas_peserta')));
            setEmail(DOMPurify.sanitize(sessionStorage.getItem('admin_email_peserta')));
            setTgl_lahir(DOMPurify.sanitize(sessionStorage.getItem('admin_tgllahir_peserta')));
            setAsal(DOMPurify.sanitize(sessionStorage.getItem('admin_asal_peserta')));
        }
        catch(err) {
            console.info('Terjadi Error AdminPesertaEdit-getData:', err);
        }
        setLoading(false);
    }

    // eslint-disable-next-line react-hooks/exhaustive-deps
    React.useEffect(() => {
        getData();
    }, []);

    if(loading) {
        return (
            <h2 className={`text-center p-8 font-bold text-2lg text-${textColor}`}>
                <p>Sedang memuat data...<br/></p>
                <p>Mohon Harap Tunggu...</p>
                <CircularProgress color="info" size={50} />
            </h2>
        );
    }

    const submit = async (e) => {
        e.preventDefault();
        setLoading(true);
        try {
            if(validator.isEmail(email) && validator.isDate(tgl_lahir)) {
            axios.defaults.withCredentials = true;
            axios.defaults.withXSRFToken = true;
            const csrfToken = await axios.get(`/sanctum/csrf-cookie`, {
                withCredentials: true,  // Mengirimkan cookie dalam permintaan
            });
            const response = await axios.put(`/api/peserta/${DOMPurify.sanitize(idpeserta)}`, {
                id: idpeserta,
                email: email,
                tgl_lahir: tgl_lahir,
                asal: asal
            }, {
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
            console.info('response', response);
            if(response.data.success) {
                sessionStorage.removeItem('admin_nama_peserta');
                sessionStorage.removeItem('admin_noidentitas_peserta');
                sessionStorage.removeItem('admin_email_peserta');
                sessionStorage.removeItem('admin_tgllahir_peserta');
                sessionStorage.removeItem('admin_asal_peserta');
                // return router.push('/admin/peserta/detil/');
                window.location.href = `/admin/peserta-detil/${idpeserta}`;
            }
            else {
                alert('Terjadi Kesalahan Variabel');
            }
            }
        }
        catch(err) {
            console.log('Terjadi Error AdminPesertaEdit-submit:', err);
        }
        setLoading(false);
    };

    const cancel = (e) => {
        e.preventDefault();
        setLoading(true);
        try {
            sessionStorage.removeItem('admin_nama_peserta');
            sessionStorage.removeItem('admin_noidentitas_peserta');
            sessionStorage.removeItem('admin_email_peserta');
            sessionStorage.removeItem('admin_tgllahir_peserta');
            sessionStorage.removeItem('admin_asal_peserta');
            // return router.push('/admin/peserta/detil/');
            window.location.href = `/admin/peserta-detil/${idpeserta}`;
        }
        catch(err) {
            console.log('Terjadi Error AdminPesertaEdit-cancel', err);
        }
    };

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
            <Appbarku headTitle="Edit Peserta" />
        );
    });

    const MemoNavBreadcrumb = React.memo(function Memo() {
        return(
            <NavBreadcrumb content={`Admin / Peserta / Edit`} hidden={`hidden`} />
        );
    });

    const MemoFooter = React.memo(function Memo() {
        return(
            <Footer hidden={`hidden`} />
        );
    });

    return(
        <Layoutadmindetil>
            <MemoHelmet />
            <MemoAppbarku />
            <MemoNavBreadcrumb />
            <div className={`p-4 text-${textColor}`}>
                <h1 className='hidden'>Halaman Edit Peserta | Admin</h1>
                <div className={`text-${textColor}`}>
                    <p><span className='font-bold'>Nama</span>: {nama}</p>
                    <p><span className='font-bold'>Nomor Identitas</span>: {no_identitas}</p>
                </div>
                <Box component="form"
                    sx={{ '& > :not(style)': { marginTop: 4, width: '100%' } }}
                    onSubmit={(e) => submit(e)}
                    noValidate
                    autoComplete="off">
                    <TextField  type="text" id="Email" variant="outlined" focused
                                placeholder="Email..." label="Email..."
                                onChange = {(event)=> setEmail(DOMPurify.sanitize(event.target.value))}
                                defaultValue={email}
                                fullWidth sx={styledTextField} />
                    <TextField  type="date" id="tgl_lahir" variant="outlined" required focused
                                placeholder="Tanggal Lahir..." label="Tanggal Lahir..."
                                onChange = {(event)=> setTgl_lahir(DOMPurify.sanitize(event.target.value))}
                                defaultValue={tgl_lahir}
                                fullWidth sx={styledTextField} />
                    <TextField  type="text" id="asal" variant="outlined" focused
                                placeholder="Asal..." label="Asal..."
                                onChange = {(event)=> setAsal(DOMPurify.sanitize(event.target.value))}
                                defaultValue={asal}
                                fullWidth sx={styledTextField} />
                    <Box>
                        <div>
                            <Button variant="contained" size="large" color="primary" fullWidth type="submit" >
                                Simpan
                            </Button>
                        </div>
                        <div className="mt-2">
                            <Button variant="contained" size="large" color="secondary" fullWidth onClick={(e) => cancel(e)} sx={{marginTop: 2}} type="button">
                                Batal
                            </Button>
                        </div>
                    </Box>
                </Box>
            </div>
            <MemoFooter />
        </Layoutadmindetil>
    );
}
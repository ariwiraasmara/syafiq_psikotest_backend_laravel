// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
'use client';
import Layoutadmindetil from '@/Layouts/Layoutadmindetil.tsx';
import axios from 'axios';
import * as React from 'react';
import PropTypes from 'prop-types';

import CircularProgress from '@mui/material/CircularProgress';
import Box from '@mui/material/Box';
import Button from '@mui/material/Button';
import TextField from '@mui/material/TextField';

import Appbarku from '@/components/Appbarku.tsx';
import NavBreadcrumb from '@/components/NavBreadcrumb.tsx';
import Footer from '@/components/Footer.tsx';

import validator from 'validator';
import DOMPurify from 'dompurify';

interface AdminPesertaEdit {
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
    id: string;
    data: any;
}

AdminPesertaEdit.propTypes = {
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

export default function AdminPesertaEdit(props: AdminPesertaEdit) {
    const textColor: any = DOMPurify.sanitize(localStorage.getItem('text-color'));
    const textColorRGB: any = DOMPurify.sanitize(localStorage.getItem('text-color-rgb'));
    const borderColor: any = DOMPurify.sanitize(localStorage.getItem('border-color'));
    const borderColorRGB: any = DOMPurify.sanitize(localStorage.getItem('border-color-rgb'));
    const [loading, setLoading] = React.useState<boolean>(false);
    const [idpeserta, setIdpeserta] = React.useState<number>(0);
    const [nama, setNama] = React.useState<string>('');
    const [no_identitas, setNo_identitas] = React.useState<string>('');
    const [email, setEmail] = React.useState<string>('');
    const [tgl_lahir, setTgl_lahir] = React.useState<string>('');
    const [asal, setAsal] = React.useState<string>('');
    const urltoPesertaDetil: string = `/admin/peserta-detil/${idpeserta}`;

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
            // setIdpeserta(DOMPurify.sanitize(sessionStorage.getItem('admin_id_peserta')));
            // setNama(DOMPurify.sanitize(sessionStorage.getItem('admin_nama_peserta')));
            // setNo_identitas(DOMPurify.sanitize(sessionStorage.getItem('admin_noidentitas_peserta')));
            // setEmail(DOMPurify.sanitize(sessionStorage.getItem('admin_email_peserta')));
            // setTgl_lahir(DOMPurify.sanitize(sessionStorage.getItem('admin_tgllahir_peserta')));
            // setAsal(DOMPurify.sanitize(sessionStorage.getItem('admin_asal_peserta')));
            setIdpeserta(parseInt(props.data.id));
            setNama(props.data.nama);
            setNo_identitas(props.data.no_identitas);
            setEmail(props.data.email);
            setTgl_lahir(props.data.tgl_lahir);
            setAsal(props.data.asal);
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

    const submit = async (e: any) => {
        e.preventDefault();
        setLoading(true);
        try {
            if(validator.isEmail(email) && validator.isDate(tgl_lahir)) {
                const token: string = props.token;
                const pat: string = props.pat;
                const rtk: string = props.rtk;
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
                console.info('response', response);
                if(response.data.success) {
                    // sessionStorage.removeItem('admin_nama_peserta');
                    // sessionStorage.removeItem('admin_noidentitas_peserta');
                    // sessionStorage.removeItem('admin_email_peserta');
                    // sessionStorage.removeItem('admin_tgllahir_peserta');
                    // sessionStorage.removeItem('admin_asal_peserta');
                    window.location.href = urltoPesertaDetil;
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

    const cancel = (e: any) => {
        e.preventDefault();
        setLoading(true);
        try {
            // sessionStorage.removeItem('admin_nama_peserta');
            // sessionStorage.removeItem('admin_noidentitas_peserta');
            // sessionStorage.removeItem('admin_email_peserta');
            // sessionStorage.removeItem('admin_tgllahir_peserta');
            // sessionStorage.removeItem('admin_asal_peserta');
            // return router.push('/admin/peserta/detil/');
            window.location.href = urltoPesertaDetil;
        }
        catch(err) {
            console.log('Terjadi Error AdminPesertaEdit-cancel', err);
        }
    };

    const MemoAppbarku = React.memo(function Memo() {
        return(
            <Appbarku user={props.nama} headTitle="Edit Peserta" url={urltoPesertaDetil} isback={true}  />
        );
    });

    const MemoNavBreadcrumb = React.memo(function Memo() {
        return(
            <NavBreadcrumb content={`Admin / Peserta / Edit`} hidden={`hidden`} />
        );
    });

    const MemoFooter = React.memo(function Memo() {
        return(
            <Footer hidden={`hidden`} otherCSS={''} />
        );
    });

    return(
        <Layoutadmindetil>
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
                    onSubmit={(e: any) => submit(e)}
                    noValidate
                    autoComplete="off">
                    <TextField  type="text" id="Email" variant="outlined" focused
                                placeholder="Email..." label="Email..."
                                onChange = {(event: any)=> setEmail(DOMPurify.sanitize(event.target.value))}
                                defaultValue={email}
                                fullWidth sx={styledTextField} />
                    <TextField  type="date" id="tgl_lahir" variant="outlined" required focused
                                placeholder="Tanggal Lahir..." label="Tanggal Lahir..."
                                onChange = {(event: any)=> setTgl_lahir(DOMPurify.sanitize(event.target.value))}
                                defaultValue={tgl_lahir}
                                fullWidth sx={styledTextField} />
                    <TextField  type="text" id="asal" variant="outlined" focused
                                placeholder="Asal..." label="Asal..."
                                onChange = {(event: any)=> setAsal(DOMPurify.sanitize(event.target.value))}
                                defaultValue={asal}
                                fullWidth sx={styledTextField} />
                    <Box>
                        <div>
                            <Button variant="contained" size="large" color="primary" fullWidth type="submit" >
                                Simpan
                            </Button>
                        </div>
                        <div className="mt-2">
                            <Button variant="contained" size="large" color="secondary" fullWidth onClick={(e: any) => cancel(e)} sx={{marginTop: 2}} type="button">
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
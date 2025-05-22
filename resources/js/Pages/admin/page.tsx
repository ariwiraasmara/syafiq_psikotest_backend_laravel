// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
'use client';
import './style.css';
import Layout from '@/Layouts/layout.tsx';
import * as React from 'react';
import axios from 'axios';
import PropTypes from 'prop-types';

import Cookies from 'js-cookie';
import validator from 'validator';
import DOMPurify from 'dompurify';

import Box from '@mui/material/Box';
import Button from '@mui/material/Button';
import TextField from '@mui/material/TextField';
import CircularProgress from '@mui/material/CircularProgress';
import InputAdornment from '@mui/material/InputAdornment';
import EmailIcon from '@mui/icons-material/Email';
import LockPersonIcon from '@mui/icons-material/LockPerson';

import NavBreadcrumb from '@/components/NavBreadcrumb.tsx';
import Footer from '@/components/Footer.tsx';

import { random, currentDate } from '@/libraries/myfunction.js';

interface Admin {
    // Define any props you expect to pass to the component here
    // For example: title?: string;
    title: string;
    csrf_token: string;
    unique: string;
    route_login: string;
    path: string;
    domain: string;
}

Admin.propTypes = {
    title: PropTypes.string,
    csrf_token: PropTypes.string,
    unique: PropTypes.string,
    route_login: PropTypes.string,
    path: PropTypes.string,
    domain: PropTypes.string,
};

const styledTextField = {
    '& .MuiOutlinedInput-notchedOutline': {
        border: '2px solid rgba(0, 0, 0, 0.9)',
        color: '#000',
    },
    '& .MuiInputLabel-root.MuiInputLabel-shrink': {
        color: '#000',
    },
    '& .MuiOutlinedInput-input': {
        color: '#000',
    },
    '& .MuiOutlinedInput-placeholder': {
        color: '#000',
    },
    '&:hover .MuiOutlinedInput-notchedOutline': {
        borderColor: 'rgba(0, 0, 0, 0.8)', // warna hover
    },
    '&:hover .MuiInputLabel-root': {
        color: '#000', // warna hover
    },
    '& .MuiFormHelperText-root': {
        color: '#000',  // Warna helper text
    },
    color: '#000',
    marginTop: 3,
}

export default function Admin(props: Admin) {
    const textColor: string|null = localStorage.getItem('text-color');
    const borderColor: string|null = localStorage.getItem('border-color');
    const [emaillogin, setEmaillogin] = React.useState('');
    const [passlogin, setPasslogin] = React.useState('');
    const [loading, setLoading] = React.useState(true);
    const [sessionAdmin, setSessionAdmin] = React.useState(new Date(localStorage.getItem('sesi_admin')));
    const [cdate, setCdate] = React.useState(new Date(currentDate(null)));

    // eslint-disable-next-line react-hooks/exhaustive-deps
    React.useEffect(() => {
        setLoading(true);
        setCdate(new Date(currentDate(null)));
        if(localStorage.getItem('sesi_admin')) {
            setSessionAdmin(new Date(localStorage.getItem('sesi_admin')));
        }
        setLoading(false);
    }, []);
    // console.info('sessionAdmin', Date.now(sessionAdmin.expire_at));

    if(loading) {
        return (
            <h2 className={`text-center ${textColor}`}>
                <p>
                    <span className='font-bold text-2lg'>
                        Sedang memuat data... Mohon Harap Tunggu...
                    </span>
                </p>
                <CircularProgress color="info" size={50} />
            </h2>
        );
    }

    const MemoNavBreadcrumb = React.memo(function Memo() {
        return(
            <NavBreadcrumb content={`Admin`} hidden={`hidden`} />
        );
    });

    const MemoFooter = React.memo(function Memo() {
        return(
            <Footer hidden={''} otherCSS={``} />
        );
    });

    const sendDataLogin = async (e: any) => {
        e.preventDefault();
        try {
            if(validator.isEmail(emaillogin)) {
                axios.defaults.withCredentials = true;
                axios.defaults.withXSRFToken = true;
                const csrfToken: any = await axios.get(`/sanctum/csrf-cookie`, {
                    withCredentials: true,  // Mengirimkan cookie dalam permintaan
                });
                const response = await axios.post(props.route_login, {
                    _token: props.csrf_token,
                    email: DOMPurify.sanitize(emaillogin),
                    password: DOMPurify.sanitize(passlogin)
                }, {
                    withCredentials: true,
                    headers: {
                        'Content-Type': 'application/json',
                        '_token' : props.csrf_token,
                        'XSRF-TOKEN': csrfToken,
                        'tokenlogin': props.unique,
                    }
                });
                console.info('response', response.data);
                if(response.data.success) {
                    const cookieRules = {
                        path: props.path,
                        domain: props.domain,
                        expires : 1,
                        sameSite : 'strict',
                        secure : true,
                    };

                    Cookies.set('islogin', true, cookieRules);
                    Cookies.set('isadmin', true, cookieRules);
                    Cookies.set('isauth', true, cookieRules);

                    localStorage.setItem('islogin', '1');
                    localStorage.setItem('isadmin', '1');
                    localStorage.setItem('isauth', '1');
                    localStorage.setItem('ispeserta', '0');
                    localStorage.setItem('sesi_admin', response.data.sesi.expire_at);

                    sessionStorage.setItem('issession', '1');
                    window.location.href = '/admin/dashboard';
                }
                else {
                    alert('Email / Password Salah!');
                }
            }
            else {
                alert('Invalid Credentials!');
            }
        }
        catch(err) {
            console.info('Terjadi Error Admin-sendDatalogin:', err);
        }
    }

    const submit = async (e: any) => {
        e.preventDefault();
        setLoading(true);
        try {
            if(!localStorage.getItem('ispeserta') || localStorage.getItem('ispeserta') === '0') {
                if(localStorage.getItem('sesi_admin')) {
                    if( cdate > sessionAdmin ) {
                        sendDataLogin(e);
                        setLoading(false);
                    }
                    else {
                        alert(`Sesi Admin Sudah Kadaluarsa, Anda bisa login kembali setelah ${sessionAdmin}`);
                        setLoading(false);
                    }
                }
                else {
                    sendDataLogin(e);
                }
            }
            else {
                alert('Terjadi Kesalahan!!');
            }
        }
        catch(err) {
            console.info(err);
            alert('Terjadi Kesalahan!');
            setLoading(false);
        }
        setLoading(false);
    };

    return (
        <Layout>
            <MemoNavBreadcrumb />
            <div className="grid grid-rows-[20px_1fr_20px] items-center justify-items-center min-h-screen p-8 pb-20 gap-16 sm:p-20">
                <div className="flex flex-col gap-8 row-start-2 items-center sm:items-start">
                    <Box component="form"
                        onSubmit={(e: any) => submit(e)}
                        className="form-entry"
                        noValidate
                        autoComplete="off">
                        <h1 className="hidden">Halaman Login | Admin</h1>
                        <h2 className="text-2xl text-bold uppercase font-bold text-center text-black">Login</h2>
                        <input type="hidden" id="_token" name="_token" value={props.csrf_token} autoComplete="off" />
                        <TextField  type="email" id="email-login" variant="outlined"
                                    placeholder="Email..."
                                    fullWidth sx={styledTextField}
                                    defaultValue={emaillogin}
                                    onChange = {(event: any)=> setEmaillogin(event.target.value)}
                                    slotProps={{
                                        input: {
                                            startAdornment: (
                                                <InputAdornment position="start">
                                                    <EmailIcon sx={{ color: 'black' }} />
                                                </InputAdornment>
                                            ),
                                        },
                                    }} />
                        <TextField  type="password" id="pass-login" variant="outlined"
                                    placeholder="Password..."
                                    fullWidth sx={styledTextField}
                                    defaultValue={passlogin}
                                    onChange = {(event)=> setPasslogin(event.target.value)}
                                    slotProps={{
                                        input: {
                                            startAdornment: (
                                                <InputAdornment position="start">
                                                    <LockPersonIcon sx={{ color: 'black' }} />
                                                </InputAdornment>
                                            ),
                                        },
                                    }} />
                        <div className="mt-4 grid grid-cols-2 gap-4 justify-self-center">
                            <Button variant="contained" size="large" color="primary" fullWidth type="submit">
                                Login
                            </Button>
                            <Button variant="contained" size="large" color="secondary" fullWidth href="/" title="Beranda" rel="follow" type="button">
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
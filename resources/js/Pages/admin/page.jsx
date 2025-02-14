// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
'use client';
import Layout from '@/Layouts/layout';
import * as React from 'react';
import axios from 'axios';
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

import Myhelmet from '@/components/Myhelmet';
import NavBreadcrumb from '@/components/NavBreadcrumb';
import Footer from '@/components/Footer';

import { random, currentDate } from '@/libraries/myfunction';

const styledTextField = {
    '& .MuiOutlinedInput-notchedOutline': {
        border: '2px solid rgba(255, 255, 255, 0.9)',
        color: '#fff',
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
        borderColor: 'rgba(255, 255, 255, 0.8)', // warna hover
    },
    '&:hover .MuiInputLabel-root': {
        color: '#fff', // warna hover
    },
    '& .MuiFormHelperText-root': {
        color: '#fff',  // Warna helper text
    },
    color: '#fff',
    marginTop: 3,
}

export default function Admin(props) {
    const textColor = localStorage.getItem('text-color');
    const borderColor = localStorage.getItem('border-color');
    const [emaillogin, setEmaillogin] = React.useState('');
    const [passlogin, setPasslogin] = React.useState('');
    const [loading, setLoading] = React.useState(false);
    const [sessionAdmin, setSessionAdmin] = React.useState(new Date(localStorage.getItem('sesi_admin')));
    const [cdate, setCdate] = React.useState(new Date(currentDate(null)));

    // eslint-disable-next-line react-hooks/exhaustive-deps
    React.useEffect(() => {
        setCdate(new Date(currentDate(null)));
        if(localStorage.getItem('sesi_admin')) {
            setSessionAdmin(new Date(localStorage.getItem('sesi_admin')));
        }
    }, []);
    // console.info('sessionAdmin', Date.now(sessionAdmin.expire_at));

    if(loading) {
        return (
            <h2 className={`text-center ${textColor}`}>
                <p><span className='font-bold text-2lg'>
                    Sedang memuat data... Mohon Harap Tunggu...
                </span></p>
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
                onetime={null}
            />
        );
    });

    const MemoNavBreadcrumb = React.memo(function Memo() {
        return(
            <NavBreadcrumb content={`Admin`} hidden={`hidden`} />
        );
    });

    const MemoFooter = React.memo(function Memo() {
        return(
            <Footer otherCSS={`mt-2 rounded-lg`} />
        );
    });

    const sendDataLogin = async () => {
        try {
            if(validator.isEmail(emaillogin) && validator.equals(passlogin, 'admin')) {
                axios.defaults.withCredentials = true;
                axios.defaults.withXSRFToken = true;
                const csrfToken = await axios.get(`/sanctum/csrf-cookie`, {
                    withCredentials: true,  // Mengirimkan cookie dalam permintaan
                });
                const response = await axios.post(`/api/login`, {
                    email: DOMPurify.sanitize(emaillogin),
                    password: DOMPurify.sanitize(passlogin)
                }, {
                    withCredentials: true,  // Mengirimkan cookie dalam permintaan
                    headers: {
                        'Content-Type': 'application/json',
                        'XSRF-TOKEN': csrfToken,
                        'tokenlogin': random('combwisp', 50)
                    }
                });
                console.info('response', response.data);
                if(response.data.success) {
                    const expires = 1;
                    const path = '/';
                    const domain = '';
                    const secure = true;
                    const sameSite = 'strict';

                    const cookieRules = {
                        path: path,
                        domain: domain,
                        expires : expires,
                        sameSite : sameSite,
                        secure : secure,
                    };

                    Cookies.set('islogin', true, cookieRules);
                    Cookies.set('isadmin', true, cookieRules);
                    Cookies.set('isauth', true, cookieRules);
                    Cookies.set('expire_at', response.data.sesi.expire_at, cookieRules);
                    Cookies.set('__token-x-1__', response.data.sesi.token, cookieRules);
                    Cookies.set('__unique__', response.data.sesi.unique, cookieRules);
                    // Cookies.set('nama', response.data.data.nama, cookieRules);
                    // Cookies.set('email', emaillogin, cookieRules);
                    // Cookies.set('pat', response.data.data.token_1, cookieRules);
                    // Cookies.set('rtk', response.data.data.token_2, cookieRules);

                    localStorage.setItem('islogin', true);
                    localStorage.setItem('isadmin', true);
                    localStorage.setItem('isauth', true);
                    localStorage.setItem('ispeserta', false);
                    localStorage.setItem('sesi_admin', response.data.sesi.expire_at);
                    localStorage.setItem('nama', response.data.data.nama);
                    localStorage.setItem('email', emaillogin);
                    localStorage.setItem('pat', response.data.data.token_1);
                    localStorage.setItem('remember-token', response.data.data.token_2);
                    localStorage.setItem('csrfToken', csrfToken);
                    // route('admin/dashboard');
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

    const submit = async (e) => {
        e.preventDefault();
        setLoading(true);
        try {
            if(!localStorage.getItem('ispeserta') || localStorage.getItem('ispeserta') === 'false') {
                if(localStorage.getItem('sesi_admin')) {
                    if( cdate > sessionAdmin ) {
                        sendDataLogin();
                        setLoading(false);
                    }
                    else {
                        alert(`Sesi Admin Sudah Kadaluarsa, Anda bisa login kembali setelah ${sessionAdmin}`);
                        setLoading(false);
                    }
                }
                else {
                    sendDataLogin();
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
            <MemoHelmet />
            <MemoNavBreadcrumb />
            <div className="grid grid-rows-[20px_1fr_20px] items-center justify-items-center min-h-screen p-8" >
                <div className="row-start-2 items-center sm:items-start">
                    <Box component="form"
                        onSubmit={(e) => submit(e)}
                        sx={{ '& > :not(style)': { m: 0, p: 1, width: '100%' },
                            backgroundColor: 'rgba(0, 0, 0, 0.5)',
                            border: `3px solid ${borderColor}`,
                            borderRadius: 3,
                            textAlign: 'center',
                            p: 3
                        }}
                        noValidate
                        autoComplete="off">
                        <h1 className="hidden">Halaman Login | Admin</h1>
                        <span className="text-2xl text-bold uppercase font-bold">Login Admin</span>
                        <TextField  type="email" id="email-login" variant="outlined"
                                    placeholder="Email..."
                                    fullWidth sx={styledTextField}
                                    defaultValue={emaillogin}
                                    onChange = {(event)=> setEmaillogin(event.target.value)}
                                    slotProps={{
                                        input: {
                                            startAdornment: (
                                                <InputAdornment position="start">
                                                    <EmailIcon sx={{ color: 'white' }} />
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
                                                    <LockPersonIcon sx={{ color: 'white' }} />
                                                </InputAdornment>
                                            ),
                                        },
                                    }} />
                        <Box sx={{ m: 1 }}>
                            <div>
                                <Button variant="contained" size="large" color="primary" fullWidth type="submit">
                                    Login
                                </Button>
                            </div>
                            <div className='mt-4'>
                                <Button variant="contained" size="large" color="secondary" fullWidth href="/" title="Beranda" rel="follow" type="button">
                                    Kembali
                                </Button>
                            </div>
                        </Box>
                    </Box>
                    <MemoFooter />
                </div>
            </div>
        </Layout>
    );
}
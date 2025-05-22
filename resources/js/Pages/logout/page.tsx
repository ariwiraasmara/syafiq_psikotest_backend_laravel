// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
'use client';
import * as React from 'react';
import axios from 'axios';
import Cookies from 'js-cookie';
import CircularProgress from '@mui/material/CircularProgress';
import { readable, random } from '@/libraries/myfunction';
export default function Logout() {
    const textColor = localStorage.getItem('text-color');
    const textColorRGB = localStorage.getItem('text-color-rgb');
    const borderColor = localStorage.getItem('border-color');
    const borderColorRGB = localStorage.getItem('border-color-rgb');

    const logout = async () => {
        try {
            axios.defaults.withCredentials = true;
            axios.defaults.withXSRFToken = true;
            const csrfToken = await axios.get(`/sanctum/csrf-cookie`, {
                withCredentials: true,  // Mengirimkan cookie dalam permintaan
            });
            const response = await axios.get(`/api/logout`, {
                withCredentials: true,  // Mengirimkan cookie dalam permintaan
                headers: {
                    'Content-Type': 'application/json',
                    'XSRF-TOKEN': csrfToken,
                    'tokenlogin': random('combwisp', 50)
                }
            });
            console.info('response', response);
            if(response.data.success > 0) {
                Cookies.remove('islogin');
                Cookies.remove('isadmin');
                Cookies.remove('isauth');
                Cookies.remove('__token__');

                localStorage.clear();
                sessionStorage.clear();
                localStorage.setItem('sesi_admin', response.data.sesi.expire_at);
                // return router.push('/');
                window.location.href = '/';
            }
            else {
                alert('Tidak Bisa Logout!');
            }
        }
        catch(err) {
            console.log('Terjadi Error Logout-logout:', err);
        }
    };

    React.useEffect(() => {
        logout();
    }, []);

    return (
        <h2 className={`text-center p-8 text-${textColor}`}>
            <p><span className='font-bold text-2lg'>
                Sedang memuat data... Mohon Harap Tunggu...
            </span></p>
            <CircularProgress color="info" size={50} />
        </h2>
    );
}
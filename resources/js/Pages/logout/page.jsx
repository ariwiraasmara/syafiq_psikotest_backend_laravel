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
                localStorage.setItem('sesi_admin', response.data.sesi.expire_at);
                
                //? Sesi Cookies
                Cookies.remove('islogin');
                Cookies.remove('isadmin');
                Cookies.remove('isauth');
                Cookies.remove('expire_at');
                Cookies.remove('__sysel__');
                Cookies.remove('__sysauth__');
                Cookies.remove('__token__');
                Cookies.remove('__unique__');
                Cookies.remove('XSRF-TOKEN');
                Cookies.remove('nama');
                Cookies.remove('email');
                Cookies.remove('pat');
                Cookies.remove('rtk');

                //? Sesi Local Storage Data Admin
                localStorage.removeItem('islogin');
                localStorage.removeItem('isadmin');
                localStorage.removeItem('ispeserta');
                localStorage.removeItem('email');
                localStorage.removeItem('nama');
                localStorage.removeItem('pat');
                localStorage.removeItem('csrfToken');
                localStorage.removeItem('remember-token');
                sessionStorage.removeItem('nav_id');
                localStorage.setItem('sesi_admin', response.data.sesi.expire_at);

                //? Sesi Data Halaman Peserta
                sessionStorage.removeItem('admin_id_peserta');
                sessionStorage.removeItem('admin_nama_peserta');
                sessionStorage.removeItem('admin_noidentitas_peserta');
                sessionStorage.removeItem('admin_email_peserta');
                sessionStorage.removeItem('admin_tgllahir_peserta');
                sessionStorage.removeItem('admin_asal_peserta');

                //? Sesi Data Halaman Psikotest Kecermatan
                sessionStorage.removeItem('admin_psikotest_kecermatan_id');
                sessionStorage.removeItem('admin_psikotest_kecermatan_kolom_x');
                sessionStorage.removeItem('admin_psikotest_kecermatan_nilai_A');
                sessionStorage.removeItem('admin_psikotest_kecermatan_nilai_B');
                sessionStorage.removeItem('admin_psikotest_kecermatan_nilai_C');
                sessionStorage.removeItem('admin_psikotest_kecermatan_nilai_D');
                sessionStorage.removeItem('admin_psikotest_kecermatan_nilai_E');
                sessionStorage.removeItem('admin_psikotest_kecermatan_idsoal');
                sessionStorage.removeItem('admin_psikotest_kecermatan_soalA');
                sessionStorage.removeItem('admin_psikotest_kecermatan_soalB');
                sessionStorage.removeItem('admin_psikotest_kecermatan_soalC');
                sessionStorage.removeItem('admin_psikotest_kecermatan_soalD');
                sessionStorage.removeItem('admin_psikotest_kecermatan_jawaban');
                sessionStorage.removeItem('admin_psikotest_kecermatan_tabellastpage');

                //? Sesi Data Halaman Variabel
                sessionStorage.removeItem('admin_variabel_id');
                sessionStorage.removeItem('admin_variabel_variabel');
                sessionStorage.removeItem('admin_variabel_values');
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
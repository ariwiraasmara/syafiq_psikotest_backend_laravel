// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
'use client';
import Layout from '@/Layouts/layout.tsx';
import * as React from 'react';
import PropTypes from 'prop-types';
import Box from '@mui/material/Box';
import Button from '@mui/material/Button';
import NavigasiBawah from '@/components/admin/NavigasiBawah.tsx';
import Cookies from 'js-cookie';

interface LayoutadminProps {
    children: React.ReactNode;
    navvar: number;
}

Layoutadmin.propTypes = {
    children: PropTypes.any,
    navvar: PropTypes.number
};

export default function Layoutadmin({ children, navvar }: LayoutadminProps) {
    const [loading, setLoading] = React.useState<boolean>(false);
    const [islogin, setIslogin] = React.useState<boolean>(false);
    const [isadmin, setIsadmin] = React.useState<boolean>(false);
    const [isauth, setIsauth] = React.useState<boolean>(false);
    const [ispeserta, setIspeserta] = React.useState<boolean>(false);
    const [issession, setIssession] = React.useState<boolean>(false);

    const getData = () => {
        setLoading(true);
        try {
            if(Cookies.get('islogin') && (parseInt(localStorage.getItem('islogin')) === 1)) setIslogin(true);
            else setIslogin(false);

            if(Cookies.get('isadmin') && (parseInt(localStorage.getItem('isadmin')) === 1)) setIsadmin(true);
            else setIsadmin(false);

            if(Cookies.get('isauth') && (parseInt(localStorage.getItem('isauth')) === 1)) setIsauth(true);
            else setIsauth(false);

            if(Cookies.get('ispeserta') && (parseInt(localStorage.getItem('ispeserta')) === 1)) setIspeserta(true);
            else setIspeserta(false);

            if(parseInt(sessionStorage.getItem('issession')) === 1) setIssession(true);
            else setIssession(false);
        }
        catch(err) {
            console.error('Terjadi Kesalahan!');
            return err;
        }
        setLoading(false);
    }

    React.useEffect(() => {
        getData();
    }, [islogin, isadmin, ispeserta, isauth, issession]);

    if(loading) {
        return (
            <Layout>
                <div className='text-center p-8'>
                    <p><span className='font-bold text-2lg'>Loading...</span></p>
                </div>
            </Layout>
        );
    }

    if(ispeserta) return window.location.href = '/peserta';

    if(islogin && isadmin && isauth && issession) {
        const MemoNavigasiBawah = React.memo(function Memo() {
            return <NavigasiBawah navvar={navvar} />;
        });
        return (
            <Layout>
                {children}
                <MemoNavigasiBawah />;
            </Layout>
        );
    }
    else {
        return (
            <Layout>
                <div className='text-center p-20'>
                    <h1 className='text-2xl text-bold uppercase font-bold'>Unauthorized!</h1>
                    <p className='mt-4 uppercase font-bold'>Tidak diperkenankan untuk mengakses halaman ini!</p>
                    <div className='mt-6'>
                        <Box sx={{ '& button': {width: '100%' } }}>
                            <Button variant="contained" size="large" onClick={() => window.location.href = '/logout'}>
                                Kembali
                            </Button>
                        </Box>
                    </div>
                </div>
            </Layout>
        );
    }
    
}

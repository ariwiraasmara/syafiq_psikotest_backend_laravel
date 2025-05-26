// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
'use client';
import Layout from '@/Layouts/layout.tsx';
import * as React from 'react';
import PropTypes from 'prop-types';
import Box from '@mui/material/Box';
import Button from '@mui/material/Button';

interface Layoutadmindetil {
    children: React.ReactNode;
}

Layoutadmindetil.propTypes = {
    children: PropTypes.any,
};

export default function Layoutadmindetil({ children }: Layoutadmindetil) {
    const [loading, setLoading] = React.useState<boolean>(true);
    const [islogin, setIslogin] = React.useState<boolean>(false);
    const [isadmin, setIsadmin] = React.useState<boolean>(false);

    React.useEffect(() => {
        setLoading(true);
        setIslogin(localStorage.getItem('islogin'));
        setIsadmin(localStorage.getItem('isadmin'));
        setLoading(false);
    }, [islogin, isadmin]);

    if(loading) {
        return (
            <div className='text-center p-8'>
                <p><span className='font-bold text-2lg'>Loading...</span></p>
            </div>
        );
    }

    if(islogin && isadmin) {
        return (
            <Layout>
                {children}
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
                            <Button variant="contained" size="large" onClick={() => router.push('/admin')}>
                                Kembali
                            </Button>
                        </Box>
                    </div>
                </div>
            </Layout>
        );
    }
}

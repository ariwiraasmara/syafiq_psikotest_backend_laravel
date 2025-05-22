// ! Copyright @
// ! Syafiq
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

interface AdminVariabelBaru {
    // Define any props you expect to pass to the component here
    // For example: title?: string;
    title: string;
    token: string;
    unique: string;
    nama: string;
    pat: string;
    rtk: string;
    email: string;
    page: number;
}

AdminVariabelBaru.propTypes = {
    title: PropTypes.string,
    token: PropTypes.string,
    unique: PropTypes.string,
    nama: PropTypes.string,
    pat: PropTypes.string,
    rtk: PropTypes.string,
    email: PropTypes.string,
};

export default function AdminVariabelBaru(props: AdminVariabelBaru) {
    const textColor: string = DOMPurify.sanitize(localStorage.getItem('text-color'));
    const textColorRGB: string = DOMPurify.sanitize(localStorage.getItem('text-color-rgb'));
    const borderColor: string = DOMPurify.sanitize(localStorage.getItem('border-color'));
    const borderColorRGB: string = DOMPurify.sanitize(localStorage.getItem('border-color-rgb'));
    const [loading, setLoading] = React.useState<boolean>(false);
    const [nvariabel, setNvariabel] = React.useState<string>('');
    const [nvalues, setNvalues] = React.useState<string>('');
    const urltoVariabelSetting: string = '/admin/variabel-setting/-/-/-?page=1';

    const styledTextField = {
        '& .MuiOutlinedInput-notchedOutline': {
            border: `2px solid #fff`,
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
            color: textColorRGB,
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
        background: 'rgba(0, 0, 0, 0.5)',
        borderRadius: 3,
    }

    const handleChange_Nvariable = (event: any) => {
        event.preventDefault();
        setNvariabel(DOMPurify.sanitize(event.target.value));
    };

    const handleChange_Nvalues = (event: any) => {
        event.preventDefault();
        setNvalues(DOMPurify.sanitize(event.target.value));
    };

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
            const pat: string = props.pat;
            const rtk: string = props.rtk;
            axios.defaults.withCredentials = true;
            axios.defaults.withXSRFToken = true;
            const csrfToken = await axios.get(`/sanctum/csrf-cookie`, {
                withCredentials: true,  // Mengirimkan cookie dalam permintaan
            });
            const response = await axios.post(`/api/variabel-setting`, {
                variabel: nvariabel,
                values: nvalues
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
                window.location.href = urltoVariabelSetting;
            }
            else {
                alert('Terjadi Kesalahan Variabel');
            }
        }
        catch(err) {
            console.log('Terjadi Error AdminVariabel-submit:', err);
        }
        setLoading(false);
    };

    const cancel = (e: any) => {
        e.preventDefault();
        setLoading(true);
        // sessionStorage.removeItem('variabel_id');
        // sessionStorage.removeItem('variabel_variabel');
        // sessionStorage.removeItem('variabel_values');
        // router.push('/admin/variabel?page=1');
        window.location.href = urltoVariabelSetting;
    };

    const MemoAppbarku = React.memo(function Memo() {
        return(
            <Appbarku user={props.nama} headTitle="Variabel Baru" url={urltoVariabelSetting} isback={true}/>
        );
    });

    const MemoNavBreadcrumb = React.memo(function Memo() {
        return(
            <NavBreadcrumb content={`Admin / Variabel / Baru`} hidden={`hidden`} />
        );
    });

    const MemoFooter = React.memo(function Memo() {
        return(
            <Footer hidden={`hidden`} otherCSS={''} />
        );
    });

    return (
    <>
        <Layoutadmindetil>
            <MemoNavBreadcrumb />
            <MemoAppbarku />
            <div className="p-4">
                <h1 className='hidden'>Halaman Tambah Variabel Baru | Admin</h1>
                <Box component="form"
                    sx={{ '& > :not(style)': { marginTop: 2, p: 0, width: '100%' } }}
                    onSubmit={(e) => submit(e)}
                    noValidate
                    autoComplete="off">
                    <TextField  type="text" id="variabel" variant="outlined"
                                placeholder="Variabel..." label="Variabel..."
                                fullWidth sx={styledTextField}
                                onChange={handleChange_Nvariable}
                                defaultValue={nvariabel} />
                    <TextField  type="text" id="values" variant="outlined"
                                placeholder="Nilai..." label="Nilai..."
                                fullWidth sx={styledTextField}
                                onChange={handleChange_Nvalues}
                                defaultValue={nvalues} />
                    <Box>
                        <Button variant="contained" size="large" fullWidth color="primary" type="submit">
                            Simpan
                        </Button>
                    </Box>
                    <Box>
                        <Button variant="contained" size="large" fullWidth color="secondary" onClick={(e) => cancel(e)} rel='follow' title='Kembali' href='/admin/variabel' type="button">
                            Batal
                        </Button>
                    </Box>
                </Box>
            </div>
            <MemoFooter />
        </Layoutadmindetil>
    </>
    )
}
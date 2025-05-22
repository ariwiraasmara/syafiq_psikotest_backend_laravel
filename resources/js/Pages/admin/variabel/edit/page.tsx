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

interface AdminVariabelEdit {
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
    route: string;
    id: number;
    data: any;
}

AdminVariabelEdit.propTypes = {
    title: PropTypes.string,
    token: PropTypes.string,
    unique: PropTypes.string,
    nama: PropTypes.string,
    pat: PropTypes.string,
    rtk: PropTypes.string,
    email: PropTypes.string,
    route: PropTypes.string,
    id: PropTypes.string,
    data: PropTypes.any,
};

export default function AdminVariabelEdit(props: AdminVariabelEdit) {
    const textColor: any = DOMPurify.sanitize(localStorage.getItem('text-color'));
    const textColorRGB: any = DOMPurify.sanitize(localStorage.getItem('text-color-rgb'));
    const borderColor: any = DOMPurify.sanitize(localStorage.getItem('border-color'));
    const borderColorRGB: any = DOMPurify.sanitize(localStorage.getItem('border-color-rgb'));
    const [loading, setLoading] = React.useState<boolean>(false);
    const [nvariabel, setNvariabel] = React.useState<string>('');
    const [nvalues, setNvalues] = React.useState<string>('');
    const urltoVariabelSetting: string = '/admin/variabel-setting/-/-/-?page=1';
    const route: string = props.route;

    const styledTextField = {
        '& .MuiOutlinedInput-notchedOutline': {
            border: `2px solid ${borderColor}`,
            color: textColorRGB,
        },
        '& .MuiInputLabel-root': {
            color: textColorRGB,
        },
        '& .MuiOutlinedInput-input': {
            color: textColorRGB,
        },
        '& .MuiOutlinedInput-placeholder': {
            color: textColorRGB,
        },
        '&:hover .MuiOutlinedInput-notchedOutline': {
            borderColor: borderColor, // warna hover
        },
        '&:hover .MuiInputLabel-root': {
            color: textColorRGB, // warna hover
        },
    }

    const handleChange_Nvariable = (event: any) => {
        event.preventDefault();
        setNvariabel(DOMPurify.sanitize(event.target.value));
    };

    const handleChange_Nvalues = (event: any) => {
        event.preventDefault();
        setNvalues(DOMPurify.sanitize(event.target.value));
    };

    const getData = () => {
        // setNvariabel(DOMPurify.sanitize(sessionStorage.getItem('admin_variabel_variabel')));
        // setNvalues(DOMPurify.sanitize(sessionStorage.getItem('admin_variabel_values')));
        setNvariabel(props.data.variabel);
        setNvalues(props.data.values);
    }

    // eslint-disable-next-line react-hooks/exhaustive-deps
    React.useEffect(() => {
        getData();
        console.info('route', route);
    }, []);

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

    const submit = async (e:any) => {
        e.preventDefault();
        setLoading(true);
        try {
            const token: string = props.token;
            const pat: string = props.pat;
            const rtk: string = props.rtk;
            axios.defaults.withCredentials = true;
            axios.defaults.withXSRFToken = true;
            const csrfToken = await axios.get(`/sanctum/csrf-cookie`, {
                withCredentials: true,  // Mengirimkan cookie dalam permintaan
            });
            const response = await axios.put(`/api/variabel-setting/${props.id}`, {
                _token: token,
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
            console.info('response', response);
            if(response.data.success) {
                window.location.href = urltoVariabelSetting;
            }
            else {
                alert('Terjadi Kesalahan Variabel');
            }
        }
        catch(err) {
            console.info('Terjadi Error AdminVariabelEdit-submit:', err);
        }
        setLoading(false);
    };

    const cancel = (e: any) => {
        e.preventDefault();
        setLoading(true);
        sessionStorage.removeItem('admin_variabel_variabel')
        sessionStorage.removeItem('admin_variabel_values')
        window.location.href = urltoVariabelSetting;
    };

    const MemoAppbarku = React.memo(function Memo() {
        return(
            <Appbarku user={props.nama} headTitle="Edit Variabel" url={urltoVariabelSetting} isback={true} />
        );
    });

    const MemoNavBreadcrumb = React.memo(function Memo() {
        return(
            <NavBreadcrumb content={`Admin / Variabel / Edit`} hidden={`hidden`} />
        );
    });

    const MemoFooter = React.memo(function Memo() {
        return(
            <Footer hidden={`hidden`} />
        );
    });

    return (
    <>
        <Layoutadmindetil>
            <MemoNavBreadcrumb />
            <MemoAppbarku />
            <div className="p-4 mb-14">
                <h1 className='hidden'>Halaman Edit Variabel | Admin</h1>
                <Box component="form"
                    sx={{ '& > :not(style)': { marginTop: 3, p: 0, width: '100%' } }}
                    onSubmit={(e) => submit(e)}
                    noValidate
                    autoComplete="off">
                    <TextField  type="text" id="variabel" variant="outlined" focused
                                placeholder="Variabel..." label="Variabel..."
                                fullWidth sx={styledTextField}
                                onChange={handleChange_Nvariable}
                                defaultValue={nvariabel} />
                    <TextField  type="text" id="values" variant="outlined" focused
                                placeholder="Nilai..." label="Nilai..."
                                fullWidth sx={styledTextField}
                                onChange={handleChange_Nvalues}
                                defaultValue={nvalues} />
                    <Box>
                        <div>
                            <Button variant="contained" size="large" fullWidth color="primary" type="submit">
                                Simpan
                            </Button>
                        </div>
                        <div className="mt-4">
                            <Button variant="contained" size="large" fullWidth color="secondary" onClick={(e) => cancel(e)} rel='follow' title='Kembali' href='/admin/variabel' type="button">
                                Batal
                            </Button>
                        </div>
                    </Box>
                </Box>
            </div>
            <MemoFooter />
        </Layoutadmindetil>
    </>
    )
}
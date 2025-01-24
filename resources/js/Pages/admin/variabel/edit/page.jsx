// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
'use client';
import Layoutadmindetil from '@/Layouts/Layoutadmindetil';
import axios from 'axios';
import * as React from 'react';
import Box from '@mui/material/Box';
import Button from '@mui/material/Button';
import TextField from '@mui/material/TextField';
import CircularProgress from '@mui/material/CircularProgress';

import Myhelmet from '@/components/Myhelmet';
import Appbarku from '@/components/Appbarku';
import NavBreadcrumb from '@/components/NavBreadcrumb';
import Footer from '@/components/Footer';
import { readable, random } from '@/libraries/myfunction';

export default function AdminVariabelEdit(props) {
    const textColor = localStorage.getItem('text-color');
    const textColorRGB = localStorage.getItem('text-color-rgb');
    const borderColor = localStorage.getItem('border-color');
    const borderColorRGB = localStorage.getItem('border-color-rgb');
    const [loading, setLoading] = React.useState(false);
    const [nid, setNid] = React.useState(readable(sessionStorage.getItem('admin_variabel_id')));

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
    
    const [nvariabel, setNvariabel] = React.useState('');
    const handleChange_Nvariable = (event) => {
        event.preventDefault();
        setNvariabel(event.target.value);
    };

    const [nvalues, setNvalues] = React.useState();
    const handleChange_Nvalues = (event) => {
        event.preventDefault();
        setNvalues(event.target.value);
    };

    const getData = () => {
        setLoading(true);
        try {
            // setNid(readable(sessionStorage.getItem('admin_variabel_id')));
            setNvariabel(readable(sessionStorage.getItem('admin_variabel_variabel')));
            setNvalues(readable(sessionStorage.getItem('admin_variabel_values')));
        } catch (err) {
            console.error('Eror getData Edit Variabel', err);
        }
        setLoading(false);
    }

    // eslint-disable-next-line react-hooks/exhaustive-deps
    React.useEffect(() => {
        getData();
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

    const submit = async (e) => {
        e.preventDefault();
        setLoading(true);
        try {
            axios.defaults.withCredentials = true;
            axios.defaults.withXSRFToken = true;
            const csrfToken = await axios.get(`${process.env.NEXT_PUBLIC_API_BACKEND}/sanctum/csrf-cookie`, {
                withCredentials: true,  // Mengirimkan cookie dalam permintaan
            });
            const response = await axios.put(`${process.env.NEXT_PUBLIC_API_BACKEND}/api/variabel-setting/${nid}`, {
                variabel: nvariabel,
                values: nvalues
            }, {
                withCredentials: true,  // Mengirimkan cookie dalam permintaan
                headers: {
                    'Content-Type': 'application/json',
                    'XSRF-TOKEN': csrfToken,
                    'islogin' : readable(localStorage.getItem('islogin')),
                    'isadmin' : readable(localStorage.getItem('isadmin')),
                    'Authorization': `Bearer ${readable(localStorage.getItem('pat'))}`,
                    'remember-token': readable(localStorage.getItem('remember-token')),
                    'tokenlogin': random('combwisp', 50),
                    'email' : readable(localStorage.getItem('email')),
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
                sessionStorage.removeItem('admin_variabel_id');
                sessionStorage.removeItem('admin_variabel_variabel');
                sessionStorage.removeItem('admin_variabel_values');
                // return router.push('/admin/variabel?page=1');
                window.location.href = '/admin/variabel/1';
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

    const cancel = (e) => {
        e.preventDefault();
        setLoading(true);
        sessionStorage.removeItem('admin_variabel_id');
        sessionStorage.removeItem('admin_variabel_variabel');
        sessionStorage.removeItem('admin_variabel_values');
        // router.push('/admin/variabel?page=1');
        window.location.href = '/admin/variabel/1';
    };
    
    const MemoHelmet = React.memo(function Memo() {
        return(
            <Myhelmet
                title={props.title}
                pathURL={props.pathURL}
                robots={props.robots}
            />
        );
    });

    const MemoAppbarku = React.memo(function Memo() {
        return(
            <Appbarku headTitle="Edit Variabel" />
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
            <MemoHelmet />
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
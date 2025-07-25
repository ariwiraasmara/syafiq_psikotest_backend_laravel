// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
'use client';
import Layoutadmindetil from '@/Layouts/Layoutadmindetil.jsx';
import axios from 'axios';
import * as React from 'react';
import Box from '@mui/material/Box';
import Button from '@mui/material/Button';
import TextField from '@mui/material/TextField';
import CircularProgress from '@mui/material/CircularProgress';

import Myhelmet from '@/components/Myhelmet.jsx';
import Appbarku from '@/components/Appbarku.jsx';
import NavBreadcrumb from '@/components/NavBreadcrumb.jsx';
import Footer from '@/components/Footer.jsx';
import { readable, random } from '@/libraries/myfunction';
import validator from 'validator';
import DOMPurify from 'dompurify';

export default function PsikotestKecermatanBaru(props) {
    const textColor = DOMPurify.sanitize(localStorage.getItem('text-color'));
    const textColorRGB = DOMPurify.sanitize(localStorage.getItem('text-color-rgb'));
    const borderColor = DOMPurify.sanitize(localStorage.getItem('border-color'));
    const borderColorRGB = DOMPurify.sanitize(localStorage.getItem('border-color-rgb'));
    const [loading, setLoading] = React.useState(false);

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

    const [kolom_x, setKolom_x] = React.useState('');
    const handleChange_kolom_x = (event) => {
        event.preventDefault();
        setKolom_x(DOMPurify.sanitize(event.target.value));
    }
    
    const [nilai_A, setNilai_A] = React.useState(0);
    const handleChange_nilai_A = (event) => {
        event.preventDefault();
        setNilai_A(DOMPurify.sanitize(event.target.value));
    }
    
    const [nilai_B, setNilai_B] = React.useState(0);
    const handleChange_nilai_B = (event) => {
        event.preventDefault();
        setNilai_B(DOMPurify.sanitize(event.target.value));
    }
    
    const [nilai_C, setNilai_C] = React.useState(0);
    const handleChange_nilai_C = (event) => {
        event.preventDefault();
        setNilai_C(DOMPurify.sanitize(event.target.value));
    }
    
    const [nilai_D, setNilai_D] = React.useState(0);
    const handleChange_nilai_D = (event) => {
        event.preventDefault();
        setNilai_D(DOMPurify.sanitize(event.target.value));
    }
    
    const [nilai_E, setNilai_E] = React.useState(0);
    const handleChange_nilai_E = (event) => {
        event.preventDefault();
        setNilai_E(DOMPurify.sanitize(event.target.value));
    }
    
    if(loading) {
        return (
            <h2 className={`text-center p-8 text-${textColor}`}>
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
                onetime={props.onetime}
            />
        );
    });

    const MemoAppbarku = React.memo(function Memo() {
        return(
            <Appbarku headTitle="Psikotest Kecermatan Baru" />
        );
    });

    const MemoNavBreadcrumb = React.memo(function Memo() {
        return(
            <NavBreadcrumb content={`Admin / Psikotest/ Kecermatan / Baru`} hidden={`hidden`} />
        );
    });

    const MemoFooter = React.memo(function Memo() {
        return(
            <Footer hidden={`hidden`} />
        );
    });

    const submit = async (e) => {
        e.preventDefault();
        setLoading(true);
        try {
            const validNumberRange = {
                min : 1,
                max : 9
            };
            if( validator.isInt(nilai_A, validNumberRange) &&
                validator.isInt(nilai_B, validNumberRange) &&
                validator.isInt(nilai_C, validNumberRange) &&
                validator.isInt(nilai_D, validNumberRange) &&
                validator.isInt(nilai_E, validNumberRange)
            ) {
                axios.defaults.withCredentials = true;
                axios.defaults.withXSRFToken = true;
                const csrfToken = await axios.get(`/sanctum/csrf-cookie`, {
                    withCredentials: true,  // Mengirimkan cookie dalam permintaan
                });
                const response = await axios.post(`/api/kecermatan/kolompertanyaan`, {
                    kolom_x: kolom_x,
                    nilai_A: nilai_A,
                    nilai_B: nilai_B,
                    nilai_C: nilai_C,
                    nilai_D: nilai_D,
                    nilai_E: nilai_E,
                }, {
                    withCredentials: true,  // Mengirimkan cookie dalam permintaan
                    headers: {
                    'Content-Type': 'application/json',
                    'XSRF-TOKEN': csrfToken,
                    'islogin' : DOMPurify.sanitize(localStorage.getItem('islogin')),
                    'isadmin' : DOMPurify.sanitize(localStorage.getItem('isadmin')),
                    'Authorization': `Bearer ${DOMPurify.sanitize(localStorage.getItem('pat'))}`,
                    'remember-token': DOMPurify.sanitize(localStorage.getItem('remember-token')),
                    'tokenlogin': random('combwisp', 50),
                    'email' : DOMPurify.sanitize(localStorage.getItem('email')),
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
                // console.log('response', response);
                if(response.data.success) {
                    // router.push('/admin/psikotest/kecermatan');
                    window.location.href = '/admin/psikotest/kecermatan';
                }
                else {
                    alert('Terjadi Error : Tidak Dapat Menyimpan Data!');
                }
            }
            else {
                alert('Invalid Credentials!');
            }
        }
        catch(err) {
            console.log('Terjadi Error PsikotestKecermatanBaru-submit:', err);
        }
        setLoading(false);
    };

    const cancel = (e) => {
        e.preventDefault();
        try {
            sessionStorage.removeItem('psikotest_kecermatan_id');
            sessionStorage.removeItem('psikotest_kecermatan_kolom_x');
            sessionStorage.removeItem('psikotest_kecermatan_nilai_A');
            sessionStorage.removeItem('psikotest_kecermatan_nilai_B');
            sessionStorage.removeItem('psikotest_kecermatan_nilai_C');
            sessionStorage.removeItem('psikotest_kecermatan_nilai_D');
            sessionStorage.removeItem('psikotest_kecermatan_nilai_E');
            // return router.push('/admin/psikotest/kecermatan');
            window.location.href = '/admin/psikotest/kecermatan';
        }
        catch(err) {
            console.log('Terjadi Error PsikotestKecermatanBaru-cancel', err);
        }
    };

    return(
    <>
        <Layoutadmindetil>
            <MemoHelmet />
            <MemoNavBreadcrumb />
            <MemoAppbarku />
            <div className={`p-4 text-${textColor}`}>
                <h1 className='hidden'>Halaman Tambah Psikotest Kecermatan Baru | Admin</h1>
                <Box component="form"
                    sx={{ '& > :not(style)': { marginTop: 2, p: 0, width: '100%' } }}
                    onSubmit={(e) => submit(e)}
                    noValidate
                    autoComplete="off">
                    <TextField  type="text" id="kolom_x" variant="outlined" focused
                                placeholder="Kolom..." label="Kolom..."
                                fullWidth sx={styledTextField}
                                onChange={handleChange_kolom_x}
                                defaultValue={kolom_x} />
                    <TextField  type="number" id="nilai_a" variant="outlined" focused
                                placeholder="Nilai A..." label="Nilai A..."
                                fullWidth sx={styledTextField}
                                onChange={handleChange_nilai_A}
                                defaultValue={nilai_A} />
                    <TextField  type="number" id="nilai_b" variant="outlined" focused
                                placeholder="Nilai B..." label="Nilai B..."
                                fullWidth sx={styledTextField}
                                onChange={handleChange_nilai_B}
                                defaultValue={nilai_B} />
                    <TextField  type="number" id="nilai_c" variant="outlined" focused
                                placeholder="Nilai C..." label="Nilai C..."
                                fullWidth sx={styledTextField}
                                onChange={handleChange_nilai_C}
                                defaultValue={nilai_C} />
                    <TextField  type="number" id="nilai_d" variant="outlined" focused
                                placeholder="Nilai D..." label="Nilai D..."
                                fullWidth sx={styledTextField}
                                onChange={handleChange_nilai_D}
                                defaultValue={nilai_D} />
                    <TextField  type="number" id="nilai_e" variant="outlined" focused
                                placeholder="Nilai E..." label="Nilai E..."
                                fullWidth sx={styledTextField}
                                onChange={handleChange_nilai_E}
                                defaultValue={nilai_E} />
                    <Box>
                        <div>
                            <Button variant="contained" size="large" fullWidth color="primary" type="submit">
                                Simpan
                            </Button>
                        </div>
                        <div className="mt-4">
                            <Button variant="contained" size="large" fullWidth color="secondary" onClick={(e) => cancel(e)} rel='follow' title='Kembali' href='/admin/psikotest/kecermatan' type="button">
                                Batal
                            </Button>
                        </div>
                    </Box>
                </Box>
            </div>
            <MemoFooter />
        </Layoutadmindetil>
    </>
    );
}
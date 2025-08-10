// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
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

export default function PsikotestKecermatanDetilBaru(props) {
    const textColor = DOMPurify.sanitize(localStorage.getItem('text-color'));
    const textColorRGB = DOMPurify.sanitize(localStorage.getItem('text-color-rgb'));
    const borderColor = DOMPurify.sanitize(localStorage.getItem('border-color'));
    const borderColorRGB = DOMPurify.sanitize(localStorage.getItem('border-color-rgb'));
    const [loading, setLoading] = React.useState(false);
    const [pkid, setPkid] = React.useState(DOMPurify.sanitize(sessionStorage.getItem('admin_psikotest_kecermatan_id')));
    const [lastpage, setLastpage] = React.useState(DOMPurify.sanitize(sessionStorage.getItem('admin_psikotest_kecermatan_tabellastpage')));

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

    const [soalA, setSoalA] = React.useState(0);
    const handleChange_soalA = (event) => {
        setSoalA(DOMPurify.sanitize(event.target.value));
    };

    const [soalB, setSoalB] = React.useState(0);
    const handleChange_soalB = (event) => {
        setSoalB(DOMPurify.sanitize(event.target.value));
    };

    const [soalC, setSoalC] = React.useState(0);
    const handleChange_soalC = (event) => {
        setSoalC(DOMPurify.sanitize(event.target.value));
    };

    const [soalD, setSoalD] = React.useState(0);
    const handleChange_soalD = (event) => {
        setSoalD(DOMPurify.sanitize(event.target.value));
    };

    const [jawaban, setJawaban] = React.useState(0);
    const handleChange_jawaban = (event) => {
        setJawaban(DOMPurify.sanitize(event.target.value));
    };

    const getData = () => {
        setLoading(true);
        try {
            setPkid(DOMPurify.sanitize(sessionStorage.getItem('admin_psikotest_kecermatan_id')));
            setLastpage(DOMPurify.sanitize(sessionStorage.getItem('admin_psikotest_kecermatan_tabellastpage')));
        }
        catch(err) {
            console.info('Terjadi Error PsikotestKecermatanDetilBaru-getData:', err);
        }
        setLoading(false);
    }

    // eslint-disable-next-line react-hooks/exhaustive-deps
    React.useEffect(() => {
        getData();
    }, []);

    if(loading) {
        return (
            <h2 className={`text-center p-8 font-bold text-2lg text-${textColor}`}>
                <p>Sedang memuat data...<br/></p>
                <p>Mohon Harap Tunggu...</p>
                <CircularProgress color="info" size={50} />
            </h2>
        );
    }

    const submit = async(e) => {
        e.preventDefault();
        setLoading(true);
        try {
            const validNumberRange = {
                min : 1,
                max : 9
            };
            if( validator.isInt(soalA, validNumberRange) &&
                validator.isInt(soalB, validNumberRange) &&
                validator.isInt(soalC, validNumberRange) &&
                validator.isInt(soalD, validNumberRange)
            ) {
                const soaljawaban = {
                    soal: [[
                        parseInt(soalA),
                        parseInt(soalB),
                        parseInt(soalC),
                        parseInt(soalD)
                    ]],
                    jawaban: parseInt(jawaban)
                };
                axios.defaults.withCredentials = true;
                axios.defaults.withXSRFToken = true;
                const csrfToken = await axios.get(`/sanctum/csrf-cookie`, {
                    withCredentials: true,  // Mengirimkan cookie dalam permintaan
                });
                const response = await axios.post(`/api/kecermatan/soaljawaban/${DOMPurify.sanitize(pkid)}`, {
                    soal_jawaban: soaljawaban,
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
                    // router.push(`/admin/psikotest/kecermatan/detil/?page=${lastpage}`);
                    window.location.href = `/admin/psikotest/kecermatan/detil/${lastpage}`;
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
            console.info('Terjadi Kesalahan PsikotestKecermatanDetilBaru-submit:', err);
        }
        setLoading(false);
    };

    const cancel = (e) => {
        e.preventDefault();
        setLoading(true);
        // router.push(`/admin/psikotest/kecermatan/detil/?page=${lastpage}`);
        window.location.href = `/admin/psikotest/kecermatan/detil/${lastpage}`;
    };

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
            <Appbarku headTitle="Detil Psikotest Kecermatan" />
        );
    });

    const MemoNavBreadcrumb = React.memo(function Memo() {
        return(
            <NavBreadcrumb content={`Admin / Psikotest / Kecermatan / Detil / Baru`} hidden={`hidden`} />
        );
    });

    const MemoFooter = React.memo(function Memo() {
        return(
            <Footer hidden={`hidden`} />
        );
    });

    return(
    <>
        <Layoutadmindetil>
            <MemoHelmet />
            <MemoAppbarku />
            <MemoNavBreadcrumb />
            <div className="p-4">
                <h1 className='hidden'>Halaman Psikotest Kecermatan Detil Baru | Admin </h1>
                <h2 className={`font-bold text-center text-lg text-${textColor}`}>Tambah Soal dan Jawaban Psikotest Kecermatan Kolom {pkid} Baru</h2>
                <h3 className={`mt-4 text-${textColor}`}>
                    <span className='font-bold mr-2'>Soal :</span>
                    [
                        <span className='ml-2 mr-2'>{soalA}</span>
                        <span className='mr-2'>{soalB}</span>
                        <span className='mr-2'>{soalC}</span>
                        <span className='mr-2'>{soalD}</span>
                    ]
                </h3>
                <h3 className={`mt-2 text-${textColor}`}><span className='font-bold'>Jawaban :</span> {jawaban}</h3>
                <Box component="form"
                    sx={{ '& > :not(style)': { marginTop: 2, p: 1, width: '100%' } }}
                    onSubmit={(e) => submit(e)}
                    noValidate
                    autoComplete="off">
                    <TextField type="number" id={`soala`} label="Soal A"
                                onChange={handleChange_soalA} focused
                                defaultValue={soalA} variant="outlined"
                                sx={styledTextField} />
                    <TextField type="number" id={`soalb`} label="Soal B"
                                onChange={handleChange_soalB} focused
                                defaultValue={soalB} variant="outlined"
                                sx={styledTextField} />
                    <TextField type="number" id={`soalc`} label="Soal C"
                                onChange={handleChange_soalC} focused
                                defaultValue={soalC} variant="outlined"
                                sx={styledTextField} />
                    <TextField type="number" id={`soald`} label="Soal D"
                                onChange={handleChange_soalD} focused
                                defaultValue={soalD} variant="outlined"
                                sx={styledTextField} />
                    <TextField type="number" id={`jawaban`} label="Jawaban"
                                onChange={handleChange_jawaban} focused
                                defaultValue={jawaban} variant="outlined"
                                sx={styledTextField} />
                    <Box>
                        <div>
                            <Button variant="contained" size="large" color="primary" fullWidth type="submit">
                                Simpan
                            </Button>
                        </div>
                        <div className="mt-2">
                            <Button variant="contained" size="large" color="secondary" fullWidth onClick={(e) => cancel(e)} sx={{marginTop: 2}} type="button">
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
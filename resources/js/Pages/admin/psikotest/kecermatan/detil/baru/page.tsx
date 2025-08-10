// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
'use client';
import Layoutadmindetil from '@/Layouts/Layoutadmindetil.tsx';
import axios from 'axios';
import PropTypes from 'prop-types';
import * as React from 'react';

import Box from '@mui/material/Box';
import Button from '@mui/material/Button';
import TextField from '@mui/material/TextField';
import CircularProgress from '@mui/material/CircularProgress';

import Appbarku from '@/components/Appbarku.tsx';
import NavBreadcrumb from '@/components/NavBreadcrumb.tsx';
import Footer from '@/components/Footer.tsx';

import validator from 'validator';
import DOMPurify from 'dompurify';

interface AdminPsikotestKecermatanDetilBaru {
    // Define any props you expect to pass to the component here
    // For example: title?: string;
    title: string;
    token: string;
    unique: string;
    nama: string;
    pat: string;
    rtk: string;
    email: string;
    page: string;
}

AdminPsikotestKecermatanDetilBaru.propTypes = {
    title: PropTypes.string,
    token: PropTypes.string,
    unique: PropTypes.string,
    nama: PropTypes.string,
    pat: PropTypes.string,
    rtk: PropTypes.string,
    email: PropTypes.string,
    page: PropTypes.string,
};

export default function AdminPsikotestKecermatanDetilBaru(props: AdminPsikotestKecermatanDetilBaru) {
    const textColor: string|any = DOMPurify.sanitize(localStorage.getItem('text-color'));
    const textColorRGB: string|any = DOMPurify.sanitize(localStorage.getItem('text-color-rgb'));
    const borderColor: string|any = DOMPurify.sanitize(localStorage.getItem('border-color'));
    const borderColorRGB: string|any = DOMPurify.sanitize(localStorage.getItem('border-color-rgb'));
    
    const [loading, setLoading] = React.useState<boolean>(false);
    // const [pkid, setPkid] = React.useState(DOMPurify.sanitize(sessionStorage.getItem('admin_psikotest_kecermatan_id')));
    const pkid: number = parseInt(props.id);
    const [lastpage, setLastpage] = React.useState<number>(parseInt(DOMPurify.sanitize(sessionStorage.getItem('admin_psikotest_kecermatan_tabellastpage'))));
    const urlBack: string = `/admin/psikotest/kecermatan/detil/${pkid}?page=${lastpage}`;

    const styledTextField = {
        '& .MuiOutlinedInput-notchedOutline': {
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
            color: '#fff',
        },
        '&:hover .MuiOutlinedInput-notchedOutline': {
            // borderColor: 'rgba(255, 255, 255, 0.8)', // warna hover
        },
        '&:hover .MuiInputLabel-root': {
            color: '#fff', // warna hover
        },
        '& .MuiFormHelperText-root': {
            color: '#fff',  // Warna helper text
        },
        background: 'rgba(0, 0, 0, 0.6)',
        borderRadius: 3,
    }

    const styledButton = {
        borderRadius: 3
    }

    const [soalA, setSoalA] = React.useState<number>(0);
    const handleChange_soalA = (event: any) => {
        setSoalA(parseInt(DOMPurify.sanitize(event.target.value)));
    };

    const [soalB, setSoalB] = React.useState<number>(0);
    const handleChange_soalB = (event: any) => {
        setSoalB(parseInt(DOMPurify.sanitize(event.target.value)));
    };

    const [soalC, setSoalC] = React.useState<number>(0);
    const handleChange_soalC = (event: any) => {
        setSoalC(parseInt(DOMPurify.sanitize(event.target.value)));
    };

    const [soalD, setSoalD] = React.useState<number>(0);
    const handleChange_soalD = (event: any) => {
        setSoalD(parseInt(DOMPurify.sanitize(event.target.value)));
    };

    const [jawaban, setJawaban] = React.useState<number>(0);
    const handleChange_jawaban = (event: any) => {
        setJawaban(parseInt(DOMPurify.sanitize(event.target.value)));
    };

    const getData = () => {
        setLoading(true);
        try {
            // setPkid(DOMPurify.sanitize(sessionStorage.getItem('admin_psikotest_kecermatan_id')));
            setLastpage(parseInt(DOMPurify.sanitize(sessionStorage.getItem('admin_psikotest_kecermatan_tabellastpage'))));
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

    const submit = async(e: any) => {
        e.preventDefault();
        setLoading(true);
        try {
            const validNumberRange = {
                min : 1,
                max : 9
            };
            if( validator.isInt(soalA.toString(), validNumberRange) &&
                validator.isInt(soalB.toString(), validNumberRange) &&
                validator.isInt(soalC.toString(), validNumberRange) &&
                validator.isInt(soalD.toString(), validNumberRange)
            ) {
                const soaljawaban = {
                    soal: [[
                        soalA,
                        soalB,
                        soalC,
                        soalD
                    ]],
                    jawaban: jawaban
                };
                const token: string = props.token;
                const pat: string = props.pat;
                const rtk: string = props.rtk;
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
                // console.log('response', response);
                if(response.data.success) {
                    window.location.href = urlBack;
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

    const cancel = (e: any) => {
        e.preventDefault();
        setLoading(true);
        window.location.href = urlBack;
    };

    const MemoAppbarku = React.memo(function Memo() {
        return(
            <Appbarku user={props.nama} headTitle="Detil Psikotest Kecermatan" isback={true} url={urlBack} />
        );
    });

    const MemoNavBreadcrumb = React.memo(function Memo() {
        return(
            <NavBreadcrumb content={`Admin / Psikotest / Kecermatan / Detil / Baru`} hidden={`hidden`} />
        );
    });

    const MemoFooter = React.memo(function Memo() {
        return(
            <Footer hidden={`hidden`} otherCSS={''} />
        );
    });

    return(
        <Layoutadmindetil>
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
                    sx={{ '& > :not(style)': { marginTop: 2, width: '100%' } }}
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
                        <Button variant="contained" size="large" color="primary" fullWidth type="submit" sx={styledButton}>
                            Simpan
                        </Button>
                    </Box>
                    <Box>
                        <Button variant="contained" size="large" color="secondary" fullWidth onClick={(e) => cancel(e)} type="button" sx={styledButton}>
                            Batal
                        </Button>
                    </Box>
                </Box>
            </div>
            <MemoFooter />
        </Layoutadmindetil>
    );
}
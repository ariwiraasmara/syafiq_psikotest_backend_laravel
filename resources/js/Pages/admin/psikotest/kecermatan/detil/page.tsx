// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
'use client';
import Layoutadmindetil from '@/Layouts/Layoutadmindetil.tsx';
import axios from 'axios';
import * as React from 'react';
import PropTypes from 'prop-types';

import IconButton from '@mui/material/IconButton';
import Link from '@mui/material/Link';
import CircularProgress from '@mui/material/CircularProgress';
import Paper from '@mui/material/Paper';
import Table from '@mui/material/Table';
import TableContainer from '@mui/material/TableContainer';
import TableHead from '@mui/material/TableHead';
import TableBody from '@mui/material/TableBody';
import TableFooter from '@mui/material/TableFooter';
import TableRow from '@mui/material/TableRow';
import TableCell from '@mui/material/TableCell';

import AddIcon from '@mui/icons-material/Add';
import EditIcon from '@mui/icons-material/Edit';
import DeleteIcon from '@mui/icons-material/Delete';

import Appbarku from '@/components/Appbarku.tsx';
import NavBreadcrumb from '@/components/NavBreadcrumb.tsx';
import Footer from '@/components/Footer.tsx';
import ComboPaging from '@/components/ComboPaging.tsx';

import Swal from 'sweetalert2'
import validator from 'validator';
import DOMPurify from 'dompurify';

interface AdminDetilPsikotestKecermatan {
    // Define any props you expect to pass to the component here
    // For example: title?: string;
    title: string;
    token: string;
    unique: string;
    nama: string;
    pat: string;
    rtk: string;
    email: string;
    id: string;
}

AdminDetilPsikotestKecermatan.propTypes = {
    title: PropTypes.string,
    token: PropTypes.string,
    unique: PropTypes.string,
    nama: PropTypes.string,
    pat: PropTypes.string,
    rtk: PropTypes.string,
    email: PropTypes.string,
    id: PropTypes.string,
};

export default function AdminDetilPsikotestKecermatan(props: AdminDetilPsikotestKecermatan) {
    const textColor: string|any = DOMPurify.sanitize(localStorage.getItem('text-color'));
    const textColorRGB: string|any = DOMPurify.sanitize(localStorage.getItem('text-color-rgb'));
    const borderColor: string|any = DOMPurify.sanitize(localStorage.getItem('border-color'));
    const borderColorRGB: string|any = DOMPurify.sanitize(localStorage.getItem('border-color-rgb'));
    
    // const [pkid, setPkid] = React.useState(0);
    // const pkid = DOMPurify.sanitize(sessionStorage.getItem('admin_psikotest_kecermatan_id'));
    const pkid: number = parseInt(props.id);
    const [dataPertanyaan, setDataPertanyaan] = React.useState<any>([]);
    const [dataSoalJawaban, setDataSoalJawaban] = React.useState<any>([]);
    const [loading, setLoading] = React.useState<boolean>(false);

    // paging
    let currentpage: number = 1;
    // console.log('currentPage', currentpage);
    const [lastpage, setLastpage] = React.useState(1);
    let numbertable = 0;
    if(currentpage == 1) numbertable = 1;
    else if(currentpage == 2) numbertable = 11;
    else if(currentpage == 3) numbertable = 21;
    else if(currentpage == 4) numbertable = 31;
    else if(currentpage == 5) numbertable = 41;

    const tableHeaderColumnNumber = {
        p: 2,
        borderBottom: '1px solid #000',
        borderRight: '1px solid #000',
        color: '#000',
        textAlign: 'center',
        fontWeight: 'bold',
        minWidth: 50
    }

    const tableHeaderColumnsStyle = {
        p: 2,
        borderBottom: '1px solid #000',
        color: '#000',
        textAlign: 'center',
        fontWeight: 'bold',
        minWidth: 120
    }

    const tableBodyColumnNumber = {
        p: 2,
        borderRight: '1px solid #000',
        textAlign: 'right',
        color: '#000',
    }

    const tableBodyColumnStyle = {
        p: 2,
        textAlign: 'center',
        color: '#000',
    }

    const getData = async () => {
        setLoading(true); // Menandakan bahwa proses loading sedang berjalan
        try {
            const token: string = props.token;
            const pat: string = props.pat;
            const rtk: string = props.rtk;
            axios.defaults.withCredentials = true;
            axios.defaults.withXSRFToken = true;
            const csrfToken = await axios.get(`/sanctum/csrf-cookie`, {
                withCredentials: true,  // Mengirimkan cookie dalam permintaan
            });
            const response = await axios.get(`/api/kecermatan/soaljawaban/all/${pkid}?page=${currentpage}`, {
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
            if(response.data.data !== null) {
                setDataPertanyaan(response.data.data.pertanyaan[0]);
                setDataSoalJawaban(response.data.data.soaljawaban.data);
                setLastpage(response.data.data.soaljawaban.last_page);
            }
            else {
                setDataPertanyaan(null);
                setDataSoalJawaban(null);
                setLastpage(null);
            }
        } catch (error) {
            console.info('Terjadi Error AdminPsikotestKecermatanDetil-getData:', error);
        }
        setLoading(false);
    };

    // eslint-disable-next-line react-hooks/exhaustive-deps
    React.useEffect(() => {
        getData();
    }, []);
    // console.table('dataPertanyaan', dataPertanyaan);
    // console.table('dataSoalJawaban', dataSoalJawaban);

    if(loading) {
        return (
            <h2 className={`text-center p-8 font-bold text-2lg text-${textColor}`}>
                <p>Sedang memuat data...<br/></p>
                <p>Mohon Harap Tunggu...</p>
                <CircularProgress color="info" size={50} />
            </h2>
        );
    }

    const toAdd = (e: any) => {
        e.preventDefault();
        setLoading(true);
        try {
            sessionStorage.setItem('admin_psikotest_kecermatan_tabellastpage', DOMPurify.sanitize(currentpage));
            window.location.href = `/admin/psikotest/kecermatan/detil-baru/${pkid}`;
        }
        catch(err) {
            console.info('Terjadi Error DetilPsikotestKecermatanDetil-toAdd', err);
        }
    }

    // const toEditPertanyaan = (e: any, id: number, kolom_x: string, nilai_a: number, nilai_b: number, nilai_c: number, nilai_d: number, jawaban: number) => {
    const toEditPertanyaan = (e: any) => {
        e.preventDefault();
        setLoading(true);
        // sessionStorage.setItem('admin_psikotest_kecermatan_id', DOMPurify.sanitize(id));
        // sessionStorage.setItem('admin_psikotest_kecermatan_nilai_A', DOMPurify.sanitize(nilai_a));
        // sessionStorage.setItem('admin_psikotest_kecermatan_nilai_B', DOMPurify.sanitize(nilai_b));
        // sessionStorage.setItem('admin_psikotest_kecermatan_nilai_C', DOMPurify.sanitize(nilai_c));
        // sessionStorage.setItem('admin_psikotest_kecermatan_nilai_D', DOMPurify.sanitize(nilai_d));
        // sessionStorage.setItem('admin_psikotest_kecermatan_jawaban', DOMPurify.sanitize(jawaban));
        window.location.href = `/admin/psikotest/kecermatan-edit/${pkid}`;
    }

    // const toEditSoalJawaban = (e: any, id: number, soalA: number, soalB: number, soalC: number, soalD: number, jawaban: number) => {
    const toEditSoalJawaban = (e: any, id: number) => {
        e.preventDefault();
        setLoading(true);
        try {
            // sessionStorage.setItem('admin_psikotest_kecermatan_id', DOMPurify.sanitize(pkid));
            // sessionStorage.setItem('admin_psikotest_kecermatan_idsoal', DOMPurify.sanitize(id));
            // sessionStorage.setItem('admin_psikotest_kecermatan_soalA', DOMPurify.sanitize(soalA));
            // sessionStorage.setItem('admin_psikotest_kecermatan_soalB', DOMPurify.sanitize(soalB));
            // sessionStorage.setItem('admin_psikotest_kecermatan_soalC', DOMPurify.sanitize(soalC));
            // sessionStorage.setItem('admin_psikotest_kecermatan_soalD', DOMPurify.sanitize(soalD));
            // sessionStorage.setItem('admin_psikotest_kecermatan_jawaban', DOMPurify.sanitize(jawaban));
            // sessionStorage.setItem('admin_psikotest_kecermatan_tabellastpage', DOMPurify.sanitize(currentpage));
            window.location.href = `/admin/psikotest/kecermatan/detil-edit/${pkid}/${id}`;
        }
        catch(err) {
            console.info('Terjadi Error DetilPsikotestKecermatanDetil-toEditSoalJawaban', err);
        }
    }

    const fDelete = async (e: any, id: number, soalA: number, soalB: number, soalC: number, soalE: number, jawaban: number) => {
        e.preventDefault();
        if(validator.isInt(id.toString(), {min: 1, gt: 0})) {
            Swal.fire({
                title: "Anda yakin ingin menghapus data soal dan jawaban ini?",
                html: `Soal : ${soalA}, ${soalB}, ${soalC}, ${soalE}<br/>Jawaban : ${jawaban}`,
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: "Ya",
                cancelButtonText: "Batalkan",
                icon: "warning",
                showLoaderOnConfirm: true,
                preConfirm: async () => {
                    try {
                        const pat: string = props.pat;
                        const rtk: string = props.rtk;
                        axios.defaults.withCredentials = true;
                        axios.defaults.withXSRFToken = true;
                        const csrfToken = await axios.get(`/sanctum/csrf-cookie`,  {
                            withCredentials: true,  // Mengirimkan cookie dalam permintaan
                        });
                        await axios.delete(`/api/kecermatan/soaljawaban/${DOMPurify.sanitize(pkid)}/${DOMPurify.sanitize(id)}`, {
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
                    } catch (error) {
                        // Swal.showValidationMessage(`Request failed: ${error}`);
                        console.info('Terjadi Error DetilPsikotestKecermatanDetil-fDelete', err);
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Terhapus!",
                        text: "Data Telah Berhasil Dihapus",
                        icon: "success"
                    }).then((res2) => {
                        if (res2.isConfirmed) {
                            location.reload();
                        }
                    });
                }
            });
        }
        else {
            alert('Invalid Credentials!');
        }
    }

    const MemoAppbarku = React.memo(function Memo() {
        return(
            <Appbarku user={props.nama} headTitle="Psikotest Kecermatan" isback={true} url={`/admin/psikotest`} />
        );
    });

    const MemoNavBreadcrumb = React.memo(function Memo() {
        return(
            <NavBreadcrumb content={`Admin / Psikotest / Kecermatan / Detil`} hidden={`hidden`} />
        );
    });

    const MemoFooter = React.memo(function Memo() {
        return(
            <Footer hidden={`hidden`} otherCSS={''} />
        );
    });

    return (
        <Layoutadmindetil>
            <MemoAppbarku />
            <MemoNavBreadcrumb />
            <div className={`p-0 mb-0 text-${textColor}`}>
                <h1 className='hidden'>Detil Halaman Psikotest Kecermatan {currentpage} | Admin</h1>
                {loading ? (
                    <h2 className='text-center'>
                        <p><span className='font-bold text-2lg'>
                            Sedang memuat data... Mohon Harap Tunggu...
                        </span></p>
                        <CircularProgress color="info" size={50} />
                    </h2>
                ) : (
                <>
                    <div className={`p-4 mb-10 text-${textColor}`}>
                        <h2 className='font-bold'>Detil Psikotest Kecermatan</h2>
                        <h2 className="font-bold">Pertanyaan {dataPertanyaan.kolom_x} : [
                            <span className='ml-2 mr-2'>{dataPertanyaan.nilai_A}</span>
                            <span className='mr-2'>{dataPertanyaan.nilai_B}</span>
                            <span className='mr-2'>{dataPertanyaan.nilai_C}</span>
                            <span className='mr-2'>{dataPertanyaan.nilai_D}</span>
                            <span className='mr-2'>{dataPertanyaan.nilai_E}</span>
                        ]
                            <span className='ml-4'>
                                <Link rel='nofollow' title={`Edit Data Pertanyaan`} href='#' onClick={(e: any) => toEditPertanyaan(e)}>
                                    <span className="mr-2"><EditIcon /></span>
                                </Link>
                            </span>
                        </h2>
                        <Paper className='shadow-xl' sx={{ marginTop: '20px', width: '100%', overflow: 'hidden', borderRadius: 2 }}>
                            <TableContainer sx={{ maxHeight: 350 }}>
                                <Table stickyHeader aria-label="sticky table">
                                    <TableHead>
                                        <TableRow>
                                            <TableCell sx={tableHeaderColumnNumber}>
                                                <span className="">#</span>
                                            </TableCell>
                                            <TableCell sx={tableHeaderColumnsStyle}>
                                                <span className="">Soal</span>
                                            </TableCell>
                                            <TableCell sx={tableHeaderColumnsStyle}>
                                                <span className="">Jawaban</span>
                                            </TableCell>
                                            <TableCell sx={tableHeaderColumnsStyle} colSpan={2}>
                                                <span className="">Edit / Delete</span>
                                            </TableCell>
                                        </TableRow>
                                    </TableHead>
                                    {dataSoalJawaban ? dataSoalJawaban.map((data: any, index: number) => (
                                        <TableBody key={index}>
                                            <TableRow>
                                                <TableCell sx={tableBodyColumnNumber}>
                                                    {numbertable++}
                                                </TableCell>
                                                <TableCell sx={tableBodyColumnStyle}>
                                                    {data.soal_jawaban.soal[0][0]}, {data.soal_jawaban.soal[0][1]}, {data.soal_jawaban.soal[0][2]}, {data.soal_jawaban.soal[0][3]}
                                                </TableCell>
                                                <TableCell sx={tableBodyColumnStyle}>
                                                    {data.soal_jawaban.jawaban}
                                                </TableCell>
                                                <TableCell sx={tableBodyColumnStyle}>
                                                    <Link rel='nofollow' title={`Edit Data`} href='#' onClick={(e: any) => toEditSoalJawaban(e, data.id)}>
                                                        <span className="mr-2"><EditIcon /></span>
                                                    </Link>
                                                </TableCell>
                                                <TableCell sx={tableBodyColumnStyle}>
                                                    <Link rel='nofollow' title={`Delete Data`} href='#' onClick={(e: any) => fDelete(e, data.id, data.soal_jawaban.soal[0][0], data.soal_jawaban.soal[0][1], data.soal_jawaban.soal[0][2], data.soal_jawaban.soal[0][3], data.soal_jawaban.jawaban)}>
                                                        <DeleteIcon />
                                                    </Link>
                                                </TableCell>
                                            </TableRow>
                                        </TableBody>
                                    )) : (
                                        <TableBody>
                                            <TableRow>
                                                <TableCell colSpan={6} sx={tableBodyColumnStyle}>
                                                    <span className='font-bold text-lg'>
                                                        Belum Ada Data<br/>
                                                        Data Kosong!
                                                    </span>
                                                </TableCell>
                                            </TableRow>
                                        </TableBody>
                                    )}
                                </Table>
                            </TableContainer>
                        </Paper>
                        <div className='mt-2 text-center'>
                            <IconButton onClick={(e: any) => toAdd(e)}
                                        aria-label="tambah" size="large"
                                        className='shadow-xl'
                                        sx={{
                                            background: '#1976d2',
                                            borderRadius: 100,
                                            color: '#fff'
                                        }}>
                                <AddIcon />
                            </IconButton>
                        </div>
                    </div>
                    <ComboPaging
                        title={`Psikotest Kecermatan Detil`}
                        bottom={`bottom-0`}
                        current={currentpage}
                        lastpage={lastpage}
                        link={`/admin/psikotest/kecermatan/detil`}
                    />
                </>
                )}
            </div>
            <MemoFooter />
        </Layoutadmindetil>
    );
}
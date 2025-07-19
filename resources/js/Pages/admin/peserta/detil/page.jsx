// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
'use client';
import Layoutadmindetil from '@/Layouts/Layoutadmindetil.jsx';
import axios from 'axios';
import * as React from 'react';
import Swal from 'sweetalert2';

import Box from '@mui/material/Box';
import Link from '@mui/material/Link';
import CircularProgress from '@mui/material/CircularProgress';
import Button from '@mui/material/Button';
import Modal from '@mui/material/Modal';
import List from '@mui/material/List';
import ListItem from '@mui/material/ListItem';
import ListItemText from '@mui/material/ListItemText';

import EditIcon from '@mui/icons-material/Edit';
import InfoIcon from '@mui/icons-material/Info';
import CloseIcon from '@mui/icons-material/Close';

import Myhelmet from '@/components/Myhelmet.jsx';
import Appbarku from '@/components/Appbarku.jsx';
import NavBreadcrumb from '@/components/NavBreadcrumb.jsx';
import Footer from '@/components/Footer.jsx';
import TabDataHasilPsikotestPesertaDetil from '@/components/admin/peserta/TabDataHasilPsikotestPesertaDetil';

import { readable, random } from '@/libraries/myfunction';
import validator from 'validator';
import DOMPurify from 'dompurify';
export default function AdminPesertaDetil(props) {
    const textColor = DOMPurify.sanitize(localStorage.getItem('text-color'));
    const textColorRGB = DOMPurify.sanitize(localStorage.getItem('text-color-rgb'));
    const borderColor = DOMPurify.sanitize(localStorage.getItem('border-color'));
    const borderColorRGB = DOMPurify.sanitize(localStorage.getItem('border-color-rgb'));
    const [sessionID, setSessionID] = React.useState(DOMPurify.sanitize(sessionStorage.getItem('admin_id_peserta')));
    const safeID = readable(sessionID);

    const [data, setData] = React.useState({});
    const [loading, setLoading] = React.useState(false);

    const [openModalInfo, setOpenModalInfo] = React.useState(false);
    const handleOpenModalInfo = () => setOpenModalInfo(true);
    const handleCloseModalInfo = () => setOpenModalInfo(false);

    const buttonStyle = {
        border: `3px solid ${borderColor}`,
        backgroundColor : 'rgba(255, 255, 255, 0.5)',
        color : textColor
    }

    const styleModalInfo = {
        position: 'absolute',
        top: '50%',
        left: '50%',
        transform: 'translate(-50%, -50%)',
        width: 400,
        bgcolor: 'background.paper',
        border: '2px solid #000',
        color: '#000',
        boxShadow: 24,
        p: 2,
        overflow: 'auto',
        maxHeight: 300,
        maxWidth: '90%',
    };

    const getData = async () => {
        setLoading(true); // Menandakan bahwa proses loading sedang berjalan
        try {
            setData(props.data[0]);
        } catch (error) {
            setData({});
            console.info('Terjadi Error AdminPesertaDetil-getData:', error);
        }
        setLoading(false);
    };

    // eslint-disable-next-line react-hooks/exhaustive-deps
    React.useEffect(() => {
        getData();
    }, []);
    // console.info('peserta-detil: id peserta', data.id);
    console.table('tabel peserta detil', props.data);

    if(loading) {
        return (
            <h2 className={`text-center p-8 font-bold text-2lg text-${textColor}`}>
                <p>Sedang memuat data...<br/></p>
                <p>Mohon Harap Tunggu...</p>
                <CircularProgress color="info" size={50} />
            </h2>
        );
    }

    const toEdit = (e, id, nama, no_indentitas, email, tgl, asal) => {
        e.preventDefault();
        setLoading(true);
        try {
            sessionStorage.setItem('admin_id_peserta', DOMPurify.sanitize(id));
            sessionStorage.setItem('admin_nama_peserta', DOMPurify.sanitize(nama));
            sessionStorage.setItem('admin_noidentitas_peserta', DOMPurify.sanitize(no_indentitas));
            sessionStorage.setItem('admin_email_peserta', DOMPurify.sanitize(email));
            sessionStorage.setItem('admin_tgllahir_peserta', DOMPurify.sanitize(tgl));
            sessionStorage.setItem('admin_asal_peserta', DOMPurify.sanitize(asal));
            // router.push(`/admin/peserta/edit`);
            window.location.href = '/admin/peserta-edit';
        }
        catch(err) {
            console.info('Terjadi Error AdminPesertaDetil-toEdit:', err);
        }
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
            <Appbarku headTitle={'Detil Peserta'} isback={true} url={`/admin/peserta/1`} />
        );
    });

    const MemoNavBreadcrumb = React.memo(function Memo() {
        return(
            <NavBreadcrumb content={`Admin / Peserta / Detil`} hidden={`hidden`} />
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
                <MemoAppbarku />
                <MemoNavBreadcrumb />
                <div className="p-4">
                    <h1 className='hidden'>Halaman Detil Peserta | Admin</h1>
                    {loading ? (
                        <h2 className={`text-center text-${textColor}`}>
                            <p>
                                <span className='font-bold text-2lg'>
                                    Sedang memuat data... Mohon Harap Tunggu...
                                </span>
                            </p>
                            <CircularProgress color="info" size={50} />
                        </h2>
                    ) : (
                        <div className={`text-${textColor}`}>
                            <div>
                                <p>
                                    <span className='mr-2'>
                                        <Link follow="nofollow" title={`Edit Data Peserta ${data.nama}`} href='#' onClick={(e) => toEdit(e, data.id, data.nama, data.no_identitas, data.email, data.tgl_lahir, data.asal)}>
                                            <EditIcon />
                                        </Link>
                                    </span>
                                    <span className="font-bold">Nama :</span> {DOMPurify.sanitize(data.nama)}
                                </p>
                                <p><span className="font-bold">No. Identitas :</span> {DOMPurify.sanitize(data.no_identitas)}</p>
                                <p><span className="font-bold">Email :</span> {DOMPurify.sanitize(data.email)}</p>
                                <p><span className="font-bold">Tanggal Lahir :</span> {DOMPurify.sanitize(data.tgl_lahir)}</p>
                                <p><span className="font-bold">Usia :</span> {DOMPurify.sanitize(data.usia)}</p>
                                <p><span className="font-bold">Asal : </span> {DOMPurify.sanitize(data.asal)}</p>
                            </div>

                            <div className="mt-4">
                                <div className='text-right'>
                                    <Button variant="outlined" color="info" size="small" onClick={handleOpenModalInfo} sx={buttonStyle}>
                                        <InfoIcon />
                                    </Button>
                                </div>
                                <TabDataHasilPsikotestPesertaDetil
                                    peserta_id={safeID}
                                    no_identitas={data.no_identitas}
                                    textColor={textColor}
                                    borderColor={borderColor}
                                />
                            </div>
                        </div>
                    )}
                </div>
                <Modal
                    open={openModalInfo}
                    onClose={handleCloseModalInfo}
                    aria-labelledby="modal-modal-title"
                    aria-describedby="modal-modal-description"
                >
                    <Box sx={styleModalInfo}>
                        <div id="modal-modal-title">
                            <h2 className='font-bold underline'>Informasi dan Petunjuk Penggunaan</h2>
                        </div>
                        <div id="modal-modal-description" className='mt-2'>
                            <List>
                                <ListItem sx={{ borderBottom: '1px solid #ccc' }}>
                                    <ListItemText component="li">
                                        Ikon pensil disamping nama peserta merujuk ke halaman edit data peserta
                                    </ListItemText>
                                </ListItem>
                                <ListItem sx={{ borderBottom: '1px solid #ccc' }}>
                                    <ListItemText component="li">
                                        Tombol "Batal & Refresh" berfungsi sebagai untuk membatalkan hasil pencarian dan mengembalikan tampilan data ke awal.
                                    </ListItemText>
                                </ListItem>
                                <ListItem sx={{ borderBottom: '1px solid #ccc' }}>
                                    <ListItemText component="li">
                                        Terdapat 2 kotak untuk mengisi variabel tanggal.<br/><br/>
                                        Pada tab "Tabel" kemudian memilih salah satu jenis psikotest,
                                            dapat digunakan untuk mendapatkan 1 data dengan cara menyamakan data tanggal pada 2 field, sebagai contoh : "01-01-2024" dan "01-01-2024".<br/><br/>
                                        Sedangkan pada tab "Grafik", tidak dapat mendapatkan 1 data, dikarenakan hasil akhir pada grafik hanya akan menampilkan titik saja, tidak ada garis yang menghubungkan antara 2 variabel tanggal yang yang dipilih dan menghubungkan.
                                    </ListItemText>
                                </ListItem>
                            </List>
                        </div>
                        <div id="modal-modal-footer" className='mt-2'>
                            <Button variant="contained" color="warning" fullWidth size="small" onClick={handleCloseModalInfo}>
                                <CloseIcon />
                            </Button>
                        </div>
                    </Box>
                </Modal>
                <MemoFooter />
            </Layoutadmindetil>
        </>
    );
}

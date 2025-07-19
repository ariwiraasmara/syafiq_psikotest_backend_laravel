// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
'use client';
import './style.css';
import Layoutadmin from '@/Layouts/Layoutadmin.jsx';
import axios from 'axios';
import * as React from 'react';
import Swal from 'sweetalert2';

import Fab from '@mui/material/Fab';
import Button from '@mui/material/Button';
import InputAdornment from '@mui/material/InputAdornment';
import Link from '@mui/material/Link';
import CircularProgress from '@mui/material/CircularProgress';
import TextField from '@mui/material/TextField';
import MenuItem from '@mui/material/MenuItem';
import Select from '@mui/material/Select';

import AddIcon from '@mui/icons-material/Add';
import EditIcon from '@mui/icons-material/Edit';
import DeleteIcon from '@mui/icons-material/Delete';
import SearchIcon from '@mui/icons-material/Search';
import CloseIcon from '@mui/icons-material/Close';
import RefreshIcon from '@mui/icons-material/Refresh';

import Myhelmet from '@/components/Myhelmet.jsx';
import Appbarku from '@/components/Appbarku.jsx';
import NavBreadcrumb from '@/components/NavBreadcrumb.jsx';
import ComboPaging from '@/components/ComboPaging.jsx';
import Footer from '@/components/Footer.jsx';
import { readable, random, } from '@/libraries/myfunction';
import validator from 'validator';
import DOMPurify from 'dompurify';

export default function AdminVariabelSetting(props) {
    const textColor = DOMPurify.sanitize(localStorage.getItem('text-color'));
    const textColorRGB = DOMPurify.sanitize(localStorage.getItem('text-color-rgb'));
    const borderColor = DOMPurify.sanitize(localStorage.getItem('border-color'));
    const borderColorRGB = DOMPurify.sanitize(localStorage.getItem('border-color-rgb'));
    const [loading, setLoading] = React.useState(false);
    const [loadingData, setLoadingData] = React.useState(false);
    const [searchHidden, setSearchHidden] = React.useState('hidden');
    const [data, setData] = React.useState([]);
    const [sort, setSort] = React.useState('variabel');
    const [by, setBy] = React.useState('asc');
    const [toSearch, setToSearch] = React.useState('null');

    // paging
    let currentpage = parseInt(props.page);
    const [lastpage, setLastpage] = React.useState(1);

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
        }
    }

    const linkStyle = {
        color: textColorRGB
    }

    const getData = async() => {
        setLoadingData(true);
        try {
            axios.defaults.withCredentials = true;
            axios.defaults.withXSRFToken = true;
            const csrfToken = await axios.get(`/sanctum/csrf-cookie`, {
                withCredentials: true,  // Mengirimkan cookie dalam permintaan
            });
            const response = await axios.get(`/api/variabel-setting/${sort}/${by}/${toSearch}?page=${currentpage}`, {
                withCredentials: true,
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
            console.info('response', response);
            setData(response.data.data.data);
            setLastpage(response.data.data.last_page);
            // console.log('response', response);
        }
        catch(err) {
            console.info("Terjadi Error AdminVariabel-getData:", err);
        }
        setLoadingData(false);
    }


    // eslint-disable-next-line react-hooks/exhaustive-deps
    React.useEffect(() => {
        setLoading(true);
        getData();
        setLoading(false);
    }, [sort, by, toSearch]);

    console.table('tabel data variabel', data);

    if(loading) {
        return (
            <h2 className={`text-center p-8 font-bold text-2lg text-${textColor}`}>
                <p>Sedang memuat data...<br/></p>
                <p>Mohon Harap Tunggu...</p>
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
            <Appbarku headTitle="Variabel" />
        );
    });

    const MemoNavBreadcrumb = React.memo(function Memo() {
        return(
            <NavBreadcrumb content={`Admin / Variabel`} hidden={`hidden`} />
        );
    });

    const MemoFooter = React.memo(function Memo() {
        return(
            <Footer hidden={`hidden`} />
        );
    });

    const handleChange_searchHidden = (e) => {
        e.preventDefault();
        if(searchHidden == 'hidden') setSearchHidden('');
        else setSearchHidden('hidden');
    }

    const ButtonChange_searchHidden = () => {
        if(searchHidden == 'hidden') return(
            <Button variant="contained" color="primary"
                    size="small" aria-label="cari...."
                    onClick={(e) => handleChange_searchHidden(e)}
                    sx={{
                        color: '#fff',
                        marginTop: '-2px',
                        width: 5
                    }}>
                <SearchIcon fontSize="small" />
            </Button>
        );
        else return(
            <Button variant="contained" color="warning"
                    size="small" aria-label="cari...."
                    onClick={(e) => handleChange_searchHidden(e)}
                    sx={{
                        color: '#fff', marginTop: '-2px'
                    }}>
                <CloseIcon fontSize="small" />
            </Button>
        );
    }

    const handleChange_toSearch = (e) => {
        if( e.target.value === '' ||
            e.target.value === ' ' ||
            e.target.value === null) {
                setToSearch('null');
        }
        else {
            setToSearch(e.target.value);
        }
        currentpage = 1;
    };

    const handleChange_sort = (e) => {
        setSort(e.target.value);
        console.info('sort', sort);
    }

    const handleChange_by = (e) => {
        setBy(e.target.value);
        console.info('by', by);
    }

    const toAdd = (e) => {
        e.preventDefault();
        setLoading(true);
        // router.push('/admin/variabel/baru');
        window.location.href = '/admin/variabel-baru';
    }

    const toEdit = (e, id, nvariabel, nvalue) => {
        e.preventDefault();
        setLoading(true);
        sessionStorage.setItem('admin_variabel_id', DOMPurify.sanitize(id));
        sessionStorage.setItem('admin_variabel_variabel', DOMPurify.sanitize(nvariabel));
        sessionStorage.setItem('admin_variabel_values', DOMPurify.sanitize(nvalue));
        // router.push('/admin/variabel/edit');
        window.location.href = '/admin/variabel-edit';
    };

    const fDelete = async (e, id, nvariabel, nvalues) => {
        e.preventDefault();
        if(validator.isInt(id.toString(), {min: 1, gt: 0})) {
        Swal.fire({
            title: "Anda yakin ingin menghapus data variabel ini?",
            html: `<b>${nvariabel}</b> = <b>${nvalues}</b>`,
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonText: "Ya",
            cancelButtonText: "Batalkan",
            icon: "warning",
            showLoaderOnConfirm: true,
            preConfirm: async () => {
                try {
                    axios.defaults.withCredentials = true;
                    axios.defaults.withXSRFToken = true;
                    const csrfToken = await axios.get(`/sanctum/csrf-cookie`);
                    await axios.delete(`/api/variabel-setting/${id}`, {
                        withCredentials: true,
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
                    // Hapus item dari state variabels setelah sukses
                    setData((prev) => prev.filter((item) => item.id !== id));
                } catch (error) {
                    // Swal.showValidationMessage(`Request failed: ${error}`);
                    console.info('Terjadi Error AdminVariabel-fDelte:', error)
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Terhapus!",
                    text: "Data Telah Berhasil Dihapus",
                    icon: "success"
                });
            }
        });
        }
        else {
            alert('Invalid Credentials!');
        }
    };

    return (
        <Layoutadmin>
            <MemoHelmet />
            <MemoAppbarku  />
            <MemoNavBreadcrumb />
            <div className={`text-${textColor}`}>
                <h1 className="hidden">Halaman Variabel | Admin</h1>
                <div className={`mx-2 p-2 text-right`}>
                    <Button variant="contained" color="success" size="small" onClick={(e) => getData()} aria-label="cari...." sx={{ color: '#fff', marginTop: '-2px' }}>
                        <RefreshIcon fontSize="small" />
                    </Button>
                    <ButtonChange_searchHidden />
                    <Select
                        labelId="demo-simple-select-label"
                        id="demo-simple-select"
                        value={sort}
                        title={'Pilih Berdasarkan...'}
                        label={'Pilih Berdasarkan...'}
                        onChange={(e) => handleChange_sort(e)}
                        sx={{
                            border: `1px solid #000`,
                            backgroundColor: 'rgba(255, 255, 255, 1)',
                            color: '#000',
                            textAlign: 'right',
                            width: 150,
                            height: 30,
                        }}
                    >
                        <MenuItem value={`variabel`} selected={'variabel' === sort}>
                            Nama Variabel
                        </MenuItem>
                        <MenuItem value={`values`} selected={'values' === sort}>
                            Nilai Variabel
                        </MenuItem>
                    </Select>
                    <Select
                        labelId="demo-simple-select-label"
                        id="demo-simple-select"
                        value={by}
                        title={'Menaik atau Menurun...'}
                        label={'Menaik atau Menurun...'}
                        onChange={(e) => handleChange_by(e)}
                        sx={{
                            border: `1px solid #000`,
                            backgroundColor: 'rgba(255, 255, 255, 1)',
                            color: '#000',
                            textAlign: 'right',
                            width: 85,
                            height: 30,
                        }}
                    >
                        <MenuItem value={`asc`} selected={'asc' === sort}>
                            A - Z
                        </MenuItem>
                        <MenuItem value={`desc`} selected={'desc' === sort}>
                            Z - A
                        </MenuItem>
                    </Select>
                </div>
                <div className={`mx-2 p-2 ${searchHidden}`}>
                    <TextField label="Cari.." sx={styledTextField}
                        size="small" fullWidth
                        onChange={(e) => handleChange_toSearch(e)}
                        slotProps={{
                        input: {
                            startAdornment: (
                                <InputAdornment position="start">
                                    <SearchIcon sx={{ color: textColorRGB }} />
                                </InputAdornment>
                                ),
                            },
                        }}
                    />
                </div>
                {loadingData ? (
                    <h2 className={`text-center text-${textColor}`}>
                        <p><span className='font-bold text-2lg'>
                            Sedang memuat data... Mohon Harap Tunggu...
                        </span></p>
                        <CircularProgress color="info" size={50} />
                    </h2>
                ) : (<>
                    {data.length > 0 ? (
                        <div className='p-4 mb-32'>
                            {data.map((data, index) => (
                                <div key={index} className={`bg-slate-50 border-b-2 p-3 rounded-t-md mt-2 border-${borderColor}`}>
                                    <div className="static flex flex-row justify-between">
                                        <Link
                                            sx={linkStyle}
                                            className="mr-4"
                                            rel='nofollow'
                                            title={`${data.variabel} = ${data.values} detik`}
                                            onClick={(e) => toEdit(e, data.id, data.variabel, data.values)}
                                            href="#"
                                        >
                                            <div className={`order-first text-${textColor}`}>
                                                {data.variabel} = {data.values} detik
                                            </div>
                                        </Link>
                                        <div className="order-last">
                                            <span className='mr-6'>
                                                <Link
                                                    sx={linkStyle}
                                                    className="mr-6"
                                                    rel='nofollow'
                                                    title={`Edit Data`}
                                                    onClick={(e) => toEdit(e, data.id, data.variabel, data.values)}
                                                    href="#"
                                                >
                                                    <EditIcon />
                                                </Link>
                                            </span>
                                            <Link
                                                sx={linkStyle}
                                                rel='nofollow'
                                                title={`Delete Data`}
                                                onClick={(e) => fDelete(e, data.id, data.variabel, data.values)}
                                                href="#"
                                            >
                                                <DeleteIcon />
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    ) : (
                        <h2 className='font=bold text-center text-lg'>
                            Belum Ada Data<br/>
                            Data Kosong!
                        </h2>
                    )}
                </>)}
                <ComboPaging
                    title={`Variabel`}
                    bottom={`bottom-14`}
                    current={currentpage}
                    lastpage={lastpage}
                    link={`/admin/variabel`}
                />
                <Fab sx={{
                    position: 'fixed',
                    bottom: '12%',
                    right: '3%',
                }} color="primary" aria-label="add" rel='nofollow' title='Data Baru' href='#' onClick={(e) => toAdd(e)} >
                    <AddIcon />
                </Fab>
            </div>
            <MemoFooter />
        </Layoutadmin>
    );
}

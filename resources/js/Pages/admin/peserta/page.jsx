// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
'use client';
import Layoutadmin from '@/Layouts/Layoutadmin.jsx';
import axios from 'axios';
import * as React from 'react';

import Button from '@mui/material/Button';
import InputAdornment from '@mui/material/InputAdornment';
import CircularProgress from '@mui/material/CircularProgress';
import TextField from '@mui/material/TextField';
import MenuItem from '@mui/material/MenuItem';
import Select from '@mui/material/Select';

import SearchIcon from '@mui/icons-material/Search';
import CloseIcon from '@mui/icons-material/Close';
import RefreshIcon from '@mui/icons-material/Refresh';

import Myhelmet from '@/components/Myhelmet.jsx';
import Appbarku from '@/components/Appbarku.jsx';
import NavBreadcrumb from '@/components/NavBreadcrumb.jsx';
import ListPeserta from '@/components/admin/ListPeserta.jsx';
import Footer from '@/components/Footer.jsx';
import ComboPaging from '@/components/ComboPaging.jsx';

import { readable, random } from '@/libraries/myfunction';
import DOMPurify from 'dompurify';
export default function AdminPeserta(props) {
    const textColor = localStorage.getItem('text-color');
    const textColorRGB = localStorage.getItem('text-color-rgb');
    const borderColor = localStorage.getItem('border-color');
    const borderColorRGB = localStorage.getItem('border-color-rgb');
    const [loading, setLoading] = React.useState(true);
    const [loadingData, setLoadingData] = React.useState(true);
    const [searchHidden, setSearchHidden] = React.useState('hidden');
    const [data, setData] = React.useState([]);
    const [sort, setSort] = React.useState('nama');
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
            borderColor: borderColorRGB, // warna hover
        },
        '&:hover .MuiInputLabel-root': {
            color: textColorRGB, // warna hover
        }
    }
    
    const getData = async () => {
        setLoadingData(true);
        try {
            axios.defaults.withCredentials = true;
            axios.defaults.withXSRFToken = true;
            const csrfToken = await axios.get(`/sanctum/csrf-cookie`, {
                withCredentials: true
            });
            const response = await axios.get(`/api/peserta/${sort}/${by}/${toSearch}?page=${currentpage}`, {
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
            setData(response.data.data.data);
            setLastpage(response.data.data.last_page);
            // console.log('response', response);
        }
        catch(err) {
            console.info('Error AdminPeserta-getData:', err);
        }
        setLoadingData(false);
    }

    // eslint-disable-next-line react-hooks/exhaustive-deps
    React.useEffect(() => {
        setLoading(true);
        getData();
        setLoading(false);
    }, [sort, by, toSearch]);

    console.table('tabel peserta', data);

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
            <Appbarku headTitle="Peserta" />
        );
    });

    const MemoNavBreadcrumb = React.memo(function Memo() {
        return(
            <NavBreadcrumb content={`Admin / Peserta`} hidden={`hidden`} />
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
        return(
            searchHidden == 'hidden' ? (
                <Button variant="contained" color="primary"
                        size="small" aria-label="cari...."
                        onClick={(e) => handleChange_searchHidden(e)}
                        sx={{
                            color: '#fff',
                            marginTop: '-2px'
                        }}>
                    <SearchIcon fontSize="small" />
                </Button>
            ) : (
                <Button variant="contained" color="warning"
                        size="small" aria-label="cari...."
                        onClick={(e) => handleChange_searchHidden(e)}
                        sx={{
                            color: '#fff',
                            marginTop: '-2px'
                        }}>
                    <CloseIcon fontSize="small" />
                </Button>
            )
        );
    }

    const handleChange_toSearch = (e) => {
        if( e.target.value === '' ||
            e.target.value === ' ' ||
            e.target.value === null) {
                setToSearch('null');
        }
        else {
            setToSearch(DOMPurify.sanitize(e.target.value));
        }
        currentpage = 1;
    };

    const handleChange_sort = (e) => {
        setSort(DOMPurify.sanitize(e.target.value));
        console.info('sort', sort);
    }

    const handleChange_by = (e) => {
        setBy(DOMPurify.sanitize(e.target.value));
        console.info('by', by);
    }

    return (
        <Layoutadmin>
            <MemoHelmet />
            <MemoAppbarku />
            <MemoNavBreadcrumb />
            <div className={`text-${textColor}`}>
                <h1 className='hidden'>Halaman Daftar Peserta | Admin</h1>
                <div className={`mr-2 p-2 text-right`} sx={{ borderBottom: `1px solid ${borderColor}` }}>
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
                        <MenuItem value={`nama`} selected={'nama' === sort}>
                            Nama Peserta
                        </MenuItem>
                        <MenuItem value={`no_identitas`} selected={'no_identitas' === sort}>
                            Nomor Identitas Peserta
                        </MenuItem>
                        <MenuItem value={`asal`} selected={'asal' === sort}>
                            Asal Peserta
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
                <div className={`ml-2 mr-2 p-2 ${searchHidden}`}>
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
                ) : (
                    <div className='p-4 mb-32'>
                        <h2 className='hidden'>Daftar Peserta</h2>
                        <ListPeserta
                            listpeserta={data}
                            textColor={textColor}
                            borderColor={borderColor}
                            isLatest={false}
                        />
                    </div>
                )}
                <ComboPaging
                    title={`Peserta`}
                    bottom={`bottom-14`}
                    current={currentpage}
                    lastpage={lastpage}
                    link={`/admin/peserta`}
                />
            </div>
            <MemoFooter />
        </Layoutadmin>
    )
}
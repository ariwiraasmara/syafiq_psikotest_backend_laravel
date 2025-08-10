// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
'use client';
import Layoutadmin from '@/Layouts/Layoutadmin.tsx';
import axios from 'axios';
import * as React from 'react';
import PropTypes from 'prop-types';

import Button from '@mui/material/Button';
import InputAdornment from '@mui/material/InputAdornment';
import CircularProgress from '@mui/material/CircularProgress';
import TextField from '@mui/material/TextField';
import MenuItem from '@mui/material/MenuItem';
import Select from '@mui/material/Select';

import SearchIcon from '@mui/icons-material/Search';
import CloseIcon from '@mui/icons-material/Close';
import RefreshIcon from '@mui/icons-material/Refresh';

import Appbarku from '@/components/Appbarku.tsx';
import NavBreadcrumb from '@/components/NavBreadcrumb.tsx';
import ListPeserta from '@/components/admin/ListPeserta.tsx';
import Footer from '@/components/Footer.tsx';
import ComboPaging from '@/components/ComboPaging.tsx';

import validator from 'validator';
import DOMPurify from 'dompurify';

interface AdminPeserta {
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

AdminPeserta.propTypes = {
    title: PropTypes.string,
    token: PropTypes.string,
    unique: PropTypes.string,
    nama: PropTypes.string,
    pat: PropTypes.string,
    rtk: PropTypes.string,
    email: PropTypes.string,
    page: PropTypes.string,
};

export default function AdminPeserta(props: AdminPeserta) {
    const textColor: string|any = DOMPurify.sanitize(localStorage.getItem('text-color'));
    const textColorRGB: string|any = DOMPurify.sanitize(localStorage.getItem('text-color-rgb'));
    const borderColor: string|any = DOMPurify.sanitize(localStorage.getItem('border-color'));
    const borderColorRGB: string|any = DOMPurify.sanitize(localStorage.getItem('border-color-rgb'));
    
    const [loading, setLoading] = React.useState<boolean>(true);
    const [loadingData, setLoadingData] = React.useState<boolean>(true);
    const [searchHidden, setSearchHidden] = React.useState<string>('hidden');
    const [data, setData] = React.useState<any>([]);
    const [sort, setSort] = React.useState<string>('nama');
    const [by, setBy] = React.useState<string>('asc');
    const [toSearch, setToSearch] = React.useState<string>('null');

    // paging
    let currentpage: number = parseInt(props.page);
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
            const pat: string = props.pat;
            const rtk: string = props.rtk;
            axios.defaults.withCredentials = true;
            axios.defaults.withXSRFToken = true;
            const csrfToken: any = await axios.get(`/sanctum/csrf-cookie`, {
                withCredentials: true
            });
            const response: any = await axios.get(`/api/peserta/${sort}/${by}/${toSearch}?page=${currentpage}`, {
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
            // console.info(response);
            if(response.data.data !== null) {
                setData(response.data.data.data);
                setLastpage(response.data.data.last_page);
            }
            else {
                setData(null);
                setLastpage(1);
            }
            
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

    if(loading) {
        return (
            <h2 className={`text-center p-8 font-bold text-2lg text-${textColor}`}>
                <p>Sedang memuat data...<br/></p>
                <p>Mohon Harap Tunggu...</p>
                <CircularProgress color="info" size={50} />
            </h2>
        );
    }

    const MemoAppbarku = React.memo(function Memo() {
        return(
            <Appbarku user={props.nama} headTitle="Peserta" url={''} isback={false} />
        );
    });

    const MemoNavBreadcrumb = React.memo(function Memo() {
        return(
            <NavBreadcrumb content={`Admin / Peserta`} hidden={`hidden`} />
        );
    });

    const MemoFooter = React.memo(function Memo() {
        return(
            <Footer hidden={`hidden`} otherCSS={''} />
        );
    });

    const handleChange_searchHidden = (e: any) => {
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
                        fullWidth
                        sx={{
                            color: '#fff',
                        }}>
                    <SearchIcon fontSize="small" />
                </Button>
            ) : (
                <Button variant="contained" color="warning"
                        size="small" aria-label="cari...."
                        onClick={(e) => handleChange_searchHidden(e)}
                        fullWidth
                        sx={{
                            color: '#fff',
                        }}>
                    <CloseIcon fontSize="small" />
                </Button>
            )
        );
    }

    const handleChange_toSearch = (e: any) => {
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

    const handleChange_sort = (e: any) => {
        setSort(DOMPurify.sanitize(e.target.value));
        console.info('sort', sort);
    }

    const handleChange_by = (e: any) => {
        setBy(DOMPurify.sanitize(e.target.value));
        console.info('by', by);
    }

    return (
        <Layoutadmin navvar={2}>
            <MemoAppbarku />
            <MemoNavBreadcrumb />
            <div className={`text-${textColor}`}>
                <h1 className='hidden'>Halaman Daftar Peserta | Admin</h1>
                <div className={`p-2 flex w-full`} sx={{ borderBottom: `1px solid ${borderColor}` }}>
                    <div className="w-full p-0">
                        <Button variant="contained" color="success" size="small" fullWidth onClick={(e) => getData()} aria-label="cari...." sx={{ color: '#fff' }}>
                            <RefreshIcon fontSize="small" />
                        </Button>
                    </div>
                    <div className="w-full p-0">
                        <ButtonChange_searchHidden />
                    </div>
                    <div className="w-full p-0">
                        <Select
                            labelId="demo-simple-select-label"
                            id="demo-simple-select"
                            value={sort}
                            title={'Pilih Berdasarkan...'}
                            label={'Pilih Berdasarkan...'}
                            onChange={(e) => handleChange_sort(e)}
                            fullWidth
                            sx={{
                                border: `1px solid #000`,
                                backgroundColor: 'rgba(255, 255, 255, 1)',
                                color: '#000',
                                textAlign: 'right',
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
                    </div>
                    <div className="w-full p-0">
                        <Select
                            labelId="demo-simple-select-label"
                            id="demo-simple-select"
                            value={by}
                            title={'Menaik atau Menurun...'}
                            label={'Menaik atau Menurun...'}
                            onChange={(e) => handleChange_by(e)}
                            fullWidth
                            sx={{
                                border: `1px solid #000`,
                                backgroundColor: 'rgba(255, 255, 255, 1)',
                                color: '#000',
                                textAlign: 'right',
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
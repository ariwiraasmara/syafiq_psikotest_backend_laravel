// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
'use client';
import './style.css';
import Layoutadmin from '@/Layouts/Layoutadmin.tsx';
import axios from 'axios';
import * as React from 'react';
import PropTypes from 'prop-types';
import Cookies from 'js-cookie';
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

import Appbarku from '@/components/Appbarku.tsx';
import NavBreadcrumb from '@/components/NavBreadcrumb.tsx';
import ComboPaging from '@/components/ComboPaging.tsx';
import Footer from '@/components/Footer.tsx';
import validator from 'validator';
import DOMPurify from 'dompurify';

interface AdminVariabelSetting {
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

AdminVariabelSetting.propTypes = {
    title: PropTypes.string,
    token: PropTypes.string,
    unique: PropTypes.string,
    nama: PropTypes.string,
    pat: PropTypes.string,
    rtk: PropTypes.string,
    email: PropTypes.string,
    page: PropTypes.string,
};

export default function AdminVariabelSetting(props: AdminVariabelSetting) {
    const textColor: string|any = DOMPurify.sanitize(localStorage.getItem('text-color'));
    const textColorRGB: string|any = DOMPurify.sanitize(localStorage.getItem('text-color-rgb'));
    const borderColor: string|any = DOMPurify.sanitize(localStorage.getItem('border-color'));
    const borderColorRGB: string|any = DOMPurify.sanitize(localStorage.getItem('border-color-rgb'));

    const [loading, setLoading] = React.useState<boolean>(false);
    const [loadingData, setLoadingData] = React.useState<boolean>(false);
    const [searchHidden, setSearchHidden] = React.useState<string>('hidden');
    const [data, setData] = React.useState<any>([]);
    const [sort, setSort] = React.useState<string>('variabel');
    const [by, setBy] = React.useState<string>('asc');
    const [toSearch, setToSearch] = React.useState<string>('-');

    // paging
    let currentpage: number = parseInt(props.page);
    const [lastpage, setLastpage] = React.useState<number>(1);

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
        background: '#fff'
    }

    const linkStyle = {
        color: textColorRGB
    }

    const getData = async() => {
        setLoadingData(true);
        try {
            const pat: string = props.pat;
            const rtk: string = props.rtk;
            axios.defaults.withCredentials = true;
            axios.defaults.withXSRFToken = true;
            const csrfToken: any = await axios.get(`/sanctum/csrf-cookie`, {
                withCredentials: true,  // Mengirimkan cookie dalam permintaan
            });
            const response: any = await axios.get(`/api/variabel-setting/${sort}/${by}/${toSearch}?page=${currentpage}`, {
                withCredentials: true,
                headers: {
                    'Content-Type': 'application/json',
                    'XSRF-TOKEN': csrfToken,
                    'islogin' : DOMPurify.sanitize(Cookies.get('islogin')),
                    'isadmin' : DOMPurify.sanitize(Cookies.get('isadmin')),
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
            // console.info('response', response);
            if(response.data.data !== null) {
                setData(response.data.data.data);
                setLastpage(response.data.data.last_page);
            }
            else {
                setData(null);
                setLastpage(1);
            }
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
            <Appbarku user={props.nama} headTitle={'Variabel'} url={''} isback={false}/>
        );
    });

    const MemoNavBreadcrumb = React.memo(function Memo() {
        return(
            <NavBreadcrumb content={`Admin / Variabel`} hidden={`hidden`} />
        );
    });

    const MemoFooter = React.memo(function Memo() {
        return(
            <Footer hidden={`hidden`} otherCSS={''} />
        );
    });

    const handleChange_searchHidden = (e:any) => {
        e.preventDefault();
        if(searchHidden == 'hidden') setSearchHidden('');
        else setSearchHidden('hidden');
    }

    const ButtonChange_searchHidden = () => {
        if(searchHidden == 'hidden') return(
            <Button variant="contained" color="primary"
                    size="small" aria-label="cari...."
                    onClick={(e) => handleChange_searchHidden(e)}
                    fullWidth
                    sx={{
                        color: '#fff',
                    }}>
                <SearchIcon fontSize="small" />
            </Button>
        );
        else return(
            <Button variant="contained" color="warning"
                    size="small" aria-label="cari...."
                    onClick={(e) => handleChange_searchHidden(e)}
                    fullWidth
                    sx={{
                        color: '#fff'
                    }}>
                <CloseIcon fontSize="small" />
            </Button>
        );
    }

    const handleChange_toSearch = (e:any) => {
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

    const handleChange_sort = (e:any) => {
        setSort(e.target.value);
        console.info('sort', sort);
    }

    const handleChange_by = (e:any) => {
        setBy(e.target.value);
        console.info('by', by);
    }

    const toAdd = (e:any) => {
        e.preventDefault();
        setLoading(true);
        // router.push('/admin/variabel/baru');
        window.location.href = '/admin/variabel-baru';
    }

    const toEdit = (e:any, id:number, nvariabel:string, nvalues:string) => {
        e.preventDefault();
        setLoading(true);
        // sessionStorage.setItem('admin_variabel_id', DOMPurify.sanitize(id));
        // sessionStorage.setItem('admin_variabel_variabel', DOMPurify.sanitize(nvariabel));
        // sessionStorage.setItem('admin_variabel_values', DOMPurify.sanitize(nvalue));
        // router.push('/admin/variabel/edit');
        window.location.href = `/admin/variabel-edit/${id}`;
    };

    const fDelete = async (e:any, id:number, nvariabel:string, nvalues:string) => {
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
                    const pat: string = props.pat;
                    const rtk: string = props.rtk;
                    axios.defaults.withCredentials = true;
                    axios.defaults.withXSRFToken = true;
                    const csrfToken: any = await axios.get(`/sanctum/csrf-cookie`);
                    await axios.delete(`/api/variabel-setting/${id}`, {
                        withCredentials: true,
                        headers: {
                            'Content-Type': 'application/json',
                            'XSRF-TOKEN': csrfToken,
                            'islogin' : DOMPurify.sanitize(Cookies.get('islogin')),
                            'isadmin' : DOMPurify.sanitize(Cookies.get('isadmin')),
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
                    // Hapus item dari state variabels setelah sukses
                    setData((prev: any) => prev.filter((item: any) => item.id !== id));
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
        <Layoutadmin navvar={4}>
            <MemoAppbarku  />
            <MemoNavBreadcrumb />
            <div className={`text-${textColor}`}>
                <h1 className="hidden">Halaman Variabel | Admin</h1>
                <div className={`p-2 flex w-full`}>
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
                            <MenuItem value={`variabel`} selected={'variabel' === sort}>
                                Nama Variabel
                            </MenuItem>
                            <MenuItem value={`values`} selected={'values' === sort}>
                                Nilai Variabel
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
                <div className={`mx-2 p-2 ${searchHidden}`}>
                    <TextField label="Cari.." sx={styledTextField}
                        size="small"
                        fullWidth
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
                            {data.map((data: any, index: number) => (
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

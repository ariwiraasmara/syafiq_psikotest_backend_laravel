// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara
import axios from 'axios';
import * as React from 'react';
import PropTypes from 'prop-types';
import Tabs from '@mui/material/Tabs';
import Tab from '@mui/material/Tab';
import Box from '@mui/material/Box';

import Button from '@mui/material/Button';
import TextField from '@mui/material/TextField';

import RestartAltIcon from '@mui/icons-material/RestartAlt';
import SearchIcon from '@mui/icons-material/Search';
import CircularProgress from '@mui/material/CircularProgress';

import TabelHasilPsikotestPesertaDetil_Peserta from './TabelHasilPsikotestPesertaDetil_Peserta.tsx';
import GrafikHasilPsikotestPesertaDetil_Peserta from './GrafikHasilPsikotestPesertaDetil_Peserta.tsx';

import DOMPurify from 'dompurify';

CustomTabPanel.propTypes = {
    children: PropTypes.any,
    index: PropTypes.number.isRequired,
    value: PropTypes.number.isRequired,
};

function CustomTabPanel(props: any) {
    const { children, value, index, ...other } = props;
    return (
        <div
            role="tabpanel"
            hidden={value !== index}
            id={`simple-tabpanel-${index}`}
            aria-labelledby={`simple-tab-${index}`}
            {...other}
        >
            {value === index && <Box sx={{ p: 3 }}>{children}</Box>}
        </div>
    );
}

function a11yProps(index: number) {
    return {
        id: `simple-tab-${index}`,
        'aria-controls': `simple-tabpanel-${index}`,
    };
}

interface HasilPsikotestKecermatan_Peserta {
    // Define any props you expect to pass to the component here
    // For example: title?: string;
    peserta_id: string;
    no_identitas: string;
    email: string;
    token: string;
    unique: string;
    pat: string;
    rtk: string;
    textColor: string;
    borderColor: string;
    data: any;
}

HasilPsikotestKecermatan_Peserta.propTypes = {
    peserta_id: PropTypes.string,
    no_identitas: PropTypes.string,
    email: PropTypes.string,
    token: PropTypes.string,
    unique: PropTypes.string,
    pat: PropTypes.string,
    rtk: PropTypes.string,
    textColor: PropTypes.string,
    borderColor: PropTypes.string,
    data: PropTypes.any,
};

export default function HasilPsikotestKecermatan_Peserta(props: HasilPsikotestKecermatan_Peserta) {
    const [dataLoading, setDataLoading] = React.useState<boolean>(false);
    const [data, setData] = React.useState<any>([]);

    const APIUrl_default = `/api/peserta/hasil/psikotest/kecermatan/${props.peserta_id}/-/-`;
    const [tglSearch_1, setTglSearch_1] = React.useState<string>('-');
    const [tglSearch_2, setTglSearch_2] = React.useState<string>('-');
    
    const [value, setValue] = React.useState<number>(0);
        
    const TabStyle = {
        color: '#000',
        background:  '#E6E6FF',
    };

    const styledTextField = {
        '& .MuiOutlinedInput-notchedOutline': {
            border: `2px solid ${props.borderColor}`,
            color: props.textColor
        },
        '& .MuiInputLabel-root': {
            color: props.textColor
        },
        '& .MuiOutlinedInput-input': {
            color: props.textColor
        },
        '& .MuiOutlinedInput-placeholder': {
            color: props.textColor
        },
        '&:hover .MuiOutlinedInput-notchedOutline': {
            borderColor: props.borderColor, // warna hover
        },
        '&:hover .MuiInputLabel-root': {
            color: props.textColor, // warna hover
        }
    }

    const getData = async (apiURL: string) => {
        setDataLoading(true);
        try {
            const pat: string = props.pat;
            const rtk: string = props.rtk;
            const unique: string = props.unique;
            const email: string = props.email;
            const csrfToken = await axios.get(`/sanctum/csrf-cookie`, {
                withCredentials: true,  // Mengirimkan cookie dalam permintaan
            });
            const response = await axios.get(apiURL, {
                withCredentials: true,  // Mengirimkan cookie dalam permintaan
                headers: {
                    'Content-Type': 'application/json',
                    'XSRF-TOKEN': csrfToken,
                    'islogin' : DOMPurify.sanitize(localStorage.getItem('islogin')),
                    'isadmin' : DOMPurify.sanitize(localStorage.getItem('isadmin')),
                    'Authorization': `Bearer ${pat}`,
                    'remember-token': rtk,
                    'tokenlogin': unique,
                    'email' : email,
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
            // console.info('response data peserta detil hasil', response);
            setData(response.data.data);
        } catch (err) {
            console.error('Error TabelHasilPsikotestPesertaDetil-getDataHasilPsikotesKecermatan:', err);
        }
        setDataLoading(false);
    }

    const handleChange = (event: React.SyntheticEvent, newValue: number) => {
        setValue(newValue);
    };

    const handleChange_tglSearch_1 = (e: any) => {
        if( e.target.value === '0000-00-00' ||
            e.target.value === null) {
                setTglSearch_1('null');
        }
        else {
            setTglSearch_1(DOMPurify.sanitize(e.target.value));
        }
    };

    const handleChange_tglSearch_2 = (e: any) => {
        if( e.target.value === '0000-00-00' ||
            e.target.value === null) {
                setTglSearch_2('null');
        }
        else {
            setTglSearch_2(DOMPurify.sanitize(e.target.value));
        }
    };

    const submitSearch = (e: any) => {
        e.preventDefault();
        getData(`/api/peserta/hasil/psikotest/kecermatan/${props.peserta_id}/${tglSearch_1}/${tglSearch_2}`);
    }

    const cancelSearch = (e: any) => {
        e.preventDefault();
        setTglSearch_1('-');
        setTglSearch_2('-');
        setDataLoading(true);
        getData(APIUrl_default);
        setDataLoading(false);
    }

    return(
        <React.StrictMode>
            <div className={`w-full rounded-t-xl p-4 mb-0 bg-white shadow-xl`}>
                <div className='font-bold'>
                    <h3 className='font-bold ml-2'>Cari Data...</h3>
                </div>
                <div className='static grid grid-cols-3 gap-2 mt-2'>
                    <div className=''>
                        <TextField type='date' sx={styledTextField}
                            size="small" fullWidth focused
                            value={tglSearch_1}
                            onChange={(e: any) => handleChange_tglSearch_1(e)}
                        />
                    </div>
                    <div className=''>
                        <TextField type='date' sx={styledTextField}
                            size="small" fullWidth focused
                            value={tglSearch_2}
                            onChange={(e: any) => handleChange_tglSearch_2(e)}
                        />
                    </div>
                    <div className=''>
                        <Button title='Cari Data' variant="contained" fullWidth color="primary" onClick={(e: any) => submitSearch(e)}>
                            <SearchIcon />
                        </Button>
                    </div>
                </div>
                <div className='mt-2'>
                    <Button title='Batal Cari Data dan Refresh Data' variant="contained" fullWidth color="warning" onClick={(e: any) => cancelSearch(e)} startIcon={<RestartAltIcon />}>
                        Batal & Refresh
                    </Button>
                </div>
            </div>

            <Tabs value={value}
                onChange={handleChange}
                aria-label="Detil Data Hasil Psikotest Peserta"
                variant="fullWidth" centered
                className='shadow-xl'
                sx={{
                }}
            >
                <Tab label="Tabel" {...a11yProps(0)} wrapped sx={TabStyle} />
                <Tab label="Grafik" {...a11yProps(1)} wrapped sx={TabStyle} />
            </Tabs>

            <CustomTabPanel value={value} index={0}>
                <TabelHasilPsikotestPesertaDetil_Peserta
                    peserta_id={props.peserta_id}
                    no_identitas={props.no_identitas}
                    token={props.token}
                    email={props.email}
                    pat={props.pat}
                    rtk={props.rtk}
                    unique={props.unique}
                    textColor={props.textColor}
                    borderColor={props.borderColor}
                    data={data}
                />
            </CustomTabPanel>
            <CustomTabPanel value={value} index={1}>
                <GrafikHasilPsikotestPesertaDetil_Peserta
                    peserta_id={props.peserta_id}
                    no_identitas={props.no_identitas}
                    token={props.token}
                    email={props.email}
                    pat={props.pat}
                    rtk={props.rtk}
                    unique={props.unique}
                    textColor={props.textColor}
                    borderColor={props.borderColor}
                    data={data}
                />
            </CustomTabPanel>
        </React.StrictMode>
    );
}
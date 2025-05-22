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

// import TabTabelHasilPsikotestPesertaDetil from './TabTabelHasilPsikotestPesertaDetil.tsx';
// import TabGrafikHasilPsikotestPesertaDetil from './TabGrafikHasilPsikotestPesertaDetil.tsx';
import HasilPsikotestKecermatan_Peserta from './HasilPsikotestKecermatan_Peserta.tsx';

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

interface TabDataHasilPsikotestPesertaDetil {
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
}

TabDataHasilPsikotestPesertaDetil.propTypes = {
    peserta_id: PropTypes.string,
    no_identitas: PropTypes.string,
    email: PropTypes.string,
    token: PropTypes.string,
    unique: PropTypes.string,
    pat: PropTypes.string,
    rtk: PropTypes.string,
    textColor: PropTypes.string,
    borderColor: PropTypes.string,
};

export default function TabDataHasilPsikotestPesertaDetil(props: TabDataHasilPsikotestPesertaDetil) {
    const [value, setValue] = React.useState(0);
    
    const handleChange = (event: React.SyntheticEvent, newValue: number) => {
        setValue(newValue);
    };

    const TabStyle = {
        color: props.textColor
    };

    // console.info('peserta-detil-TabDataHasilPsikotestPesertaDetil: id peserta', props.peserta_id);
    return (
        <React.StrictMode>
            <Box sx={{ width: '100%' }}>
                <Box sx={{ borderBottom: 1, borderColor: 'divider' }}>
                    <Tabs value={value}
                        onChange={handleChange}
                        aria-label="Detil Data Hasil Psikotest Peserta"
                        variant="fullWidth" centered
                    >
                        {/* <Tab label="Tabel" {...a11yProps(0)} wrapped sx={TabStyle} /> */}
                        <Tab label="Kecermatan" {...a11yProps(0)} wrapped sx={TabStyle} />
                    </Tabs>
                </Box>
                {/* <CustomTabPanel value={value} index={0}>
                    Intelegensia
                </CustomTabPanel> */}
                <CustomTabPanel value={value} index={0}>
                    <HasilPsikotestKecermatan_Peserta
                        peserta_id={props.peserta_id}
                        no_identitas={props.no_identitas}
                        token={props.token}
                        email={props.email}
                        pat={props.pat}
                        rtk={props.rtk}
                        unique={props.unique}
                        textColor={props.textColor}
                        borderColor={props.borderColor}
                    />
                </CustomTabPanel>
                {/* <CustomTabPanel value={value} index={0}>
                    <TabTabelHasilPsikotestPesertaDetil
                        peserta_id={props.peserta_id}
                        no_identitas={props.no_identitas}
                        token={props.token}
                        email={props.email}
                        pat={props.pat}
                        rtk={props.rtk}
                        unique={props.unique}
                        textColor={props.textColor}
                        borderColor={props.borderColor}
                    />
                </CustomTabPanel>
                <CustomTabPanel value={value} index={1}>
                    <TabGrafikHasilPsikotestPesertaDetil
                        peserta_id={props.peserta_id}
                        no_identitas={props.no_identitas}
                        token={props.token}
                        email={props.email}
                        pat={props.pat}
                        rtk={props.rtk}
                        unique={props.unique}
                        textColor={props.textColor}
                        borderColor={props.borderColor}
                    />
                </CustomTabPanel> */}
            </Box>
        </React.StrictMode>
    );
}

// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara
import * as React from 'react';
import PropTypes from 'prop-types';
import Tabs from '@mui/material/Tabs';
import Tab from '@mui/material/Tab';
import Box from '@mui/material/Box';
import PesertaDetil_GrafikKecermatan from './GrafikHasilPsikotestPesertaDetil_Peserta.jsx';

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

CustomTabPanel.propTypes = {
    children: PropTypes.node,
    index: PropTypes.number.isRequired,
    value: PropTypes.number.isRequired,
};

function a11yProps(index: number) {
    return {
        id: `simple-tab-${index}`,
        'aria-controls': `simple-tabpanel-${index}`,
    };
}

const TabStyle = {
    color: '#fff'
};

interface TabGrafikHasilPsikotestPesertaDetil {
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

TabGrafikHasilPsikotestPesertaDetil.propTypes = {
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

export default function TabGrafikHasilPsikotestPesertaDetil(props: TabGrafikHasilPsikotestPesertaDetil) {
    const [value, setValue] = React.useState<number>(0);

    const handleChange = (event: any, newValue) => {
        setValue(newValue);
    };
    
    // console.info('TabHasilPsikotestPeserta peserta_id', props.peserta_id);
    return (
        <React.StrictMode>
            <Box sx={{ width: '100%' }}>
                <Box sx={{ borderBottom: 1, borderColor: 'divider' }}>
                    <Tabs value={value}
                        onChange={handleChange}
                        aria-label="Hasil Psikotest"
                        variant="fullWidth" centered
                    >
                        <Tab label="Kecermatan" {...a11yProps(0)} wrapped sx={TabStyle} />

                        {/* <Tab label="Item Two" {...a11yProps(1)} wrapped sx={TabStyle} />
                        <Tab label="Item Three" {...a11yProps(2)} wrapped sx={TabStyle} /> */}
                    </Tabs>
                </Box>
                <CustomTabPanel value={value} index={0}>
                    <PesertaDetil_GrafikKecermatan
                        peserta_id={props.peserta_id}
                        no_identitas={props.no_identitas}
                        token={props.token}
                        unique={props.unique}
                        email={props.email}
                        pat={props.pat}
                        rtk={props.rtk}
                        textColor={props.textColor}
                        borderColor={props.borderColor}
                    />
                </CustomTabPanel>

                {/* <CustomTabPanel value={value} index={1}>
                    Item Two
                </CustomTabPanel>
                <CustomTabPanel value={value} index={2}>
                    Item Three
                </CustomTabPanel> */}
            </Box>
        </React.StrictMode>
    );
}
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
import * as React from 'react';
import axios from 'axios';
// import { useRouter } from 'next/navigation';
import BottomNavigation from '@mui/material/BottomNavigation';
import BottomNavigationAction from '@mui/material/BottomNavigationAction';
import PropTypes from 'prop-types';

import HomeOutlinedIcon from '@mui/icons-material/HomeOutlined';
import PeopleAltOutlinedIcon from '@mui/icons-material/PeopleAltOutlined';
import AssignmentOutlinedIcon from '@mui/icons-material/AssignmentOutlined';
import AppSettingsAltOutlinedIcon from '@mui/icons-material/AppSettingsAltOutlined';
import LogoutIcon from '@mui/icons-material/Logout';

NavigasiBawah.propTypes = {
    title: PropTypes.string,
    link: PropTypes.string,
    currentpage: PropTypes.number,
    lastpage: PropTypes.number
};

export default function NavigasiBawah(props) {
    const [selectedValue, setSelectedValue] = React.useState(0);
    
    const handleNavigationChange = (event) => {
        setSelectedValue(newValue);
    };

    const route = (url) => {
        window.location.href = url;
    }

    return(
        <React.StrictMode>
            <BottomNavigation
                value={selectedValue}
                onChange={handleNavigationChange}
                showLabels
                sx={{ position: 'fixed', bottom: 0, width: '100%', background: '#000' }}
            >
            <BottomNavigationAction
                label="Dashboard"
                icon={<HomeOutlinedIcon />}
                value={1}
                sx={{
                    color: '#fff',
                    backgroundColor: props.navvar === 1 ? 'rgba(25, 25, 255, 1)' : 'rgba(0, 0, 0, 1)',
                }}
                rel='follow'
                title='Halaman Dashboard | Admin'
                href='/admin/dashboard'
                onClick={(event) => route('/admin/dashboard') }
            />
            <BottomNavigationAction
                label="Peserta"
                icon={<PeopleAltOutlinedIcon />}
                value={2}
                sx={{
                    color: '#fff',
                    backgroundColor: props.navvar === 2 ? 'rgba(25, 25, 255, 1)' : 'rgba(0, 0, 0, 1)',
                }}
                rel='follow'
                title='Halaman Daftar Peserta | Admin'
                 href='/admin/peserta/-/-/-'
                onClick={(event) => route('/admin/peserta/-/-/-')}
            />
            <BottomNavigationAction
                label="Psikotest"
                icon={<AssignmentOutlinedIcon />}
                value={3}
                sx={{
                    color: '#fff',
                    backgroundColor: props.navvar === 3 ? 'rgba(25, 25, 255, 1)' : 'rgba(0, 0, 0, 1)',
                }}
                rel='follow'
                title='Halaman Daftar Psikotest | Admin'
                href='/admin/psikotest'
                onClick={(event) => route('/admin/psikotest')}
            />
            <BottomNavigationAction
                label="Variabel"
                icon={<AppSettingsAltOutlinedIcon />}
                value={4}
                sx={{
                    color: '#fff',
                    backgroundColor: props.navvar === 4 ? 'rgba(25, 25, 255, 1)' : 'rgba(0, 0, 0, 1)',
                }}
                rel='follow'
                title='Halaman Daftar Variabel | Admin'
                href='/admin/variabel-setting/-/-/-'
                onClick={(event) => route('/admin/variabel-setting/-/-/-')}
            />
            {/* <BottomNavigationAction
                label="Logout"
                defaultValue={4}
                icon={<LogoutIcon />}
                sx={{
                    color: '#fff',
                    '&.Mui-selected': {
                        color: '#fff',
                        backgroundColor: 'rgba(255, 255, 255, 0.2)',
                    },
                }}
                rel='follow'
                title='Logout | Admin'
                href='/logout'
                onClick={(event) => route('/logout')}
            /> */}
            </BottomNavigation>
        </React.StrictMode>
    );
}
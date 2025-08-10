// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
import * as React from 'react';
// import { useRouter } from 'next/navigation';
import BottomNavigation from '@mui/material/BottomNavigation';
import BottomNavigationAction from '@mui/material/BottomNavigationAction';
import PropTypes from 'prop-types';

import HomeOutlinedIcon from '@mui/icons-material/HomeOutlined';
import PeopleAltOutlinedIcon from '@mui/icons-material/PeopleAltOutlined';
import AssignmentOutlinedIcon from '@mui/icons-material/AssignmentOutlined';
import AppSettingsAltOutlinedIcon from '@mui/icons-material/AppSettingsAltOutlined';

interface NavigasiBawah {
    // Define any props you expect to pass to the component here
    // For example: title?: string;
    navvar: number;
}

NavigasiBawah.propTypes = {
    navvar: PropTypes.number,
};

export default function NavigasiBawah(props: NavigasiBawah) {
    const [selectedValue, setSelectedValue] = React.useState<number>(0);

    const handleNavigationChange = (event: React.SyntheticEvent, newValue: number) => {
        setSelectedValue(newValue);
    };

    const route = (url: string) => {
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
                        borderRadius: 1,
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
                        borderRadius: 1,
                    }}
                    rel='follow'
                    title='Halaman Daftar Peserta | Admin'
                    href='/admin/peserta/-/-/-?page=1'
                    onClick={(event) => route('/admin/peserta/-/-/-?page=1')}
                />
                <BottomNavigationAction
                    label="Psikotest"
                    icon={<AssignmentOutlinedIcon />}
                    value={3}
                    sx={{
                        color: '#fff',
                        backgroundColor: props.navvar === 3 ? 'rgba(25, 25, 255, 1)' : 'rgba(0, 0, 0, 1)',
                        borderRadius: 1,
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
                        borderRadius: 1,
                    }}
                    rel='follow'
                    title='Halaman Daftar Variabel | Admin'
                    href='/admin/variabel-setting/-/-/-?page=1'
                    onClick={(event) => route('/admin/variabel-setting/-/-/-?page=1')}
                />
                {/* <BottomNavigationAction
                    label="Logout"
                    defaultValue={5}
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
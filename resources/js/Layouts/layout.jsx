// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
'use client';
import "../../css/app.css";
import "../../css/animate.css";
import * as React from 'react';
import axios from 'axios';
import { Head } from '@inertiajs/react'
import Cookies from 'js-cookie';
import styled from 'styled-components';
import PropTypes from 'prop-types';

// backgroundImage: 'url(https://fruitthemes.com/demo/impressive-wordpress-theme/wp-content/uploads/sites/2/2018/06/pexels-photo-247474.jpeg)',
// backgroundSize: 'cover',
// backgroundRepeat: 'no-repeat',

RootLayout.propTypes = {
  children: PropTypes.any,
};

export default function RootLayout({ children }) {
    const [theme, setTheme] = React.useState('');
    const [textColor, setTextColor] = React.useState('');
    const [textColorRGB, setTextColorRGB] = React.useState('');
    const [borderColor, setBorderColor] = React.useState('');
    const [borderColorRGB, setBorderColorRGB] = React.useState('');

    const myRootStyle = {
        backgroundColor: theme,
        color: textColor
    }

    // eslint-disable-next-line react-hooks/exhaustive-deps
    React.useEffect(() => {
        localStorage.setItem('theme', 'rgba(200, 200, 255, 0.9)');
        localStorage.setItem('text-color', 'black');
        localStorage.setItem('text-color-rgb', '#000');
        localStorage.setItem('border-color', 'black');
        localStorage.setItem('border-color-rgb', '#000');
        setTheme(localStorage.getItem('theme'));
        setTextColor(localStorage.getItem('text-color'));
        setTextColorRGB(localStorage.getItem('text-color-rgb'));
        setBorderColor(localStorage.getItem('border-color'));
        setBorderColorRGB(localStorage.getItem('border-color-rgb'));

        const pathDomain = 'syafiq.psikotest';
        Cookies.set('theme', 'rgba(200, 200, 255, 0.9)', { expires: 24, path: pathDomain, secure: false, sameSite: 'lax' });
        Cookies.set('textColor', 'black', { expires: 24, path: pathDomain, secure: false, sameSite: 'lax' });
        Cookies.set('textColorRGB', '#000', { expires: 24, path: pathDomain, secure: false, sameSite: 'lax' });
        Cookies.set('borderColor', 'black', { expires: 24, path: pathDomain, secure: false, sameSite: 'lax' });
        Cookies.set('borderColorRGB', '#000', { expires: 24, path: pathDomain, secure: false, sameSite: 'lax' });
    }, []);

    return (
        <html lang="id">
            <body
                className={`antialiased`}
            >
                <React.StrictMode>
                    {children}
                </React.StrictMode>
            </body>
        </html>
    );
}

// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
'use client';
// import "../../css/app.css";
// import "../../css/animate.css";
import * as React from 'react';
import PropTypes from 'prop-types';

// backgroundImage: 'url(https://fruitthemes.com/demo/impressive-wordpress-theme/wp-content/uploads/sites/2/2018/06/pexels-photo-247474.jpeg)',
// backgroundSize: 'cover',
// backgroundRepeat: 'no-repeat',

interface RootLayoutProps {
    children: React.ReactNode;
}

RootLayout.propTypes = {
  children: PropTypes.any,
};

export default function RootLayout({ children }: RootLayoutProps) {
    const expires: number = 1;
    const path: String = '/';
    const domain: String = '';
    const secure: Boolean = true;
    const sameSite: String = 'strict';

    // eslint-disable-next-line react-hooks/exhaustive-deps
    React.useEffect(() => {
        localStorage.setItem('theme', 'rgba(200, 200, 255, 0.9)');
        localStorage.setItem('text-color', 'black');
        localStorage.setItem('text-color-rgb', '#000');
        localStorage.setItem('border-color', 'black');
        localStorage.setItem('border-color-rgb', '#000');
    }, []);

    return (
        <React.StrictMode>
            {children}
        </React.StrictMode>
    );
}

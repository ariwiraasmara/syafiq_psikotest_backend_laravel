// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
'use client';
import RootLayout from '../../app/layout';
import * as React from 'react';
import PropTypes from 'prop-types';
import dynamic from 'next/dynamic';

Layout.propTypes = {
  children: PropTypes.any,
};

export default function Layout({ children }) {
    return (
        <React.StrictMode>
            <RootLayout>
                {children}
            </RootLayout>
        </React.StrictMode>
    );
}

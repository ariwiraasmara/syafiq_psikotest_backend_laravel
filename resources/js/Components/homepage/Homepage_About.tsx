// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
'use client';
import "./homepage_about.css";
import * as React from 'react';
import PropTypes from 'prop-types';

interface HomepageAboutProps {
    // Define any props you expect to pass to the component here
    // For example: title?: string;
    class: string;
}

Homepage_About.propTypes = {
    class: PropTypes.string
};

export default function Homepage_About(props: HomepageAboutProps) {
    return(
        <div className='text-right p-4 background-about bg-fixed'>
            <div className='mr-4'>
                <h2 className='font-bold text-2xl underline'>Mengenai Kami...</h2>
                <h3 className='text-lg'>
                    Psikotest Online App adalah aplikasi psikotest berbasis website sehingga bisa digunakan di perangkat manapun.
                </h3>
            </div>
        </div>
    );
}
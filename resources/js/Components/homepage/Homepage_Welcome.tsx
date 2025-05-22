// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
'use client';
import "./homepage_welcome.css";
import * as React from 'react';
import PropTypes from 'prop-types';

interface Homepage_Welcome {
    // Define any props you expect to pass to the component here
    // For example: title?: string;
    class: string;
}

Homepage_Welcome.propTypes = {
    class: PropTypes.string
};

export default function Homepage_Welcome(props: Homepage_Welcome) {
    return(
        <div className='text-items-center justify-items-center text-center min-h-screen p-2 bg-fixed background-welcome text-black'>
            <h2 className="font-bold text-2xl mt-10 underline">Selamat Datang</h2>
        </div>
    );
}
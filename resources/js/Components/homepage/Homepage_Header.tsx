
// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
'use client';
import "./homepage_header.css";
import * as React from 'react';
import PropTypes from 'prop-types';

interface Homepage_Header {
    // Define any props you expect to pass to the component here
    // For example: title?: string;
    class: string;
}

Homepage_Header.propTypes = {
    class: PropTypes.string
};

export default function Homepage_Header(props: Homepage_Header) {
    return (
        <div className='bg-gradient-to-t from-sky-700 to-sky-900'>
            <h1 className='font-bold text-2xl text-center p-4'>Psikotest Online App</h1>
        </div>
    );
}
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
import * as React from 'react';
import PropTypes from 'prop-types';
import { Children } from 'react';

interface FooterLinkSEORel {
    // Define any props you expect to pass to the component here
    // For example: title?: string;
    children: any;
};

FooterLinkSEORel.propTypes = {
    children: PropTypes.any
};

export default function FooterLinkSEORel({children}: FooterLinkSEORel) {
    const date = new Date();
    const year = date.getFullYear();
    return (
        <div id='link-seo-rel' className='border-white border-t-2 p-2 bg-gradient-to-t from-sky-300 to-sky-500 hidden'>
            {children}
        </div>
    )
}

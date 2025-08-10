// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
import * as React from 'react';
import PropTypes from 'prop-types';
import { Children } from 'react';
FooterLinkSEORel.propTypes = {
    Children: PropTypes.string
};
export default function FooterLinkSEORel({children}) {
    const date = new Date();
    const year = date.getFullYear();
    return (
        <div id='link-seo-rel' className='border-white border-t-2 p-2 bg-gradient-to-t from-sky-300 to-sky-500 hidden'>
            {children}
        </div>
    )
}

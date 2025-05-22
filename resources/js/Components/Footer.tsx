// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
import * as React from 'react';
import PropTypes from 'prop-types';

interface Footer {
    // Define any props you expect to pass to the component here
    // For example: title?: string;
    hidden: string;
    otherCSS: string;
}

Footer.propTypes = {
    hidden: PropTypes.string,
    otherCSS: PropTypes.string
};

export default function Footer(props: Footer) {
    const date = new Date();
    const year = date.getFullYear();
    return (
        <div className={`border-white border-t-2 p-2 bg-gradient-to-t from-sky-300 to-sky-500 ${props.hidden} ${props.otherCSS}`}>
            <div className='text-center text-black'>
                <span className='font-bold'>Copyright @ {year} : </span>
                <span className='mt-2'>
                    <address><strong>Syafiq (syafiq@gmail.com, +6285311487755)</strong></address>
                </span>
                <span className='mt-2'>
                    <address><strong>Syahri Ramadhan Wiraasmara (ariwiraasmara.sc37@gmail.com, +628176896353)</strong></address>
                </span>
            </div>
        </div>
    )
}

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
        <div className={`p-2 bg-gradient-to-t from-sky-300 to-sky-500 ${props.hidden} ${props.otherCSS}`}>
            <div className='text-left text-black text-xs flex flex-row'>
                <div className='basis-1/3'>
                    <div className='font-bold underline text-base'>Copyright @ {year} : </div>
                    <div className='mt-2'>
                        <address><strong>Syafiq<br/>syafiq@gmail.com<br/>+6285311487755</strong></address>
                    </div>
                    <div className='mt-2'>
                        <address><strong>Syahri Ramadhan Wiraasmara<br/>ariwiraasmara.sc37@gmail.com<br/>+628176896353</strong></address>
                    </div>
                </div>
            </div>
        </div>
    )
}

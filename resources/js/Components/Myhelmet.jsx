// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
'use client';
import * as React from 'react';
import { Head } from '@inertiajs/react';
import PropTypes from 'prop-types';

Myhelmet.propTypes = {
    title: PropTypes.string,
    description: PropTypes.string,
    pathURL: PropTypes.string,
    onetime: PropTypes.number,
    robots: PropTypes.string
};

export default function Myhelmet(props) {
    function setHeaderData() {
        localStorage.setItem('page-title', props.title);
        localStorage.setItem('page-url', props.pathURL);
        localStorage.setItem('page-robots', props.robots);
    }

    // eslint-disable-next-line react-hooks/exhaustive-deps
    React.useEffect(() => {
        setHeaderData();
        console.info('myhelmet.jsx');
    }, []);

    const OnetimeToken = () => {
        if(props.onetime == 1) {
            <Head>
                <meta name="XSRF-TOKEN" content={csrf} />
                <meta name="__unique__" content={unique} />
            </Head>
        }
    }

    return(OnetimeToken(props.onetime, props.token, props.unique));
}
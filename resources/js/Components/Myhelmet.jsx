// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
'use client';
import * as React from 'react';
import axios from 'axios';
import { Head } from '@inertiajs/react'
import Cookies from 'js-cookie'
import PropTypes from 'prop-types';

Myhelmet.propTypes = {
    title: PropTypes.string,
    description: PropTypes.string,
    pathURL: PropTypes.string,
    onetime: PropTypes.bool,
    robots: PropTypes.string
};

export default function Myhelmet(props) {
    const [csrf, setCsrf] = React.useState();
    const [token, setToken] = React.useState();
    const [unique, setUnique] = React.useState();

    function setHeaderData() {
        localStorage.setItem('page-title', props.title);
        localStorage.setItem('page-url', props.pathURL);
        localStorage.setItem('page-robots', props.robots);
    }

    const generateToken = async() => {
        if(props.onetime) {
            try {
                axios.defaults.withCredentials = true;
                axios.defaults.withXSRFToken = true;
                const csrfToken = await axios.get(`/sanctum/csrf-cookie`, {
                    withCredentials: true,  // Mengirimkan cookie dalam permintaan
                });
                const response1 = await axios.get(`/api/generate-token-first`, {
                    withCredentials: true,  // Mengirimkan cookie dalam permintaan\
                    headers: {
                    'Content-Type': 'application/json',
                    'XSRF-TOKEN': csrfToken,
                }
                });
                setCsrf(response1.data.data.csrfToken);
                setToken(response1.data.data.token);
                setUnique(response1.data.data.unique);
            } catch (err) {
                console.error('Error Get Token', err);
            }
        }
    }

    // eslint-disable-next-line react-hooks/exhaustive-deps
    React.useEffect(() => {
        setHeaderData();
        generateToken();
    }, []);

    const OnetimeToken = () => {
        if(props.onetime) {
            <>
                <meta name="XSRF-TOKEN" content={csrf} />
                <meta name="__token__" content={token} />
                <meta name="__unique__" content={unique} />
            </>
        }
    }

    return(
        <Head>
            <title>{props.title}</title>
            <meta property="og:title" content={props.title} />
            <meta property="og:url" content={props.pathURL} />
            <link rel="canonical" href={props.pathURL} />
            <link rel="breadcrumb" href={props.pathURL} />
            <meta name="robots" content={props.robots} />
            <OnetimeToken />
        </Head>
    );
}
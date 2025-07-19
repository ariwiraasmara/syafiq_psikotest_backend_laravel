// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
'use client';
import * as React from 'react';
import PropTypes from 'prop-types';
import Cookies from 'js-cookie';

interface Myhelmet {
    // Define any props you expect to pass to the component here
    // For example: title?: string;
    title: string;
    pathURL: string;
    token: any;
    unique: any;
    path: string;
    domain: string;
    robots: string;
}

Myhelmet.propTypes = {
    title: PropTypes.string,
    pathURL: PropTypes.string,
    token: PropTypes.any,
    unique: PropTypes.any,
    path: PropTypes.string,
    domain: PropTypes.string,
    robots: PropTypes.string,
};

export default function Myhelmet(props: Myhelmet) {
    const cookieRules = {
        path: props.path,
        domain: props.domain,
        expires : 1,
        sameSite : 'strict',
        secure : true,
    };

    const setHeaderData = () => {
        if(!localStorage.getItem('page-title') || (localStorage.getItem('page-title') === '')) localStorage.setItem('page-title', props.title);
        else localStorage.setItem('page-title', props.title);

        if(!localStorage.getItem('page-url') || (localStorage.getItem('page-url') === '')) localStorage.setItem('page-url', props.pathURL);
        else localStorage.setItem('page-url', props.pathURL);

        if(!localStorage.getItem('page-robots') || (localStorage.getItem('page-robots') === '')) localStorage.setItem('page-robots', props.robots);
        else localStorage.setItem('page-robots', props.robots);

        if(props.token) {
            if(!Cookies.get('__token__')) Cookies.set('__token__', props.token, cookieRules);
            else Cookies.set('__token__', props.token, cookieRules);
        }

        if(props.token) {
            if(!Cookies.get('__token__')) Cookies.set('__token__', props.token, cookieRules);
            else Cookies.set('__token__', props.token, cookieRules);

            if(!Cookies.get('XSRF-TOKEN') || (Cookies.get('XSRF-TOKEN') === '')) Cookies.set('XSRF-TOKEN', props.token, cookieRules);
            else Cookies.set('XSRF-TOKEN', props.token, cookieRules);
        }

        if(props.unique) {
            if(!Cookies.get('__unique__') || (Cookies.get('__unique__') === '')) Cookies.set('__unique__', props.unique, cookieRules);
            else Cookies.set('__unique__', props.unique, cookieRules);
        }
    }

    // eslint-disable-next-line react-hooks/exhaustive-deps
    React.useEffect(() => {
        setHeaderData();
    }, []);

    return(true);
}
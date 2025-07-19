// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
import Layout from '@/Layouts/layout.tsx';
import * as React from 'react';
import PropTypes from 'prop-types';
import Link from '@mui/material/Link';
import NavBreadcrumb from '@/components/NavBreadcrumb.tsx';
import Footer from '@/components/Footer.tsx';
import FooterLinkSEORel from '@/components/FooterLinkSEORel.tsx';
import Homepage_Header from '@/components/homepage/Homepage_Header.tsx';
import Homepage_Navbar from '@/components/homepage/Homepage_Navbar.tsx';
import Homepage_Welcome from '@/components/homepage/Homepage_Welcome.tsx';
import Homepage_About from '@/components/homepage/Homepage_About.tsx';
import Cookies from 'js-cookie';

interface Home {
    // Define any props you expect to pass to the component here
    // For example: title?: string;
    title: string;
    pathURL: string;
    robots: string;
    onetime: number;
    csrf_token: string;
    unique: string;
    path: string;
    domain: string;
}

Home.propTypes = {
    title: PropTypes.string,
    pathURL: PropTypes.string,
    robots: PropTypes.string,
    onetime: PropTypes.number,
    csrf_token: PropTypes.string,
    unique: PropTypes.string,
    path: PropTypes.string,
    domain: PropTypes.string
};

export default function Home(props: Home) {
    const MemoNavBreadcrumb = React.memo(function Memo() {
        return(
            <NavBreadcrumb content={`Homepage`} hidden={`hidden`} />
        );
    });

    const MemoFooter = React.memo(function Memo() {
        return(
            <Footer hidden={''} otherCSS={''} />
        );
    });

    const MemoHomepageHeader = React.memo(function Memo() {
        return(
            <Homepage_Header class={''} />
        );
    });

    const MemoHomepageNavbar = React.memo(function Memo() {
        return(
            <Homepage_Navbar class={''} />
        );
    });

    const MemoHomepage_Welcome = React.memo(function Memo() {
        return(
            <Homepage_Welcome class={''} />
        );
    });
    
    const MemoHomepage_About = React.memo(function Memo() {
        return(
            <Homepage_About class={''} />
        );
    });

    return(
        <Layout>
            <MemoNavBreadcrumb />
            <MemoHomepageHeader />
            <MemoHomepageNavbar />
            <MemoHomepage_Welcome />
            <MemoHomepage_About />
            <FooterLinkSEORel>
                <Link sx={{marginRight: 2}} rel="follow" title="Beranda" href="/" >Beranda</Link>
                <Link sx={{marginRight: 2}} rel="follow" title="Admin" href="/admin" >Admin</Link>
                <Link sx={{marginRight: 2}} rel="follow" title="Peserta" href="/peserta" >Peserta</Link>
                <Link sx={{marginRight: 2}} rel="follow" title="Hasil Psikotest" href="/peserta/psikotest/kecermatan/hasil" >Hasil Psikotest</Link>
            </FooterLinkSEORel>
            <MemoFooter />
        </Layout>
    );
}

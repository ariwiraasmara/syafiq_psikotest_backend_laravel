// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
import Layout from '@/Layouts/layout.jsx';
import * as React from 'react';
import PropTypes from 'prop-types';
import Link from '@mui/material/Link';
import Myhelmet from '@/components/Myhelmet.jsx';
import NavBreadcrumb from '@/components/NavBreadcrumb.jsx';
import Footer from '@/components/Footer.jsx';
import FooterLinkSEORel from '@/components/FooterLinkSEORel.jsx';
import Homepage_Header from '@/components/homepage/Homepage_Header.jsx';
import Homepage_Navbar from '@/components/homepage/Homepage_Navbar.jsx';
import Homepage_Welcome from '@/components/homepage/Homepage_Welcome.jsx';
import Homepage_About from '@/components/homepage/Homepage_About.jsx';

Home.propTypes = {
    title: PropTypes.string,
    robots: PropTypes.string,
    pathURL: PropTypes.string,
};

export default function Home(props) {
    const MemoNavBreadcrumb = React.memo(function Memo() {
        return(
            <NavBreadcrumb content={`Homepage`} hidden={`hidden`} />
        );
    });

    const MemoFooter = React.memo(function Memo() {
        return(
            <Footer />
        );
    });

    const MemoHomepageHeader = React.memo(function Memo() {
        return(
            <Homepage_Header />
        );
    });

    const MemoHomepageNavbar = React.memo(function Memo() {
        return(
            <Homepage_Navbar />
        );
    });

    const MemoHomepage_Welcome = React.memo(function Memo() {
        return(
            <Homepage_Welcome />
        );
    });
    
    const MemoHomepage_About = React.memo(function Memo() {
        return(
            <Homepage_About />
        );
    });

    // eslint-disable-next-line react-hooks/exhaustive-deps
    React.useEffect(() => {
    }, []);

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

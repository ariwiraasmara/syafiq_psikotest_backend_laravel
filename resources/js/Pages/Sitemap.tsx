// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
import Layout from '@/Layouts/layout.tsx';
import * as React from 'react';
import PropTypes from 'prop-types';
import Link from '@mui/material/Link';
import NavBreadcrumb from '@/components/NavBreadcrumb.tsx';
import Footer from '@/components/Footer.tsx';
import FooterLinkSEORel from '@/components/FooterLinkSEORel.tsx';

import DOMPurify from 'dompurify';

interface Sitemap {
    // Define any props you expect to pass to the component here
    // For example: title?: string;
    title: string;
    unique: string;
    pesan: string;
    error: string;
}

Sitemap.propTypes = {
    title: PropTypes.string,
    unique: PropTypes.string,
    pesan: PropTypes.string,
    error: PropTypes.string,
};


export default function Sitemap(props: Sitemap) {
    const textColor: string|any = DOMPurify.sanitize(localStorage.getItem('text-color'));
    const textColorRGB: string|any = DOMPurify.sanitize(localStorage.getItem('text-color-rgb'));
    const borderColor: string|any = DOMPurify.sanitize(localStorage.getItem('border-color'));
    const borderColorRGB: string|any = DOMPurify.sanitize(localStorage.getItem('border-color-rgb'));

    const MemoNavBreadcrumb = React.memo(function Memo() {
        return(
            <NavBreadcrumb content={`Homepage`} hidden={`hidden`} />
        );
    });

    const MemoFooter = React.memo(function Memo() {
        return(
            <Footer hidden={''} otherCSS={``} />
        );
    });

    return(
        <Layout>
            <MemoNavBreadcrumb />
            <div className="grid grid-rows-[20px_1fr_20px] items-center justify-items-center min-h-screen p-8 pb-20 gap-16 sm:p-20 font-[family-name:var(--font-geist-sans)]" >
                <div className="flex flex-col gap-8 row-start-2 items-center sm:items-start">
                    <h1 className="font-bold text-2xl text-center underline uppercase">
                        {props.pesan}
                    </h1>

                    <IfError />
                </div>
            </div>
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

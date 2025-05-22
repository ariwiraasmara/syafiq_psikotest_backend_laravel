// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
import Layout from '@/Layouts/layout';
import * as React from 'react';
import Link from '@mui/material/Link';
import Myhelmet from '@/components/Myhelmet.jsx';
import NavBreadcrumb from '@/components/NavBreadcrumb.jsx';
import Footer from '@/components/Footer.jsx';
import FooterLinkSEORel from '@/components/FooterLinkSEORel.jsx';

export default function Home(props) {
    const textColor = localStorage.getItem('text-color');

    const MemoHelmet = React.memo(function Memo() {
        return(
            <Myhelmet
                title={props.title}
                robots={props.robots}
                pathURL={props.pathURL}
                onetime={true}
            />
        );
    });

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

    const IfError = () => {
        if(props.error) {
            return props.error;
        }
    }

    // eslint-disable-next-line react-hooks/exhaustive-deps
    React.useEffect(() => {
    }, []);

    return(
        <Layout>
            <MemoHelmet />
            <MemoNavBreadcrumb />
            <div class="grid grid-rows-[20px_1fr_20px] items-center justify-items-center min-h-screen p-8 pb-20 gap-16 sm:p-20 font-[family-name:var(--font-geist-sans)]" >
                <div class="flex flex-col gap-8 row-start-2 items-center sm:items-start">
                    <h1 class="font-bold text-2xl text-center underline uppercase">
                        {props.pesan}
                    </h1>

                    {IfError}
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

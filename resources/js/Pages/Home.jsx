// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
import Layout from '@/Layouts/layout';
import * as React from 'react';
// import {
//     checkCompatibility,
//     ifExist,
// 	openDB,
//     saveDataToDB
// } from '@/indexedDB/db';
import Link from '@mui/material/Link';

import Myhelmet from '@/components/Myhelmet';
import NavBreadcrumb from '@/components/NavBreadcrumb';
import Footer from '@/components/Footer';
import FooterLinkSEORel from '@/components/FooterLinkSEORel';
import Homepage_Header from '@/components/homepage/Homepage_Header';
import Homepage_Navbar from '@/components/homepage/Homepage_Navbar';
import Homepage_Welcome from '@/components/homepage/Homepage_Welcome';
import Homepage_About from '@/components/homepage/Homepage_About';
import Carousel from '@/components/homepage/carousel/Carousel';

export default function Home(props) {
    const textColor = localStorage.getItem('text-color');
    const UseDB = async() => {
		try {
			const db = await openDB();  // Tunggu hasil promise selesai
			// console.info("Database berhasil dibuka:", db);
			// Anda dapat melanjutkan menggunakan db untuk operasi lebih lanjut
		} catch (error) {
			console.error("Terjadi kesalahan saat membuka database:", error);
		}
	}

    const indexedDB = () => {
		if(checkCompatibility) {
            if(ifExist) {
                UseDB();
                saveDataToDB();
            }
            /*
            if ('storage' in navigator && 'persist' in navigator.storage) {
                navigator.storage.persist().then((isPersistent) => {
                    if (!isPersistent) {
                        console.log('Penyimpanan tidak persisten.');
                    }
                }).catch((error) => {
                    console.error('Gagal mengakses persist:', error);
                });
            } else {
                console.log('StorageManager API tidak didukung di browser ini');
            }
            */
		}
	}

    const MemoHelmet = React.memo(function Memo() {
        return(
            <Myhelmet
                title={props.title}
                robots={props.robots}
                pathURL={props.pathURL}
                onetime={1}
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
            <MemoHelmet />
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

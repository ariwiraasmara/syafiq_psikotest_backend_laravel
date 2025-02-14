// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
'use client';
import Layoutadmin from '@/Layouts/Layoutadmin';
import * as React from 'react';
import Link from '@mui/material/Link';

import Myhelmet from '@/components/Myhelmet';
import Appbarku from '@/components/Appbarku';
import NavBreadcrumb from '@/components/NavBreadcrumb';
import Footer from '@/components/Footer';

import DOMPurify from 'dompurify';

const typePsikotest = [
    "kecermatan",
];

export default function Psikotest(props) {
    const textColor = DOMPurify.sanitize(localStorage.getItem('text-color'));
    const textColorRGB = DOMPurify.sanitize(localStorage.getItem('text-color-rgb'));
    const borderColor = DOMPurify.sanitize(localStorage.getItem('border-color'));
    const borderColorRGB = DOMPurify.sanitize(localStorage.getItem('border-color-rgb'));
    
    const MemoHelmet = React.memo(function Memo() {
        return(
            <Myhelmet
                title={props.title}
                pathURL={props.pathURL}
                robots={props.robots}
                onetime={props.onetime}
            />
        );
    });

    const MemoAppbarku = React.memo(function Memo() {
        return(
            <Appbarku headTitle="Psikotest" />
        );
    });

    const MemoNavBreadcrumb = React.memo(function Memo() {
        return(
            <NavBreadcrumb content={`Admin / Psikotest`} hidden={`hidden`} />
        );
    });

    const MemoFooter = React.memo(function Memo() {
        return(
            <Footer hidden={`hidden`} />
        );
    });

    return (
        <>
            <Layoutadmin>
                <MemoHelmet />
                <MemoAppbarku />
                <MemoNavBreadcrumb />
                <div className={`p-4 mb-14 text-${textColor}`}>
                    <h1 className='hidden'>Halaman Psikotest | Admin</h1>
                    {typePsikotest.map((data, index) => (
                        <Link rel='follow' title={`Psikotest ${data}`} href={`/admin/psikotest/${data}`} key={index}>
                            <div className={`bg-slate-50 border-b-2 p-3 rounded-t-md mt-2 capitalize text-${textColor} border-${borderColor}`}>
                                <h2>{data}</h2>
                            </div>
                        </Link>
                    ))}
                </div>
                <MemoFooter />
            </Layoutadmin>
        </>
    )
}
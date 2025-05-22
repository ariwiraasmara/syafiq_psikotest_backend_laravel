// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
'use client';
import Layoutadmin from '@/Layouts/Layoutadmin.tsx';
import * as React from 'react';
import PropTypes from 'prop-types';
import Link from '@mui/material/Link';

import Appbarku from '@/components/Appbarku.tsx';
import NavBreadcrumb from '@/components/NavBreadcrumb.tsx';
import Footer from '@/components/Footer.tsx';

import DOMPurify from 'dompurify';

interface AdminPsikotest {
    // Define any props you expect to pass to the component here
    // For example: title?: string;
    title: string;
    nama: string;
}

AdminPsikotest.propTypes = {
    title: PropTypes.string,
    nama: PropTypes.string,
};

const typePsikotest = [
    "kecermatan",
];

export default function AdminPsikotest(props: AdminPsikotest) {
    const textColor: any = DOMPurify.sanitize(localStorage.getItem('text-color'));
    const textColorRGB: any = DOMPurify.sanitize(localStorage.getItem('text-color-rgb'));
    const borderColor: any = DOMPurify.sanitize(localStorage.getItem('border-color'));
    const borderColorRGB: any = DOMPurify.sanitize(localStorage.getItem('border-color-rgb'));

    const MemoAppbarku = React.memo(function Memo() {
        return(
            <Appbarku user={props.nama} headTitle="Psikotest" url={''} isback={false} />
        );
    });

    const MemoNavBreadcrumb = React.memo(function Memo() {
        return(
            <NavBreadcrumb content={`Admin / Psikotest`} hidden={`hidden`} />
        );
    });

    const MemoFooter = React.memo(function Memo() {
        return(
            <Footer hidden={`hidden`} otherCSS={''} />
        );
    });

    return (
        <Layoutadmin navvar={3}>
            <MemoAppbarku />
            <MemoNavBreadcrumb />
            <div className={`p-4 mb-14 text-${textColor}`}>
                <h1 className='hidden'>Halaman Psikotest | Admin</h1>
                {typePsikotest.map((data: any, index: number) => (
                    <Link rel='follow' title={`Psikotest ${data}`} href={`/admin/psikotest/${data}`} key={index}>
                        <div className={`bg-slate-50 border-b-2 p-3 rounded-t-md mt-2 capitalize text-${textColor} border-${borderColor}`}>
                            <h2>{data}</h2>
                        </div>
                    </Link>
                ))}
            </div>
            <MemoFooter />
        </Layoutadmin>
    )
}
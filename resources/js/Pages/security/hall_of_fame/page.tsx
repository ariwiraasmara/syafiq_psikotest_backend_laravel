// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
import Layout from '@/Layouts/layout.tsx';
import * as React from 'react';
import PropTypes from 'prop-types';
import Appbarku from '@/components/Appbarku.tsx';
import NavBreadcrumb from '@/components/NavBreadcrumb.tsx';
import Footer from '@/components/Footer.tsx';

interface SecurityHallOfFame {
    // Define any props you expect to pass to the component here
    // For example: title?: string;
    title: string;
    token: string;
    unique: string;
}

SecurityHallOfFame.propTypes = {
    title: PropTypes.string,
    token: PropTypes.string,
    unique: PropTypes.string,
};

export default function SecurityHallOfFame(props: SecurityHallOfFame) {
    const MemoAppbarku = React.memo(function Memo() {
        return(
            <Appbarku user={''} headTitle="Hall of Fame - Security" isback={true} url={`/`} />
        );
    });
    
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
            <MemoAppbarku />
            <MemoNavBreadcrumb />
            <div class="p-4 text-black">
                <p>Kami ingin mengucapkan terima kasih kepada para peneliti berikut yang sudah membantu kami:</p>
            </div>
            <MemoFooter />
        </Layout>
    );
}
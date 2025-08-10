// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
import Layout from '@/Layouts/layout';
import * as React from 'react';

export default function Error(props) {

    return (
        <Layout>
            <div className="grid grid-rows-[20px_1fr_20px] items-center justify-items-center min-h-screen p-8 pb-20 gap-16 sm:p-20">
                <div className="flex flex-col gap-8 row-start-2 items-center sm:items-start text-center">
                    <h1 className='font-bold text-2xl'>Terjadi Kesalahan!</h1>
                </div>
            </div>
        </Layout>
    );

}
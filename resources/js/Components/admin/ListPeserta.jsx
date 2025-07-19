// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
import * as React from 'react';
import Link from '@mui/material/Link';
import { For } from 'million/react';
import PropTypes from 'prop-types';
import DOMPurify from 'dompurify';

ListPeserta.propTypes = {
    listpeserta: PropTypes.any,
    isLatest: PropTypes.bool,
    textColor: PropTypes.string,
    borderColor: PropTypes.string,
};

export default function ListPeserta(props) {
    const goTo = (id) => {
        sessionStorage.setItem('admin_id_peserta', DOMPurify.sanitize(id));
        // router.push(`/admin/peserta/detil`);
        window.location.href = '/admin/peserta/detil';
    }

    const isLatest = (isTrue, tgl_ujian) => {
        if(isTrue) {
            return (<p><span className="font-bold">Tanggal Terakhir Ujian : {tgl_ujian}</span></p>);
        }
    }

    return(
        <React.StrictMode>
            <>
                {/* {props.listpeserta.map((data, index) => (
                    <Link onClick={() => goTo(data.id) } sx={{color: '#fff'}} key={index}>
                        <div key={index} className='border-b-2 p-3'>
                            {isLatest(props.isLatest, data.tgl_ujian)}
                            <p><span className="font-bold">{data.nama}</span></p>
                            <p>{data.no_identitas}</p>
                            <p>{data.email}</p>
                            <p>{data.asal}</p>
                        </div>
                    </Link>
                ))} */
                props.listpeserta ? (
                    <For each={props.listpeserta}>
                        {(data, index) =>
                            <Link href={`/admin/peserta-detil/${DOMPurify.sanitize(data.id)}`} rel="follow" title={`Detil Peserta ${DOMPurify.sanitize(data.nama)}`} onClick={() => goTo(DOMPurify.sanitize(data.id)) } key={index}>
                                <h3 key={index} className={`bg-slate-50 border-b-2 p-3 rounded-t-md mt-2 text-${props.textColor} border-${props.borderColor}`}>
                                    {isLatest(props.isLatest, data.tgl_ujian)}
                                    <p><span className="font-bold">{DOMPurify.sanitize(data.nama)}</span></p>
                                    <p>{DOMPurify.sanitize(data.no_identitas)}</p>
                                    <p>{DOMPurify.sanitize(data.email)}</p>
                                    <p>{DOMPurify.sanitize(data.asal)}</p>
                                </h3>
                            </Link>
                        }
                    </For>
                ) : (
                    <h2 className={`font-bold text-center text-lg ${props.textColor}`}>
                        Data Peserta Kosong!<br/>Belum Ada Data!
                    </h2>
                )}
            </>
        </React.StrictMode>
    );
}
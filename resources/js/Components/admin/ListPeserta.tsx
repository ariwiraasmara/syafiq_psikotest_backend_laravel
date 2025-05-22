// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
import * as React from 'react';
import Link from '@mui/material/Link';
import { For } from 'million/react';
import PropTypes from 'prop-types';
import DOMPurify from 'dompurify';

interface ListPeserta {
    // Define any props you expect to pass to the component here
    // For example: title?: string;
    listpeserta: any;
    isLatest: boolean;
    textColor: string;
    borderColor: string;
}

ListPeserta.propTypes = {
    listpeserta: PropTypes.any,
    isLatest: PropTypes.bool,
    textColor: PropTypes.string,
    borderColor: PropTypes.string,
};

export default function ListPeserta(props: ListPeserta) {
    const goTo = (id: string) => {
        // sessionStorage.setItem('admin_id_peserta', DOMPurify.sanitize(id));
        window.location.href = '/admin/peserta/detil';
    }

    const isLatest = (isTrue: boolean, tgl_ujian: string) => {
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
                        {(data: any, index: number) =>
                            <Link href={`/admin/peserta-detil/-/-/${DOMPurify.sanitize(data.id)}`} rel="follow" title={`Detil Peserta ${DOMPurify.sanitize(data.nama)}`} onClick={() => goTo(DOMPurify.sanitize(data.id)) } key={index}>
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
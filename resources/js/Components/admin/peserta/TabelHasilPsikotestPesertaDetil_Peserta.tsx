// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara

import * as React from 'react';
import PropTypes from 'prop-types';
import Button from '@mui/material/Button';
import Paper from '@mui/material/Paper';
import Table from '@mui/material/Table';
import TableBody from '@mui/material/TableBody';
import TableCell from '@mui/material/TableCell';
import TableContainer from '@mui/material/TableContainer';
import TableHead from '@mui/material/TableHead';
import TableRow from '@mui/material/TableRow';
import TextField from '@mui/material/TextField';

import RestartAltIcon from '@mui/icons-material/RestartAlt';
import SearchIcon from '@mui/icons-material/Search';
import CircularProgress from '@mui/material/CircularProgress';

import DOMPurify from 'dompurify';

interface TabelHasilPsikotestPesertaDetil_Peserta {
    // Define any props you expect to pass to the component here
    // For example: title?: string;
    peserta_id: string;
    no_identitas: string;
    email: string;
    token: string;
    unique: string;
    pat: string;
    rtk: string;
    textColor: string;
    borderColor: string;
    data: any;
}

TabelHasilPsikotestPesertaDetil_Peserta.propTypes = {
    peserta_id: PropTypes.string,
    no_identitas: PropTypes.string,
    email: PropTypes.string,
    token: PropTypes.string,
    unique: PropTypes.string,
    pat: PropTypes.string,
    rtk: PropTypes.string,
    textColor: PropTypes.string,
    borderColor: PropTypes.string,
    data: PropTypes.any,
};

export default function TabelHasilPsikotestPesertaDetil_Peserta(props: TabelHasilPsikotestPesertaDetil_Peserta) {
    const [dataLoading, setDataLoading] = React.useState<boolean>(false);
    const dataHasilPsikotesKecermatan: any = props.data;

    const headerColumns = [
        { id: 'kolom_1', label: 'Kolom 1', minWidth: 100, align: 'center' },
        { id: 'kolom_2', label: 'Kolom 2', minWidth: 100, align: 'center' },
        { id: 'kolom_3', label: 'Kolom 3', minWidth: 100, align: 'center' },
        { id: 'kolom_4', label: 'Kolom 4', minWidth: 100, align: 'center' },
        { id: 'kolom_5', label: 'Kolom 5', minWidth: 100, align: 'center' },
    ];

    const headerNumberColumnsStyle = {
        textAlign: 'center',
        fontWeight: 'bold',
        minWidth: 75,
        borderBottom: '2px solid #000',
        borderRight: '1px solid #000'
    }

    const headerColumnsStyle = {
        textAlign: 'center',
        fontWeight: 'bold',
        minWidth: 120,
        borderBottom: '2px solid #000'
    }

    const bodyNumberColumnStyle = {
        textAlign: 'right',
        borderRight: '1px solid #000'
    }

    return (
        <React.StrictMode>
            <Paper sx={{ width: '100%', overflow: 'hidden', borderRadius: 2 }}>
                <TableContainer sx={{ maxHeight: 450 }}>
                    <Table stickyHeader aria-label="sticky table">
                        <TableHead>
                            <TableRow>
                                <TableCell sx={headerNumberColumnsStyle}>
                                    <span className='font-bold'>#</span>
                                </TableCell>
                                <TableCell sx={headerColumnsStyle}>
                                    <div className='font-bold'>Tanggal</div>
                                </TableCell>
                                {headerColumns.map((column) => (
                                    <TableCell
                                        key={column.id}
                                        align={column.align}
                                        style={{ minWidth: column.minWidth }}
                                        sx={headerColumnsStyle}
                                    >
                                        <span className='font-bold'>{column.label}</span>
                                    </TableCell>
                                ))}
                            </TableRow>
                        </TableHead>
                        <TableBody>
                            {dataLoading ? (
                                <TableRow>
                                    <TableCell colSpan={7}>
                                        <div className='text-center font-bold'>
                                            Sedang Memuat Data..<br/>
                                            Mohon Harap Tunggu...<br/>
                                            <CircularProgress color="info" size={50} />
                                        </div>
                                    </TableCell>
                                </TableRow>
                            ) : (
                                dataHasilPsikotesKecermatan.length > 0 ? (
                                    dataHasilPsikotesKecermatan.map((data: any, index: number) => (
                                        <TableRow key={index}>
                                            <TableCell sx={bodyNumberColumnStyle}>{parseInt(index) + 1}</TableCell>
                                            <TableCell sx={{ textAlign: 'center' }}>{DOMPurify.sanitize(data.tgl_ujian)}</TableCell>
                                            <TableCell sx={{ textAlign: 'center' }}>{DOMPurify.sanitize(data.hasilnilai_kolom_1)}</TableCell>
                                            <TableCell sx={{ textAlign: 'center' }}>{DOMPurify.sanitize(data.hasilnilai_kolom_2)}</TableCell>
                                            <TableCell sx={{ textAlign: 'center' }}>{DOMPurify.sanitize(data.hasilnilai_kolom_3)}</TableCell>
                                            <TableCell sx={{ textAlign: 'center' }}>{DOMPurify.sanitize(data.hasilnilai_kolom_4)}</TableCell>
                                            <TableCell sx={{ textAlign: 'center' }}>{DOMPurify.sanitize(data.hasilnilai_kolom_5)}</TableCell>
                                        </TableRow>
                                    ))
                                ) : (
                                    <TableRow>
                                        <TableCell colSpan={7}>
                                            <div className='text-center font-bold'>
                                                Belum Ada Data<br/>
                                                Data Kosong!
                                            </div>
                                        </TableCell>
                                    </TableRow>
                                )
                            )}
                        </TableBody>
                    </Table>
                </TableContainer>
            </Paper>
        </React.StrictMode>
    );
}
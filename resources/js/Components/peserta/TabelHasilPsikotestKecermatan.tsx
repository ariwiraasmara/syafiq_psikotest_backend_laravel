// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
import * as React from 'react';
import PropTypes from 'prop-types';
import Paper from '@mui/material/Paper';
import Table from '@mui/material/Table';
import TableBody from '@mui/material/TableBody';
import TableCell from '@mui/material/TableCell';
import TableContainer from '@mui/material/TableContainer';
import TableHead from '@mui/material/TableHead';
import TableRow from '@mui/material/TableRow';

interface TabelHasilPsikotestKecermatan {
    // Define any props you expect to pass to the component here
    // For example: title?: string;
    hasilnilai_kolom_1: number;
    hasilnilai_kolom_2: number;
    hasilnilai_kolom_3: number;
    hasilnilai_kolom_4: number;
    hasilnilai_kolom_5: number;
    waktupengerjaan_kolom_1: number;
    waktupengerjaan_kolom_2: number;
    waktupengerjaan_kolom_3: number;
    waktupengerjaan_kolom_4: number;
    waktupengerjaan_kolom_5: number;
}

TabelHasilPsikotestKecermatan.propTypes = {
    hasilnilai_kolom_1: PropTypes.number,
    hasilnilai_kolom_2: PropTypes.number,
    hasilnilai_kolom_3: PropTypes.number,
    hasilnilai_kolom_4: PropTypes.number,
    hasilnilai_kolom_5: PropTypes.number,
    waktupengerjaan_kolom_1: PropTypes.number,
    waktupengerjaan_kolom_2: PropTypes.number,
    waktupengerjaan_kolom_3: PropTypes.number,
    waktupengerjaan_kolom_4: PropTypes.number,
    waktupengerjaan_kolom_5: PropTypes.number,
};

export default function TabelHasilPsikotestKecermatan(props: TabelHasilPsikotestKecermatan) {

    const headerColumns = [
        { id: 'kolom_1', label: 'Kolom 1', minWidth: 100, align: 'center' },
        { id: 'kolom_2', label: 'Kolom 2', minWidth: 100, align: 'center' },
        { id: 'kolom_3', label: 'Kolom 3', minWidth: 100, align: 'center' },
        { id: 'kolom_4', label: 'Kolom 4', minWidth: 100, align: 'center' },
        { id: 'kolom_5', label: 'Kolom 5', minWidth: 100, align: 'center' },
    ];

    return (
        <React.StrictMode>
            <div className='bg-white rounded-lg shadow-xl overflow-x-auto md:overscroll-contain'>
                <Table aria-label="simple table">
                    <TableHead>
                        <TableRow>
                            <TableCell colSpan={6} align='center'>
                                <h4 className='font-bold text-black text-xl'>Tabel Hasil Psikotest Kecermatan</h4>
                            </TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell></TableCell>
                            {headerColumns.map((column) => (
                                <TableCell
                                    key={column.id}
                                    align='center'
                                >
                                    <span className='font-bold'>{column.label}</span>
                                </TableCell>
                            ))}
                        </TableRow>
                    </TableHead>
                    <TableBody>
                        <TableRow>
                            <TableCell>
                                <span className='font-bold'>Hasil Nilai</span>
                            </TableCell>
                            <TableCell align="center">{props.hasilnilai_kolom_1}</TableCell>
                            <TableCell align="center">{props.hasilnilai_kolom_2}</TableCell>
                            <TableCell align="center">{props.hasilnilai_kolom_3}</TableCell>
                            <TableCell align="center">{props.hasilnilai_kolom_4}</TableCell>
                            <TableCell align="center">{props.hasilnilai_kolom_5}</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell>
                                <span className='font-bold'>Lama Pengerjaan</span>
                            </TableCell>
                            <TableCell align="center">{props.waktupengerjaan_kolom_1} detik</TableCell>
                            <TableCell align="center">{props.waktupengerjaan_kolom_2} detik</TableCell>
                            <TableCell align="center">{props.waktupengerjaan_kolom_3} detik</TableCell>
                            <TableCell align="center">{props.waktupengerjaan_kolom_4} detik</TableCell>
                            <TableCell align="center">{props.waktupengerjaan_kolom_5} detik</TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </React.StrictMode>
    );
}

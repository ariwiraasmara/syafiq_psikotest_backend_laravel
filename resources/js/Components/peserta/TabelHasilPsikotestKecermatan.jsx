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

TabelHasilPsikotestKecermatan.propTypes = {
    hasilnilai_kolom_1: PropTypes.number,
    hasilnilai_kolom_2: PropTypes.number,
    hasilnilai_kolom_3: PropTypes.number,
    hasilnilai_kolom_4: PropTypes.number,
    hasilnilai_kolom_5: PropTypes.number
};

export default function TabelHasilPsikotestKecermatan(props) {

    const headerColumns = [
        { id: 'kolom_1', label: 'Kolom 1', minWidth: 100, align: 'center' },
        { id: 'kolom_2', label: 'Kolom 2', minWidth: 100, align: 'center' },
        { id: 'kolom_3', label: 'Kolom 3', minWidth: 100, align: 'center' },
        { id: 'kolom_4', label: 'Kolom 4', minWidth: 100, align: 'center' },
        { id: 'kolom_5', label: 'Kolom 5', minWidth: 100, align: 'center' },
    ];

    return (
        <React.StrictMode>
            <div className='bg-white rounded-lg shadow-xl'>
                <Table aria-label="simple table">
                    <TableHead>
                        <TableRow>
                            <TableCell colSpan="5" align='center'>
                                <h4 className='font-bold text-black text-xl'>Tabel Hasil Psikotest Kecermatan</h4>
                            </TableCell>
                        </TableRow>
                        <TableRow>
                            {headerColumns.map((column) => (
                                <TableCell
                                    key={column.id}
                                    align={column.align}
                                >
                                    <span className='font-bold'>{column.label}</span>
                                </TableCell>
                            ))}
                        </TableRow>
                    </TableHead>
                    <TableBody>
                        <TableRow>
                            <TableCell align="center">{props.hasilnilai_kolom_1}</TableCell>
                            <TableCell align="center">{props.hasilnilai_kolom_2}</TableCell>
                            <TableCell align="center">{props.hasilnilai_kolom_3}</TableCell>
                            <TableCell align="center">{props.hasilnilai_kolom_4}</TableCell>
                            <TableCell align="center">{props.hasilnilai_kolom_5}</TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </React.StrictMode>
    );
}

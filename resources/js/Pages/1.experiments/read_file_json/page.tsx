// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
'use client';
import Layout from '@/Layouts/layout.tsx';
import * as React from 'react';
import PropTypes from 'prop-types';

import Paper from '@mui/material/Paper';
import Table from '@mui/material/Table';
import TableBody from '@mui/material/TableBody';
import TableCell from '@mui/material/TableCell';
import TableContainer from '@mui/material/TableContainer';
import TableHead from '@mui/material/TableHead';
import TableRow from '@mui/material/TableRow';
import { isEmpty } from 'validator';

interface Read_File_JSON {
    // Define any props you expect to pass to the component here
    // For example: title?: string;
    file: any;
}

Read_File_JSON.propTypes = {
    file: PropTypes.any,
};

export default function Read_File_JSON(props: Read_File_JSON) {

    const [data, setData] = React.useState<any[]>(props.file);

    const containsKeyword = (obj: any, keyword: string): any => {
        // if((keyword === '') || (keyword === ' ') || (isEmpty(keyword))) {
        //     return props.file;
        // }
        if (typeof obj === "string") {
            return obj.toLowerCase().includes(keyword.toLowerCase());
        }
        if (Array.isArray(obj)) {
            return obj.some(v => containsKeyword(v, keyword));
        }
        if (typeof obj === "object" && obj !== null) {
            return Object.values(obj).some(v => containsKeyword(v, keyword));
        }
        return false;
    };

    const searchData = (keyword: string) => {
        // const result = data.filter(item =>
        //     Object.values(item).some(val =>
        //       typeof val === "string" && val.toLowerCase().includes(keyword)
        //     )
        // );
        const result = data.filter(item => containsKeyword(props.file, keyword));
        setData(result);
    }
      
    // const result = data.filter(item => containsKeyword(item, keyword));

    console.info('Read File JSON');
    console.info('File', data)

    return(
        <Layout>
            <div className={``}>
                <input
                    type="text"
                    onChange={(e) => searchData(e.target.value)}
                    placeholder="Cari data..."
                    className="p-4 mb-4 w-full block bg-white border-2 border-black rounded-lg text-black"
                />

                <Table aria-label="simple table">
                    <TableHead>
                        <TableRow>
                            <TableCell align="center">ID</TableCell>
                            <TableCell align="center">ID User</TableCell>
                            <TableCell align="center">Tangal</TableCell>
                            <TableCell align="center">IP Address</TableCell>
                            <TableCell align="center">Page</TableCell>
                            <TableCell align="center">Path</TableCell>
                            <TableCell align="center">Properties</TableCell>
                            <TableCell align="center">URL</TableCell>
                            <TableCell align="center">Event</TableCell>
                            <TableCell align="center">Deskripsi</TableCell>
                            <TableCell align="center">User Agent</TableCell>
                        </TableRow>
                    </TableHead>

                    <TableBody>
                        {data.map((data: any, index: number) => (
                            <TableRow key={index}>
                                <TableCell>{data.id}</TableCell>
                                <TableCell>{data.id_user}</TableCell>
                                <TableCell>{data.tanggal}</TableCell>
                                <TableCell>{data.ip_address}</TableCell>
                                <TableCell>{data.page}</TableCell>
                                <TableCell>{data.path}</TableCell>
                                <TableCell>{data.properties}</TableCell>
                                <TableCell>{data.url}</TableCell>
                                <TableCell>{data.event}</TableCell>
                                <TableCell>{data.deskripsi}</TableCell>
                                <TableCell>{data.user_agent}</TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                </Table>
            </div>
        </Layout>
    );
}
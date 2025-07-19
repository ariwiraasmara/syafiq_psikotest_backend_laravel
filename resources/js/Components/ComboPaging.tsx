// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
'use client'
import * as React from 'react';
import PropTypes from 'prop-types';
import Link from '@mui/material/Link';
import MenuItem from '@mui/material/MenuItem';
import Select from '@mui/material/Select';

interface ComboPaging {
    // Define any props you expect to pass to the component here
    // For example: title?: string;
    title: string;
    bottom: string;
    link: string;
    lastpage: number;
    current: number;
}

ComboPaging.propTypes = {
    title: PropTypes.string,
    bottom: PropTypes.string,
    link: PropTypes.string,
    lastpage: PropTypes.any,
    current: PropTypes.number,
};

export default function ComboPaging(props: ComboPaging) {
    const toPage = (e: any) => {
        const x = e.target.value;
        console.info('toPage', x);
        window.location.href= `${props.link}/${x}`;
    }

    const pageMenuItems = [];
    const linkHidden = [];
    for(let x = 1; x < (props.lastpage + 1); x++) {
        pageMenuItems.push(
            <MenuItem value={x} selected={x === props.current} key={x}>
                {x}
            </MenuItem>
        );
        linkHidden.push(
            <Link rel='follow' title={`${props.title} halaman ${x}`} href={`${props.link}/${x}`} className='hidden' key={x}>
                {x}
            </Link>
        );
    }

    return(
        <div className={`text-center fixed w-full bg-black text-white p-2 ${props.bottom}`}>
            <span className='mr-2'>Halaman</span>
            <span>
                <Select
                    labelId="demo-simple-select-label"
                    id="demo-simple-select"
                    value={props.current}
                    label={props.current}
                    onChange={(e) => toPage(e)}
                    sx={{
                        backgroundColor: 'rgba(255, 255, 255, 1)',
                        color: '#000',
                        textAlign: 'right',
                        width: 80,
                        height: 30,
                    }}
                >
                    {pageMenuItems}
                </Select>
            </span>
            <span className='ml-2'>/ {props.lastpage}</span>
            {linkHidden}
        </div>
    );
}
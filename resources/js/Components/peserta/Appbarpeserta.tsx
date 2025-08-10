// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
import * as React from 'react';
import AppBar from '@mui/material/AppBar';
import PropTypes from 'prop-types';
import Toolbar from '@mui/material/Toolbar';
import useScrollTrigger from '@mui/material/useScrollTrigger';

function ElevationScroll(props: any) {
    const { children, window } = props;
    const trigger = useScrollTrigger({
        disableHysteresis: true,
        threshold: 0,
        target: window ? window() : undefined,
    });

    return children
        ? React.cloneElement(children, {
            elevation: trigger ? 4 : 0,
        })
        : null;
}
  
ElevationScroll.propTypes = {
    children: PropTypes.element,
    window: PropTypes.func,
};

interface Appbarpeserta {
    // Define any props you expect to pass to the component here
    // For example: title?: string;
    data: any;
    timer: string;
}

Appbarpeserta.propTypes = {
    data: PropTypes.any,
    timer: PropTypes.string,
};

export default function Appbarpeserta(props: Appbarpeserta) {
    return (
        <React.StrictMode>
            <ElevationScroll {...props}>
                <AppBar sx={{ background: '#000' }}>
                    <Toolbar>
                        <h2 className='hidden'>Pertanyaan Psikotest Kecermatan {props.data.kolom_x}</h2>
                        <table align="center">
                            <thead>
                                <tr className='hidden'><th><h3>Table Pertanyaan Psikotest Kecermatan {props.data.kolom_x}</h3></th></tr>
                                <tr>
                                    <th colSpan={5} className="p-2">{props.data.kolom_x}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr className="border-2 border-white">
                                    <td className="p-2 border-2 border-white">{props.data.nilai_A}</td>
                                    <td className="p-2 border-2 border-white">{props.data.nilai_B}</td>
                                    <td className="p-2 border-2 border-white">{props.data.nilai_C}</td>
                                    <td className="p-2 border-2 border-white">{props.data.nilai_D}</td>
                                    <td className="p-2 border-2 border-white">{props.data.nilai_E}</td>
                                </tr>
                                <tr className="border-2 border-white">
                                    <td className="p-2 border-2 border-white font-bold">A</td>
                                    <td className="p-2 border-2 border-white font-bold">B</td>
                                    <td className="p-2 border-2 border-white font-bold">C</td>
                                    <td className="p-2 border-2 border-white font-bold">D</td>
                                    <td className="p-2 border-2 border-white font-bold">E</td>
                                </tr>
                                <tr className="mt-4">
                                    <th colSpan={5} className="p-2">{props.timer}</th>
                                </tr>
                            </tbody>
                        </table>
                    </Toolbar>
                </AppBar>
            </ElevationScroll>
            <Toolbar />
        </React.StrictMode>
    );
}
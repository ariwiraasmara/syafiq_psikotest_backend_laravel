// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
import * as React from 'react';
import PropTypes from 'prop-types';

interface NavBreadcrumb {
    // Define any props you expect to pass to the component here
    // For example: title?: string;
    content: string;
    hidden: string;
}

NavBreadcrumb.propTypes = {
    content: PropTypes.string,
    hidden: PropTypes.string,
};

export default function NavBreadcrumb(props: NavBreadcrumb) {
    return (
        <nav aria-label="breadcrumb" id="nav-breadcrumb" className={`font-bold bg-black ${props.hidden}`}>
            <span id="breadcrumb" className="mr-4 ml-4 font-bold">{props.content}</span>
        </nav>
    )
}
<?php
//! Copyright Syahri Ramadhan Wiraasmara (ARI)
namespace App\Libraries;
class myroute {

    // API ROUTES {
        public static function API(string $controller, string $procname = null) {
            return '\App\Http\Controllers\\'.$controller.'@'.$procname;
        }
    // }

}
?>
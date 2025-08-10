<?php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
namespace App\Libraries;
class myroute {

    // API ROUTES {
        public static function API(string $controller, string $procname = null) {
            return '\App\Http\Controllers\\'.$controller.'@'.$procname;
        }
    // }

    // Web View {
        public static function view(string $controller, string $procname = null) {
            return '\App\Http\Controllers\View\\'.$controller.'@'.$procname;
        }
    // }

}
?>
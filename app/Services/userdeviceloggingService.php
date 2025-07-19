<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Libraries\branding;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use Browser;
use Exception;

class userdeviceloggingService {
    //
    //?
    protected $isAdmin, $dirfilename;
    
    //? Header Variabel
    protected $header;
    protected $tanggal, $host, $id_user, $nama_user, $email_user, $roles_user, $ipaddress_user;

    //? Activities Variabel
    protected $activities;
    protected $activity_last_path, $activity_last_url, $activity_last_page, $activity_method_page, $activity_ngapain, $activity_body_content;
    
    //? Setup
    public function __construct($isAdmin, String $dirfilename, array $header, array $activities) {
        $this->isAdmin                = $isAdmin;
        $this->dirfilename            = $dirfilename;
        $this->header                 = $header;
        $this->tanggal                = date('Y-m-d H:i:s');
        $this->host                   = $header['host'];
        $this->id_user                = $header['id_user'];
        $this->nama_user              = $header['nama'];
        $this->email_user             = $header['email'];
        $this->roles_user             = $header['roles_user'];
        $this->ipaddress_user         = $header['ip_address'];
        $this->activities             = $activities;
        $this->activity_last_path     = $activities['last_path'];
        $this->activity_last_url      = $activities['last_url'];
        $this->activity_last_page     = $activities['last_page'];
        $this->activity_method_page   = $activities['method_page'];
        $this->activity_ngapain       = $activities['ngapain'];
        $this->activity_body_content  = $activities['body_content'];
    }

    public function cekOutput() {
        return $this->header;
    }

    public function createFileUserAdmin(): bool|null {
        try {
            if(!Storage::disk('user_admin')->exists($this->dirfilename.'.log')) {
                // Optionally, log or handle the case where the file already exists
                if(Storage::disk('user_admin')->put($this->dirfilename.'.log', '')) {
                    return true;
                }
                return false; // or return null, depending on your logic
            }
            return false;
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada userdevicehistoryService->createFile!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function printUserAdmin(array $activities = []) {
        try {
            if(empty($activities) || is_null($activities)) {
                $activity_last_path     = $this->activity_last_path;
                $activity_last_url      = $this->activity_last_url;
                $activity_last_page     = $this->activity_last_page;
                $activity_method_page   = $this->activity_method_page;
                $activity_ngapain       = $this->activity_ngapain;
                $activity_body_content  = $this->activity_body_content;
            }
            else {
                $activity_last_path     = $activities['last_path'];
                $activity_last_url      = $activities['last_url'];
                $activity_last_page     = $activities['last_page'];
                $activity_method_page   = $activities['method_page'];
                $activity_ngapain       = $activities['ngapain'];
                $activity_body_content  = $activities['body_content'];
            }
            $indent = '    '; // 4 spaces
            $content = "{\n".
                $indent."\"tanggal\": \"$this->tanggal\",\n".
                $indent."\"host\": \"$this->host\",\n".
                $indent."\"user\": {\n".
                    $indent.$indent."\"id\": $this->id_user,\n".
                    $indent.$indent."\"nama\": \"$this->nama_user\",\n".
                    $indent.$indent."\"email\": \"$this->email_user\",\n".
                    $indent.$indent."\"roles\": $this->roles_user,\n".
                $indent."},\n".
                $indent."\"perangkat\": {\n".
                    $indent.$indent."\"ip_address\": \"$this->ipaddress_user\",\n".
                    $indent.$indent."\"user_agent\": \"".Browser::userAgent()."\",\n".
                    $indent.$indent."\"device\": {\n".
                    $indent.$indent.$indent."\"type\": \"".Browser::deviceType()."\",\n".
                    $indent.$indent.$indent."\"family\": \"".Browser::deviceFamily()."\",\n".
                    $indent.$indent.$indent."\"model\": \"".Browser::deviceModel()."\",\n".
                    $indent.$indent."},\n".
                    $indent.$indent."\"browser\": {\n".
                    $indent.$indent.$indent."\"name\": \"".Browser::browserName()."\",\n".
                    $indent.$indent.$indent."\"family\": \"".Browser::browserFamily()."\",\n".
                    $indent.$indent.$indent."\"version\": \"".Browser::browserVersion()."\",\n".
                    $indent.$indent.$indent."\"engine\": \"".Browser::browserEngine()."\",\n".
                    $indent.$indent."},\n".
                    $indent.$indent."\"operation_system\": {\n".
                    $indent.$indent.$indent."\"isWindows?\": \"".Browser::isWindows()."\",\n".
                    $indent.$indent.$indent."\"isLinux?\": \"".Browser::isLinux()."\",\n".
                    $indent.$indent.$indent."\"isMac?\": \"".Browser::isMac()."\",\n".
                    $indent.$indent.$indent."\"android\": {\n".
                    $indent.$indent.$indent.$indent."\"isAndroid?\": \"".Browser::isAndroid()."\",\n".
                    $indent.$indent.$indent.$indent."\"inAndroidApp?\": \"".Browser::isInApp()."\",\n".
                    $indent.$indent.$indent."},\n".
                    $indent.$indent.$indent."\"name\": \"".Browser::platformName()."\",\n".
                    $indent.$indent.$indent."\"family\": \"".Browser::platformFamily()."\",\n".
                    $indent.$indent.$indent."\"version\": \"".Browser::platformVersion()."\",\n".
                    $indent.$indent.$indent."\"versionMajor\": \"".Browser::platformVersionMajor()."\",\n".
                    $indent.$indent.$indent."\"versionMinor\": \"".Browser::platformVersionMinor()."\",\n".
                    $indent.$indent."},\n".
                $indent."},\n".
                $indent."\"aktifitas\": {\n".
                    $indent.$indent."\"path\": \"$activity_last_path\",\n".
                    $indent.$indent."\"kunjungan_terakhir_url\": \"$activity_last_url\",\n".
                    $indent.$indent."\"kunjungan_terakhir_halaman\": \"$activity_last_page\",\n".
                    $indent.$indent."\"method_page\": \"$activity_method_page\",\n".
                    $indent.$indent."\"ngapain?\": \"$activity_ngapain\",\n".
                    $indent.$indent."\"body_content\": $activity_body_content\n".
                $indent."}\n".
            "},\n";
            Storage::disk('user_admin')->append($this->dirfilename.'.json', $content);
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada userdevicehistoryService->print!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function logout() {
        try {
            $content = "[$this->tanggal] $this->host.INFO: User Admin Logout, Session Closed";
            Storage::disk('user_admin')->append($this->dirfilename, $content);
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada userdevicehistoryService->print!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function createFileGuest(): bool|null {
        try {
            // Check if the file exists
            if(!Storage::disk('guest')->exists($filename)) {
                // Optionally, log or handle the case where the file already exists
                if(Storage::disk('guest')->put($filename, '')) {
                    return true;
                }
                return false; // or return null, depending on your logic
            }
            return false;
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada userdevicehistoryService->createFile!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function printGuest(array $activities = []) {
        try {
            if(empty($activities) || is_null($activities)) {
                $dirfilename            = $this->dirfilename;
                $activity_last_path     = $this->activity_last_path;
                $activity_last_url      = $this->activity_last_url;
                $activity_last_page     = $this->activity_last_page;
                $activity_method_page   = $this->activity_method_page;
                $activity_ngapain       = $this->activity_ngapain;
                $activity_body_content  = $this->activity_body_content;
            }
            else {
                $dirfilename            = $activities['filename'];
                $activity_last_path     = $activities['last_path'];
                $activity_last_url      = $activities['last_url'];
                $activity_last_page     = $activities['last_page'];
                $activity_method_page   = $activities['method_page'];
                $activity_ngapain       = $activities['ngapain'];
                $activity_body_content  = $activities['body_content'];
            }
            $indent = '    '; // 4 spaces
            $content = "{\n".
                $indent."\"tanggal\": \"$this->tanggal\",\n".
                $indent."\"host\": \"$this->host\",\n".
                $indent."\"user\": {\n".
                    $indent.$indent."\"id\": 0,\n".
                    $indent.$indent."\"nama\": \"Tamu\",\n".
                    $indent.$indent."\"email\": \"-\",\n".
                    $indent.$indent."\"roles\": 0,\n".
                $indent."},\n".
                $indent."\"perangkat\": {\n".
                    $indent.$indent."\"ip_address\": \"$this->ipaddress_user\",\n".
                    $indent.$indent."\"user_agent\": \"".Browser::userAgent()."\",\n".
                    $indent.$indent."\"device\": {\n".
                    $indent.$indent.$indent."\"type\": \"".Browser::deviceType()."\",\n".
                    $indent.$indent.$indent."\"family\": \"".Browser::deviceFamily()."\",\n".
                    $indent.$indent.$indent."\"model\": \"".Browser::deviceModel()."\"\n".
                    $indent.$indent."},\n".
                    $indent.$indent."\"browser\": {\n".
                    $indent.$indent.$indent."\"name\": \"".Browser::browserName()."\",\n".
                    $indent.$indent.$indent."\"family\": \"".Browser::browserFamily()."\",\n".
                    $indent.$indent.$indent."\"version\": \"".Browser::browserVersion()."\",\n".
                    $indent.$indent.$indent."\"engine\": \"".Browser::browserEngine()."\"\n".
                    $indent.$indent."},\n".
                    $indent.$indent."\"operation_system\": {\n".
                    $indent.$indent.$indent."\"isWindows?\": \"".Browser::isWindows()."\",\n".
                    $indent.$indent.$indent."\"isLinux?\": \"".Browser::isLinux()."\",\n".
                    $indent.$indent.$indent."\"isMac?\": \"".Browser::isMac()."\",\n".
                    $indent.$indent.$indent."\"android\": {\n".
                    $indent.$indent.$indent.$indent."\"isAndroid?\": \"".Browser::isAndroid()."\",\n".
                    $indent.$indent.$indent.$indent."\"inAndroidApp?\": \"".Browser::isInApp()."\",\n".
                    $indent.$indent.$indent."},\n".
                    $indent.$indent.$indent."\"name\": \"".Browser::platformName()."\",\n".
                    $indent.$indent.$indent."\"family\": \"".Browser::platformFamily()."\",\n".
                    $indent.$indent.$indent."\"version\": \"".Browser::platformVersion()."\",\n".
                    $indent.$indent.$indent."\"versionMajor\": \"".Browser::platformVersionMajor()."\",\n".
                    $indent.$indent.$indent."\"versionMinor\": \"".Browser::platformVersionMinor()."\"\n".
                    $indent.$indent."},\n".
                $indent."},\n".
                $indent."\"aktifitas\": {\n".
                    $indent.$indent."\"path\": \"$activity_last_path\",\n".
                    $indent.$indent."\"kunjungan_terakhir_url\": \"$activity_last_url\",\n".
                    $indent.$indent."\"kunjungan_terakhir_halaman\": \"$activity_last_page\",\n".
                    $indent.$indent."\"method_page\": \"$activity_method_page\",\n".
                    $indent.$indent."\"ngapain?\": \"$activity_ngapain\",\n".
                    $indent.$indent."\"body_content\": $activity_body_content\n".
                $indent."}\n".
            "},\n";
            Storage::disk('guest')->append($dirfilename.'.json', $content);
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada userdevicehistoryService->print!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function print(array $activities = []) {
        return $this->dirfilename;
        if($this->isAdmin > 0) {
            $this->createFileUserAdmin();
            $this->printUserAdmin($activities);
        }
        else {
            $this->createFileGuest();
            $this->printGuest($activities);
        }
    }

    public function __destruct() {
        $this->isAdmin                = null;
        $this->dirfilename            = null;
        $this->tanggal                = null;
        $this->host                   = null;
        $this->id_user                = null;
        $this->nama_user              = null;
        $this->email_user             = null;
        $this->roles_user             = null;
        $this->ipaddress_user         = null;
        $this->activity_last_path     = null;
        $this->activity_last_url      = null;
        $this->activity_last_page     = null;
        $this->activity_method_page   = null;
        $this->activity_ngapain       = null;
        $this->activity_body_content  = null;
    }
}
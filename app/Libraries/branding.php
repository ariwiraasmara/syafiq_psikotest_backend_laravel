<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Libraries;

class branding {

    protected readonly String $appname;
    protected readonly String $applogo;
    protected readonly String $appdescription;
    protected readonly float $version;
    protected readonly String $vendorname;
    protected readonly String $vendordescription;
    protected readonly String $verdoraddress;
    protected readonly String $vendorlinkgooglemap;
    protected readonly String $license;

    public function __construct() {
        $this->appname = 'Psikotes Online App';
        $this->applogo = asset('images/logo1.jpeg');
        $this->appdescription = 'Psikotes Online App adalah aplikasi psikotest berbasis online web, dimana dapat diakses di perangkat manapun';
        $this->version = 1.8;
        $this->vendorname = 'PT. Solusi Psikologi Banten';
        $this->vendordescription = '';
        $this->verdoraddress = 'Perum Taman Mutiara Indah Blok B6 No. 17, RT.001/RW.16 Kelurahan Kaligandu Kecamatan Kota Serang, Provinsi Banten, Indonesia 42116';
        $this->vendorlinkgooglemap = 'https://www.google.com/maps/search/Perum+Taman%20Mutiara%20Indah%20Blok%20B6%20No.%2017,%20RT.001/RW.016,Kelurahan%20Kaligandu,Kecamatan%20Serang,+City,+Kota%20Serang%20Banten,+42116+Indonesia';
        $this->license = 'https://github.com/ariwiraasmara/syafiq_psikotest_backend_laravel?tab=AGPL-3.0-1-ov-file#';
    }

    public function getAppname(): String|float|null {
        return $this->appname;
    }

    public function getApplogo(): String|float|null {
        return $this->appname;
    }

    public function getAppdescription(): String|float|null {
        return $this->appname;
    }

    public function getVersion(): String|float|null {
        return $this->version;
    }

    public function getVendorname(): String|float|null {
        return $this->vendorname;
    }

    public function getVendordescription(): String|float|null {
        return $this->vendordescription;
    }

    public function getVendoraddress(): String|float|null {
        return $this->verdoraddress;
    }

    public function getVendorlinkgooglemap(): String|float|null {
        return $this->verdoraddress;
    }

    public function getLicenses() {
        return $this->license;
    }

    public function homepage(): String {
        return $this->getAppname().' | '.$this->getVendorname();
    }

    public function getTitlepage(): String {
        return ' | '.$this->getAppname().' | '.$this->getVendorname();
    }

    public function json_copyrights(): String {
        $year = date('Y');
        $indent = "    "; // indent 4 spaces;
        return $indent."\"copyrights @ $year\": {\n".
            $indent.$indent."\"vendor\": \"$this->vendorname\"\n".
            $indent.$indent."\"app_name\": \"$this->appname\"\n".
            $indent.$indent."\"app_description\": \"$this->appdescription\"\n".
            $indent.$indent."\"app_version\": \"$this->version\"\n".
            $indent.$indent."\"license\": \"$this->license\"\n".
            $indent.$indent."\"team\": {\n".
            $indent.$indent.$indent."\"Syafiq Marzuki\": {\n".
            $indent.$indent.$indent.$indent."\"Psikolog\",\n".
            $indent.$indent.$indent."},\n".
            $indent.$indent.$indent."\"Muhtar\": {\n".
            $indent.$indent.$indent.$indent."\"Marketing dan IT Support\",\n".
            $indent.$indent.$indent."},\n".
            $indent.$indent.$indent."\"Syahri Ramadhan Wiraasmara\": {\n".
            $indent.$indent.$indent.$indent."\"Developer IT\",\n".
            $indent.$indent.$indent.$indent."\"ariwiraasmara.sc37@gmail.com\",\n".
            $indent.$indent.$indent."},\n".
            $indent.$indent."},\n".
        $indent."}\n";
    }
}
# Security Check

Pada proyek ini terdapat dua command untuk memeriksa sistem keamanan:
1. ./vendor/bin/phpstan analyse [nama_folder_yg_ingin_dicek]
2. ./vendor/bin/security-checker security:check composer.lock

Selain itu CSP Report juga aktif, dimana endpointnya adalah `/api/csp-report`

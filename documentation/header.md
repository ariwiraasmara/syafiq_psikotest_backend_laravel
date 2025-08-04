# Header Documentation

adalah sebuah dokumentasi untuk "Header" Request. Terdapat beberapa "Header" Request yang diperlukan untuk menjalankan aplikasi. Dibagi menjadi 2 kelompok, yakni :

**1. Login Admin**
   - BearerTokenCheck
   - CheckTokenLogin
   - MatchingUserData
   - UserRememberTokenCheck
   - Pranker
   - LogRequest
   - CacheControlMiddleware
   - CSRF_Check
  
**2. User Peserta**
   - CacheControlMiddleware::class,
   - CheckTokenLogin::class,
   - LogRequest::class

Berikut adalah header yang diperlukan dalam menjalankan aplikasi ini :
1. BearerTokenCheck,**
   Header yang digunakan untuk mengecek ketersediaan dan validasi Bearer Token

2. CheckTokenLogin,**
   Header yang digunakan untuk mengecek ketersediaan dan validasi `tokenlogin`

3. MatchingUserData,**
   Header yang digunakan untuk mengecek ketersediaan dan validasi `email` user admin

4. UserRememberTokenCheck,**
   Header yang digunakan untuk mengecek ketersediaan dan validasi `remember-token`

5. LogRequest,**
   Header yang digunakan untuk menangkap dan menerima semua request.

6. CacheControlMiddleware::class,**
   Header yang digunakan untuk set `Cache-Control` dengan maksimal usia 3600 dan bersifat publik `(public, max-age=3600)`
   
7. CSRF_Check,**
   Header yang digunakan untuk mengecek ketersediaan dan validasi csrf guna menghindari serangan XSS (Cross Site Scripting).
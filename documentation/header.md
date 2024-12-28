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

5. Pranker,**
   Header yang digunakan untuk meningkatkan keamanan. Yang harus ditambahkan :
   1. `--unique--` => `I am unique!`
   2. `isvalid` => `VALID!`
   3. `isallowed` => any
   4. `key` => any
   5. `values` => any
   6. `isdumb` => `no`
   7. `challenger` => `of course`
   8. `pranked` => `absolutely`
   
6. LogRequest,**
   Header yang digunakan untuk menangkap dan menerima semua request.

7. CacheControlMiddleware::class,**
   Header yang digunakan untuk set `Cache-Control` dengan maksimal usia 3600 dan bersifat publik `(public, max-age=3600)`
   
8. CSRF_Check,**
   Header yang digunakan untuk mengecek ketersediaan dan validasi csrf guna menghindari serangan XSS (Cross Site Scripting).
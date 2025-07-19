<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class as2001_kecermatan_kolompertanyaan extends Model {
    /** @use HasFactory<\Database\Factories\As2001KecermatanKolompertanyaanFactory> */
    use HasFactory;

    protected $guarded = [];
    protected $table = 'as2001_kecermatan_kolompertanyaan';
    // protected $primaryKey = 'id';
    protected $fillable = [
        // 'id',
        'kolom_x',
        'nilai_A',
        'nilai_B',
        'nilai_C',
        'nilai_D',
        'nilai_E',
        'created_at',
        'updated_at',
    ];

    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    //? Punya banyak data di table as1002_peserta_hasilnilai_teskecermatan
    public function as2002_kecermatan_soaljawaban() {
        return $this->hasMany(as2002_kecermatan_soaljawaban::class);
    }
}

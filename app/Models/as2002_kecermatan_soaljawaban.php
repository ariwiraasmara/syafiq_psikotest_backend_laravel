<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class as2002_kecermatan_soaljawaban extends Model {
    /** @use HasFactory<\Database\Factories\As2002KecermatanSoaljawabanFactory> */
    use HasFactory;

    protected $guarded = [];
    protected $table = 'as2002_kecermatan_soaljawaban';
    // protected $primaryKey = 'id';
    protected $fillable = [
        // 'id',
        'id2001',
        'soal_jawaban',
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'soal_jawaban' => 'array',  // Pastikan ini ada, untuk meng-cast kolom JSON menjadi array
    ];

    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    //? Punya satu data di table as2001_kecermatan_kolompertanyaan yang mana parent tablenya
    public function as2001_kecermatan_kolompertanyaan() {
        return $this->belongsTo(as2001_kecermatan_kolompertanyaan::class);
    }

}

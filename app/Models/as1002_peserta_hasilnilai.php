<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class as1002_peserta_hasilnilai extends Model {
    /** @use HasFactory<\Database\Factories\As1001PesertaHasilnilaiFactory> */
    use HasFactory;

    protected $guarded = [];
    protected $table = 'as1002_peserta_hasilnilai';
    // protected $primaryKey = 'id';
    protected $fillable = [
        // 'id',
        'id1001',
        'hasilnilai_kolom_1',
        'hasilnilai_kolom_2',
        'hasilnilai_kolom_3',
        'hasilnilai_kolom_4',
        'hasilnilai_kolom_5',
    ];

    public $timestamps = false;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}

<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
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
}

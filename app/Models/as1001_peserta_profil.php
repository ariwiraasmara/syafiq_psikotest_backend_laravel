<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class as1001_peserta_profil extends Model
{
    /** @use HasFactory<\Database\Factories\As1001PesertaProfilFactory> */
    use HasFactory;

    protected $guarded = [];
    protected $table = 'as1001_peserta_profil';
    // protected $primaryKey = 'id';
    protected $fillable = [
        // 'id',
        'nama',
        'no_identitas',
        'email',
        'tgl_lahir',
        'usia',
        'asal',
        'tgl_ujian',
    ];

    public $timestamps = false;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
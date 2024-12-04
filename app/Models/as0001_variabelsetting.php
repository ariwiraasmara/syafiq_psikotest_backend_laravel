<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class as0001_variabelsetting extends Model {
    /** @use HasFactory<\Database\Factories\As0001VariabelsettingFactory> */
    use HasFactory;

    protected $guarded = [];
    protected $table = 'as0001_variabelsetting';
    // protected $primaryKey = 'id';
    protected $fillable = [
        // 'id',
        'variabel',
        'values',
        'created_at',
        'updated_at',
    ];

    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}

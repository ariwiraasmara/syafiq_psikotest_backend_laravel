<?php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserDetail extends Model {
    //
    use HasFactory;

    protected $guarded = [];
    protected $table = 'users_detail';
    // protected $primaryKey = 'id';
    protected $fillable = [
        'no_identitas',
        'tgl_lahir',
        'jk',
        'alamat',
        'status',
        'agama',
        'foto',
    ];

    public $timestamps = false;
}

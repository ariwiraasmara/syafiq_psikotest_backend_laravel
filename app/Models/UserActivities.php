<?php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class UserActivities extends Model {
    //
    use HasFactory;

    protected $guarded = [];
    protected $table = 'users_activities';
    // protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'id_user',
        'ip_address',
        'path',
        'url',
        'page',
        'event',
        'deskripsi',
        'properties',
        'user_agent',
        'created_at',
    ];

    public $timestamps = false;
}

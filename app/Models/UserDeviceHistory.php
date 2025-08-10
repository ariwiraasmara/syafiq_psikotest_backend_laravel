<?php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserDeviceHistory extends Model {
    //
    use HasFactory;

    protected $guarded = [];
    protected $table = 'users_device_history';
    // protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'id_user',
        'ip_address',
        'user_agent',
        'last_login',
        'last_logout',
    ];

    public $timestamps = false;
}

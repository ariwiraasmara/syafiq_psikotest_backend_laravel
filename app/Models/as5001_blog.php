<?php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class as5001_blog extends Model {
    //
    use HasFactory;

    protected $guarded = [];
    protected $table = 'as5001_blog';
    // protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'id_user',
        'title',
        'content',
        'category',
        'status',
        'pictures',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const DELETED_AT = 'deleted_at';
}

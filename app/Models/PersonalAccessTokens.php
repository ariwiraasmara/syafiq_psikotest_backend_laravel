<?php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class PersonalAccessTokens extends Model {
    use HasFactory;
    //
    protected $guarded = [];
    protected $table = 'personal_access_tokens';
    // protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'tokenable_type',
        'tokenable_id',
        'name',
        'token',
        'abilities',
        'last_used_at',
        'expires_at',
        'created_at',
        'updated_at',
    ];

    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    //? Punya satu data di table User yang mana parent tablenya
    public function user() {
        return $this->belongsTo(User::class);
    }
}

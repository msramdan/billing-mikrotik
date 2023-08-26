<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecretPpp extends Model
{
    use HasFactory;

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'secret_ppps';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['username', 'password', 'service', 'profile', 'last_logout', 'komentar', 'status'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['username' => 'string', 'password' => 'string', 'service' => 'string', 'profile' => 'string', 'last_logout' => 'string', 'komentar' => 'string', 'status' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];
    

}

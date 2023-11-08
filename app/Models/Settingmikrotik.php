<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settingmikrotik extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'settingmikrotiks';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['identitas_router', 'company_id','host', 'port', 'username', 'password', 'is_active'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['identitas_router' => 'string', 'host' => 'string', 'port' => 'integer', 'username' => 'string', 'password' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var string[]
     */
    protected $hidden = ['password'];
}

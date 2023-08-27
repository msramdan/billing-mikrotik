<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivePpp extends Model
{
    use HasFactory;

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'active_ppps';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['name', 'service', 'caller_id', 'ip_address', 'uptime', 'komentar'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['name' => 'string', 'service' => 'string', 'caller_id' => 'string', 'ip_address' => 'string', 'uptime' => 'string', 'komentar' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];
    

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dhcp extends Model
{
    use HasFactory;

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dhcps';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['address', 'mac_address', 'host_name', 'server', 'status', 'last_seen'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['address' => 'string', 'mac_address' => 'string', 'host_name' => 'string', 'server' => 'string', 'status' => 'string', 'last_seen' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];
    

}

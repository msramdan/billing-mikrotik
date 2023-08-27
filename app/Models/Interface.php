<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interface extends Model
{
    use HasFactory;

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'interfaces';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['name', 'type', 'mtu', 'download', 'upload', 'mac_address'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['name' => 'string', 'type' => 'string', 'mtu' => 'string', 'download' => 'string', 'upload' => 'string', 'mac_address' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];
    

}

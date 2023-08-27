<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotspotactive extends Model
{
    use HasFactory;

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hotspotactives';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['server', 'user', 'address', 'uptime', 'comment'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['server' => 'string', 'user' => 'string', 'address' => 'string', 'uptime' => 'string', 'comment' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];
    

}

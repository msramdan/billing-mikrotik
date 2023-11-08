<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaCoverage extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'area_coverages';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['kode_area', 'tampilkan_register', 'nama', 'alamat', 'keterangan', 'radius', 'latitude', 'longitude','company_id'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['kode_area' => 'string', 'nama' => 'string', 'alamat' => 'string', 'keterangan' => 'string', 'radius' => 'integer', 'latitude' => 'string', 'longitude' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];
}

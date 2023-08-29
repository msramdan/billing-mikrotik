<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Odp extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'odps';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['kode_odc', 'nomor_port_odc', 'kode_odp', 'wilayah_odp', 'warna_tube_fo', 'nomor_tiang', 'jumlah_port', 'document', 'description', 'latitude', 'longitude'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['nomor_port_odc' => 'integer', 'kode_odp' => 'string', 'warna_tube_fo' => 'string', 'nomor_tiang' => 'integer', 'jumlah_port' => 'integer', 'document' => 'string', 'description' => 'string', 'latitude' => 'string', 'longitude' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];


    public function odc()
    {
        return $this->belongsTo(\App\Models\Odc::class);
    }
    public function area_coverage()
    {
        return $this->belongsTo(\App\Models\AreaCoverage::class);
    }
}

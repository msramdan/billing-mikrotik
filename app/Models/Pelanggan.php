<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pelanggans';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['coverage_area', 'odc', 'odp', 'no_port_odp', 'no_layanan', 'nama', 'tanggal_daftar', 'email', 'no_wa', 'no_ktp', 'photo_ktp', 'alamat', 'password', 'ppn', 'status_berlangganan', 'paket_layanan', 'jatuh_tempo', 'kirim_tagihan_wa', 'latitude', 'longitude', 'auto_isolir', 'tempo_isolir', 'router', 'user_pppoe','mode_user','user_static'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['no_layanan' => 'integer', 'nama' => 'string', 'tanggal_daftar' => 'date:d/m/Y', 'email' => 'string', 'no_wa' => 'integer', 'no_ktp' => 'string', 'photo_ktp' => 'string', 'alamat' => 'string', 'password' => 'string', 'jatuh_tempo' => 'integer', 'latitude' => 'string', 'longitude' => 'string', 'tempo_isolir' => 'integer', 'user_pppoe' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var string[]
     */
    protected $hidden = ['password'];

    public function area_coverage()
    {
        return $this->belongsTo(\App\Models\AreaCoverage::class);
    }
    public function odc()
    {
        return $this->belongsTo(\App\Models\Odc::class);
    }
    public function odp()
    {
        return $this->belongsTo(\App\Models\Odp::class);
    }
    public function package()
    {
        return $this->belongsTo(\App\Models\Package::class);
    }
    public function settingmikrotik()
    {
        return $this->belongsTo(\App\Models\Settingmikrotik::class);
    }
}

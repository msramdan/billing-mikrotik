<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'companies';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['nama_perusahaan', 'nama_pemilik', 'telepon_perusahaan', 'no_wa', 'email', 'alamat', 'deskripsi_perusahaan', 'logo', 'favicon'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['nama_perusahaan' => 'string', 'nama_pemilik' => 'string', 'telepon_perusahaan' => 'string', 'no_wa' => 'string', 'email' => 'string', 'alamat' => 'string', 'deskripsi_perusahaan' => 'string', 'logo' => 'string', 'favicon' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];
    

}

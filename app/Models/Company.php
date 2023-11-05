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
    protected $fillable = ['nama_perusahaan', 'nama_pemilik', 'telepon_perusahaan', 'email', 'no_wa', 'alamat', 'deskripsi_perusahaan', 'logo', 'favicon', 'url_wa_gateway', 'api_key_wa_gateway', 'is_active', 'footer_pesan_wa_tagihan', 'footer_pesan_wa_pembayaran', 'url_tripay', 'api_key_tripay', 'kode_merchant', 'private_key', 'paket_id','expired'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['nama_perusahaan' => 'string', 'nama_pemilik' => 'string', 'telepon_perusahaan' => 'string', 'email' => 'string', 'no_wa' => 'string', 'alamat' => 'string', 'deskripsi_perusahaan' => 'string', 'logo' => 'string', 'favicon' => 'string', 'url_wa_gateway' => 'string', 'api_key_wa_gateway' => 'string', 'footer_pesan_wa_tagihan' => 'string', 'footer_pesan_wa_pembayaran' => 'string', 'url_tripay' => 'string', 'api_key_tripay' => 'string', 'kode_merchant' => 'string', 'private_key' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];


	public function paket()
	{
		return $this->belongsTo(\App\Models\Paket::class);}
}

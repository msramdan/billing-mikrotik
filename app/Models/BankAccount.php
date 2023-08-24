<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bank_accounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['bank_id', 'pemilik_rekening', 'nomor_rekening'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['pemilik_rekening' => 'string', 'nomor_rekening' => 'integer', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];


    public function bank()
    {
        return $this->belongsTo(\App\Models\Bank::class);
    }
}

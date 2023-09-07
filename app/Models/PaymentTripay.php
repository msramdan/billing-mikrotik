<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTripay extends Model
{
    use HasFactory;

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payment_tripays';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['kode_merchant', 'api_key', 'private_key','url'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['kode_merchant' => 'string', 'api_key' => 'string', 'private_key' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];


}

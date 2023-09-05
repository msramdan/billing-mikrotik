<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pengeluarans';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['nominal', 'tanggal', 'keterangan'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['nominal' => 'integer', 'tanggal' => 'datetime:d/m/Y H:i', 'keterangan' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];
    

}

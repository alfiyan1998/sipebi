<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataBmn extends Model
{
    protected $table = 'tb_bmn';

    protected $primaryKey = 'id';

    protected $fillable = ['kode_barang','nama_barang','merk', 'deskripsi','jenis_bmn_id'];

    public function jenisbmn()
    {
        return $this->belongsTo(JenisBmn::class, 'jenis_bmn_id');
    }
    public function listPenggunaan()
    {
        // Relasi One-to-Many
        return $this->hasMany(ListPenggunaan::class, 'bmn_id');
    }
}

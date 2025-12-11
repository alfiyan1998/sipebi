<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penggunaan extends Model
{
    protected $table = 'tb_penggunaan';

    protected $fillable = [
        'user_id',
        'tanggal_penggunaan',
        'tanggal_kembali',
        'kode_list',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items()
    {
        // Relasi One-to-Many ke item yang dipinjam
        return $this->hasMany(ListPenggunaan::class, 'kode_list', 'kode_list');
    }
}

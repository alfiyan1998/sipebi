<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListPenggunaan extends Model
{
    //
    protected $table = 'list_penggunaan';

    protected $fillable = [
        'kode_list',
        'bmn_id'
       
    ];
    public function penggunaan()
    {
        return $this->belongsTo(Penggunaan::class, 'kode_list', 'kode_list');
    }

    public function bmn()
    {
        return $this->belongsTo(DataBMN::class, 'bmn_id');
    }
}

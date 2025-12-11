<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisBMN extends Model
{
    //
    protected $table = 'tb_jenisbmn';
    protected $fillable = ['kode_bmn', 'jenis_bmn'];
    protected $primaryKey = 'id';
}

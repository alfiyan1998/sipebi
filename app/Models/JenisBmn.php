<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisBmn extends Model
{
    protected $table = 'tb_jenisbmn';
    protected $fillable = ['kode_bmn', 'jenis_bmn'];
    protected $primaryKey = 'id';
}

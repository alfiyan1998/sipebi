<?php

namespace App\Imports;

use App\Models\DataBMN;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\JenisBMN;


class BarangImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $kodeJenis = $row['jenis_bmn'];
        $jenisBmn = JenisBMN::where('kode_bmn', $kodeJenis)->first();

        if (!$jenisBmn) {
            // Jika jenis_bmn tidak ditemukan, Anda bisa memilih untuk
            $jenisBmn = JenisBMN::create([
                'kode_bmn' => $kodeJenis,
                'jenis_bmn' => $row['jenis_bmn_nama'] ?? $kodeJenis,
            ]);
        }

        return new DataBMN([
            'kode_barang'  => $row['kode_barang'],
            'nama_barang'  => $row['nama_barang'],
            'merk'         => $row['merk'] ?? '-',
            'jenis_bmn_id' => $jenisBmn->id,
        ]);
    }
}
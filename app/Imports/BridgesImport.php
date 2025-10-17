<?php

namespace App\Imports;

use App\Models\Bridge;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BridgesImport implements ToModel, WithHeadingRow
{
    /**
     * Import baris dari file Excel ke tabel "bridges".
     *
     * Header kolom Excel harus seperti ini:
     * kode | nama | lokasi | kecamatan | lat | lng | panjang | lebar | tahun | kondisi | deskripsi
     */
    public function model(array $row)
    {
        // Abaikan jika baris kosong
        if (empty($row['kode']) || empty($row['nama'])) {
            return null;
        }

        return new Bridge([
            'kode'       => $row['kode'],
            'nama'       => $row['nama'],
            'lokasi'     => $row['lokasi'] ?? null,
            'kecamatan'  => $row['kecamatan'] ?? null,
            'lat'        => $row['lat'] ?? null,
            'lng'        => $row['lng'] ?? null,
            'panjang'    => $row['panjang'] ?? null,
            'lebar'      => $row['lebar'] ?? null,
            'tahun'      => $row['tahun'] ?? null,
            'kondisi'    => $row['kondisi'] ?? 'Baik',
            'deskripsi'  => $row['deskripsi'] ?? '-',
        ]);
    }
}

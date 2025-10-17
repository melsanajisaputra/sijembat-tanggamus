<?php

namespace App\Exports;

use App\Models\Bridge;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BridgesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Bridge::select('kode','nama','lokasi','kecamatan','lat','lng','panjang','lebar','tahun','kondisi','deskripsi')->get();
    }

    public function headings(): array
    {
        return ['Kode', 'Nama', 'Lokasi', 'Kecamatan', 'Latitude', 'Longitude', 'Panjang (m)', 'Lebar (m)', 'Tahun', 'Kondisi', 'Deskripsi'];
    }
}

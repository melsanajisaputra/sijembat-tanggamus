<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bridge extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama',
        'lokasi',
        'kecamatan',
        'lat',
        'lng',
        'panjang',
        'lebar',
        'tahun',
        'kondisi',
        'deskripsi',
        'foto_depan',
        'foto_belakang',
        'foto_kanan',
        'foto_kiri',
    ];
}

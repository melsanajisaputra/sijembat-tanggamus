<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bridge;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 🔹 Ambil semua data untuk filter dropdown
        $kecamatanList = Bridge::select('kecamatan')->distinct()->pluck('kecamatan');

        // 🔹 Filter dinamis
        $filterKecamatan = $request->get('kecamatan', 'Semua');
        $filterKondisi = $request->get('kondisi', 'Semua');

        // 🔹 Query dasar
        $query = Bridge::query();

        if ($filterKecamatan != 'Semua') {
            $query->where('kecamatan', $filterKecamatan);
        }

        if ($filterKondisi != 'Semua') {
            $query->where('kondisi', $filterKondisi);
        }

        // 🔹 Ambil semua data (tanpa paginate!)
        $bridges = $query->get();

        // 🔹 Hitung total untuk chart
        $counts = (object) [
            'baik'   => Bridge::where('kondisi', 'Baik')->count(),
            'sedang' => Bridge::where('kondisi', 'Sedang')->count(),
            'ringan' => Bridge::where('kondisi', 'Rusak Ringan')->count(),
            'berat'  => Bridge::where('kondisi', 'Rusak Berat')->count(),
        ];

        // 🔹 Kirim ke view
        return view('dashboard', compact(
            'bridges',
            'counts',
            'kecamatanList',
            'filterKecamatan',
            'filterKondisi'
        ));
    }
}

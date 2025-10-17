<?php

namespace App\Http\Controllers;

use App\Models\Bridge;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BridgesImport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\BridgesExport;
use Illuminate\Support\Facades\Storage;

class BridgeController extends Controller
{
    public function index()
    {
        $bridges = Bridge::orderBy('kecamatan')->get();
        return view('bridges.index', compact('bridges'));
    }

    public function create()
    {
        return view('bridges.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:bridges',
            'nama' => 'required',
            'lokasi' => 'required',
            'kecamatan' => 'required',
            'kondisi' => 'required',
        ]);

        $data = $request->all();

        // Upload foto jika ada
        foreach (['depan', 'belakang', 'kanan', 'kiri'] as $posisi) {
            $field = "foto_{$posisi}";
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('bridges', 'public');
            }
        }

        Bridge::create($data);
        return redirect()->route('bridges.index')->with('success', 'Data jembatan berhasil ditambahkan!');
    }

    public function edit(Bridge $bridge)
    {
        return view('bridges.edit', compact('bridge'));
    }

    public function update(Request $request, Bridge $bridge)
    {
        $request->validate([
            'nama' => 'required',
            'lokasi' => 'required',
            'kecamatan' => 'required',
            'kondisi' => 'required',
        ]);

        $data = $request->all();

        foreach (['depan', 'belakang', 'kanan', 'kiri'] as $posisi) {
            $field = "foto_{$posisi}";
            if ($request->hasFile($field)) {
                if ($bridge->$field && Storage::disk('public')->exists($bridge->$field)) {
                    Storage::disk('public')->delete($bridge->$field);
                }
                $data[$field] = $request->file($field)->store('bridges', 'public');
            }
        }

        $bridge->update($data);
        return redirect()->route('bridges.index')->with('success', 'Data jembatan berhasil diperbarui!');
    }

    public function destroy(Bridge $bridge)
    {
        foreach (['foto_depan', 'foto_belakang', 'foto_kanan', 'foto_kiri'] as $field) {
            if ($bridge->$field && Storage::disk('public')->exists($bridge->$field)) {
                Storage::disk('public')->delete($bridge->$field);
            }
        }

        $bridge->delete();
        return redirect()->route('bridges.index')->with('success', 'Data jembatan berhasil dihapus!');
    }

    // ✅ Import Excel
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new BridgesImport, $request->file('file'));
            return response()->json([
                'success' => true,
                'message' => '✅ Data jembatan berhasil diimport ke database.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '❌ Gagal mengimpor data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $bridge = Bridge::findOrFail($id);
        return view('bridges.show', compact('bridge'));
    }

    public function exportExcel()
    {
        return Excel::download(new BridgesExport, 'data_jembatan_tanggamus.xlsx');
    }

    public function exportPDF()
    {
        $bridges = Bridge::orderBy('kecamatan')->get();
        $pdf = Pdf::loadView('bridges.export_pdf', compact('bridges'))->setPaper('a4', 'landscape');
        return $pdf->download('data_jembatan_tanggamus.pdf');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Bridge;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        $bridges = Bridge::orderBy('kecamatan')->paginate(11);
        $allBridges = Bridge::all();

        return view('public.index', compact('bridges', 'allBridges'));
    }

   public function show($id)
{
    $bridge = Bridge::findOrFail($id);
    return view('public.detail', compact('bridge'));
}
}

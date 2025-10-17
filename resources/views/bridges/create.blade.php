@extends('layouts.admin')

@section('content')
<div class="container">
    <h4 class="mb-3">Tambah Data Jembatan</h4>

    <form action="{{ route('bridges.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group mb-2">
            <label>Kode</label>
            <input type="text" name="kode" class="form-control" required>
        </div>

        <div class="form-group mb-2">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="form-group mb-2">
            <label>Lokasi</label>
            <input type="text" name="lokasi" class="form-control" required>
        </div>

        <div class="form-group mb-2">
            <label>Kecamatan</label>
            <input type="text" name="kecamatan" class="form-control" required>
        </div>

        <div class="form-group mb-2">
            <label>Kondisi</label>
            <select name="kondisi" class="form-control" required>
                <option value="Baik">Baik</option>
                <option value="Sedang">Sedang</option>
                <option value="Rusak Ringan">Rusak Ringan</option>
                <option value="Rusak Berat">Rusak Berat</option>
            </select>
        </div>

        <div class="form-group mb-2">
            <label>Latitude</label>
            <input type="text" name="lat" class="form-control" placeholder="-5.4980">
        </div>

        <div class="form-group mb-2">
            <label>Longitude</label>
            <input type="text" name="lng" class="form-control" placeholder="104.5093">
        </div>

        <div class="form-group mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Keterangan tambahan..."></textarea>
        </div>

        <hr>
        <h5 class="mt-4 mb-3">Dokumentasi Jembatan</h5>

        <div class="row">
            <div class="col-md-3 mb-3">
                <label>Foto Tampak Depan</label>
                <input type="file" name="foto_depan" class="form-control" accept="image/*" onchange="previewImage(event, 'previewDepan')">
                <img id="previewDepan" class="mt-2 img-thumbnail" style="width:100%;max-height:160px;object-fit:cover;">
            </div>

            <div class="col-md-3 mb-3">
                <label>Foto Tampak Belakang</label>
                <input type="file" name="foto_belakang" class="form-control" accept="image/*" onchange="previewImage(event, 'previewBelakang')">
                <img id="previewBelakang" class="mt-2 img-thumbnail" style="width:100%;max-height:160px;object-fit:cover;">
            </div>

            <div class="col-md-3 mb-3">
                <label>Foto Samping Kanan</label>
                <input type="file" name="foto_kanan" class="form-control" accept="image/*" onchange="previewImage(event, 'previewKanan')">
                <img id="previewKanan" class="mt-2 img-thumbnail" style="width:100%;max-height:160px;object-fit:cover;">
            </div>

            <div class="col-md-3 mb-3">
                <label>Foto Samping Kiri</label>
                <input type="file" name="foto_kiri" class="form-control" accept="image/*" onchange="previewImage(event, 'previewKiri')">
                <img id="previewKiri" class="mt-2 img-thumbnail" style="width:100%;max-height:160px;object-fit:cover;">
            </div>
        </div>

        <button class="btn btn-success mt-3"><i class="fas fa-save"></i> Simpan</button>
        <a href="{{ route('bridges.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </form>
</div>

<script>
function previewImage(event, id) {
    const reader = new FileReader();
    reader.onload = function() {
        document.getElementById(id).src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endsection

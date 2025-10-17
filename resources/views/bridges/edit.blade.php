@extends('layouts.admin')

@section('content')
<div class="container">
    <h4 class="mb-3">Edit Data Jembatan</h4>

    <form action="{{ route('bridges.update', $bridge->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group mb-2">
            <label>Kode</label>
            <input type="text" name="kode" value="{{ $bridge->kode }}" class="form-control" readonly>
        </div>

        <div class="form-group mb-2">
            <label>Nama</label>
            <input type="text" name="nama" value="{{ $bridge->nama }}" class="form-control" required>
        </div>

        <div class="form-group mb-2">
            <label>Lokasi</label>
            <input type="text" name="lokasi" value="{{ $bridge->lokasi }}" class="form-control" required>
        </div>

        <div class="form-group mb-2">
            <label>Kecamatan</label>
            <input type="text" name="kecamatan" value="{{ $bridge->kecamatan }}" class="form-control" required>
        </div>

        <div class="form-group mb-2">
            <label>Kondisi</label>
            <select name="kondisi" class="form-control" required>
                <option value="Baik" {{ $bridge->kondisi == 'Baik' ? 'selected' : '' }}>Baik</option>
                <option value="Sedang" {{ $bridge->kondisi == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                <option value="Rusak Ringan" {{ $bridge->kondisi == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                <option value="Rusak Berat" {{ $bridge->kondisi == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
            </select>
        </div>

        <div class="form-group mb-2">
            <label>Latitude</label>
            <input type="text" name="lat" value="{{ $bridge->lat }}" class="form-control">
        </div>

        <div class="form-group mb-2">
            <label>Longitude</label>
            <input type="text" name="lng" value="{{ $bridge->lng }}" class="form-control">
        </div>

        <div class="form-group mb-2">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control">{{ $bridge->deskripsi }}</textarea>
        </div>

        <hr>
        <h5 class="mt-4 mb-3">Dokumentasi Jembatan</h5>

        <div class="row">
            @foreach (['depan', 'belakang', 'kanan', 'kiri'] as $pos)
                @php $foto = "foto_{$pos}"; @endphp
                <div class="col-md-3 mb-3">
                    <label>Foto Tampak {{ ucfirst($pos) }}</label>
                    @if ($bridge->$foto)
                        <img src="{{ asset('storage/' . $bridge->$foto) }}" 
                             alt="Foto {{ $pos }}" 
                             class="img-thumbnail mb-2" 
                             style="width: 100%; height: 150px; object-fit: cover;">
                    @else
                        <p><i>Belum ada foto</i></p>
                    @endif

                    <input type="file" name="foto_{{ $pos }}" class="form-control" accept="image/*" onchange="previewImage(event, '{{ $pos }}Preview')">
                    <img id="{{ $pos }}Preview" style="margin-top:10px;max-width:100%;max-height:150px;border-radius:5px;">
                </div>
            @endforeach
        </div>

        <button class="btn btn-success mt-3">Update</button>
        <a href="{{ route('bridges.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </form>
</div>

<script>
function previewImage(event, id) {
    const reader = new FileReader();
    reader.onload = function(){
        document.getElementById(id).src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endsection

@extends('layouts.admin')

@section('content')
<div class="container">
  <h4 class="mb-4">Detail Jembatan</h4>

  <!-- Info Utama -->
  <div class="card mb-4 shadow-sm">
    <div class="card-body">
      <h5><strong>{{ $bridge->nama }}</strong></h5>
      <p class="mb-1"><b>Kode:</b> {{ $bridge->kode }}</p>
      <p class="mb-1"><b>Kecamatan:</b> {{ $bridge->kecamatan }}</p>
      <p class="mb-1"><b>Lokasi:</b> {{ $bridge->lokasi }}</p>
      <p class="mb-1"><b>Kondisi:</b> {{ $bridge->kondisi }}</p>
      <p class="mb-1"><b>Koordinat:</b> {{ $bridge->lat }}, {{ $bridge->lng }}</p>

      @if($bridge->deskripsi)
        <p class="mt-3"><b>Deskripsi:</b><br>{{ $bridge->deskripsi }}</p>
      @endif
    </div>
  </div>

  <!-- Peta -->
  <div class="card mb-4 shadow-sm">
    <div class="card-header bg-info text-white">
      <b>Peta Lokasi Jembatan</b>
    </div>
    <div class="card-body">
      <div id="map" style="height:350px; border-radius:8px;"></div>
    </div>
  </div>

  <!-- Galeri -->
  <div class="card mb-4 shadow-sm">
    <div class="card-header bg-secondary text-white">
      <b>Galeri Dokumentasi</b>
    </div>
    <div class="card-body">
      <div class="row">
        @foreach (['depan', 'belakang', 'kanan', 'kiri'] as $pos)
          @php $foto = "foto_{$pos}"; @endphp
          @if ($bridge->$foto)
            <div class="col-md-3 mb-3 text-center">
              <a href="{{ asset('storage/' . $bridge->$foto) }}" data-lightbox="galeri" data-title="Tampak {{ ucfirst($pos) }}">
                <img src="{{ asset('storage/' . $bridge->$foto) }}" class="img-fluid rounded shadow-sm" style="height:180px;object-fit:cover;">
              </a>
              <p class="mt-2"><b>Tampak {{ ucfirst($pos) }}</b></p>
            </div>
          @endif
        @endforeach
      </div>

      @if (!$bridge->foto_depan && !$bridge->foto_belakang && !$bridge->foto_kanan && !$bridge->foto_kiri)
        <p class="text-muted text-center mt-3">Belum ada foto dokumentasi.</p>
      @endif
    </div>
  </div>

  <a href="{{ route('bridges.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i> Kembali
  </a>
</div>

<!-- Leaflet Map -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

<!-- Lightbox -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

<script>
  // === Inisialisasi Peta ===
  var map = L.map('map').setView([{{ $bridge->lat ?? -5.4980 }}, {{ $bridge->lng ?? 104.5093 }}], 13);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 18,
    attribution: '© OpenStreetMap contributors'
  }).addTo(map);

  @if ($bridge->lat && $bridge->lng)
    L.marker([{{ $bridge->lat }}, {{ $bridge->lng }}]).addTo(map)
      .bindPopup("<b>{{ $bridge->nama }}</b><br>{{ $bridge->lokasi }}");
  @endif
</script>
@endsection

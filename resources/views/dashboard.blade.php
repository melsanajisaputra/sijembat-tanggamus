@extends('layouts.admin')

@section('content')
<style>
    body {
        background-color: #f4f6fa;
        font-family: 'Poppins', sans-serif;
    }

    /* === SIDEBAR MODERN === */
    .main-sidebar {
        background: linear-gradient(90deg, #0052D4, #4364F7, #6FB1FC);
        color: white;
        box-shadow: 4px 0 8px rgba(0, 0, 0, 0.1);
    }

    .brand-link {
        font-weight: 700;
        font-size: 1.25rem;
        text-align: center;
        background: rgba(255, 255, 255, 0.1);
    }

    .nav-sidebar .nav-item {
        margin: 4px 0;
    }

    .nav-sidebar .nav-link {
        color: #e0e0e0;
        font-weight: 500;
        transition: all 0.3s ease;
        border-radius: 10px;
    }

    .nav-sidebar .nav-link i {
        width: 22px;
    }

    .nav-sidebar .nav-link.active,
    .nav-sidebar .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.15);
        color: #fff;
        transform: translateX(4px);
    }

    /* === HEADER === */
    .dashboard-header {
        background: linear-gradient(90deg, #0052D4, #4364F7, #6FB1FC);
        color: white;
        border-radius: 14px;
        padding: 22px 25px;
        margin-bottom: 25px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .dashboard-header h4 {
        font-weight: 700;
    }

    /* === CARD === */
    .card {
        border: none;
        border-radius: 14px;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
    }

    .card-header {
        border-top-left-radius: 14px;
        border-top-right-radius: 14px;
        font-weight: 600;
    }

    /* === MAP & CHART === */
    #map {
        height: 420px;
        border-radius: 14px;
    }

    #bridgeChart {
        height: 385px !important;
    }

    /* === FILTER === */
    .filter-card label {
        font-weight: 600;
        color: #5f5f5f;
    }

    /* === BUTTON === */
    .btn-modern {
        border-radius: 10px;
        font-weight: 600;
    }
</style>

<div class="container-fluid px-3">

    <!-- Header -->
    <div class="dashboard-header d-flex justify-content-between align-items-center">
        <div>
            <h4><i class="fas fa-home"></i> Dashboard SIJEMBAT</h4>
            <p class="mb-0">Dinas Pekerjaan Umum dan Penataan Ruang Kabupaten Tanggamus</p>
        </div>
    </div>

    <!-- Filter -->
    <div class="card filter-card mb-4">
        <div class="card-header bg-light">
            <i class="fas fa-filter text-primary me-2"></i> Filter Data
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('dashboard') }}" class="row">
                <div class="col-md-6 mb-3">
                    <label>Kecamatan</label>
                    <select name="kecamatan" class="form-control" onchange="this.form.submit()">
                        <option value="Semua">Semua Kecamatan</option>
                        @foreach ($kecamatanList as $kec)
                            <option value="{{ $kec }}" {{ $filterKecamatan == $kec ? 'selected' : '' }}>
                                {{ $kec }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Kondisi</label>
                    <select name="kondisi" class="form-control" onchange="this.form.submit()">
                        <option value="Semua">Semua Kondisi</option>
                        <option value="Baik" {{ $filterKondisi == 'Baik' ? 'selected' : '' }}>Baik</option>
                        <option value="Sedang" {{ $filterKondisi == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                        <option value="Rusak Ringan" {{ $filterKondisi == 'Rusak Ringan' ? 'selected' : '' }}>
                            Rusak Ringan</option>
                        <option value="Rusak Berat" {{ $filterKondisi == 'Rusak Berat' ? 'selected' : '' }}>
                            Rusak Berat</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistik & Map -->
    <div class="row">
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-chart-bar me-2"></i> Statistik Kondisi Jembatan
                </div>
                <div class="card-body">
                    <canvas id="bridgeChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-map-marked-alt me-2"></i> Peta Sebaran Jembatan</span>
                </div>
                <div class="card-body p-0">
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS LIBRARIES -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

<script>
    // === Chart.js ===
    const ctx = document.getElementById('bridgeChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Baik', 'Sedang', 'Rusak Ringan', 'Rusak Berat'],
            datasets: [{
                data: [{{ $counts->baik }}, {{ $counts->sedang }}, {{ $counts->ringan }}, {{ $counts->berat }}],
                backgroundColor: ['green', 'blue', 'yellow', 'red']
            }]
        },
        options: {
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });


  // === Inisialisasi Map ===
  var map = L.map('map').setView([-5.4980, 104.5093], 9);

  // === Tile Layer ===
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 18,
    attribution: '© OpenStreetMap contributors'
  }).addTo(map);

  // === Fungsi pembuat ikon warna ===
  function createIcon(color) {
    return L.icon({
      iconUrl: `https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-${color}.png`,
      iconSize: [25, 41],
      iconAnchor: [12, 41],
      popupAnchor: [1, -34],
      shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.3/images/marker-shadow.png',
      shadowSize: [41, 41]
    });
  }

  const iconSet = {
    "Baik": createIcon('green'),
    "Sedang": createIcon('blue'),
    "Rusak Ringan": createIcon('yellow'),
    "Rusak Berat": createIcon('red'),
    "default": createIcon('blue')
  };

  // === Ambil data jembatan dari Laravel ===
  const bridges = @json($bridges);
  

  const markers = [];

  // === Loop untuk menampilkan semua titik ===
  bridges.forEach((b, idx) => {
    const lat = parseFloat(b.lat);
    const lng = parseFloat(b.lng);

    // Hanya tampilkan jika valid koordinat
    if (!isNaN(lat) && !isNaN(lng)) {
      const icon = iconSet[b.kondisi] || iconSet["default"];

      const marker = L.marker([lat, lng], { icon })
        .bindPopup(`
          <b>${b.nama ?? 'Tidak diketahui'}</b><br>
          Kecamatan: ${b.kecamatan ?? '-'}<br>
          Kondisi: <i>${b.kondisi ?? '-'}</i><br>
          <a href="/jembatan/${b.id}" target="_blank" class="btn btn-sm btn-outline-primary mt-1">Detail</a>
        `)
        .addTo(map);

      markers.push(marker);
    } else {
      console.warn(`Jembatan ke-${idx + 1} tidak memiliki koordinat valid:`, b.nama, b.lat, b.lng);
    }
  });

  // === Fit semua titik agar terlihat ===
  if (markers.length > 0) {
    const group = new L.featureGroup(markers);
    map.fitBounds(group.getBounds().pad(0.2));
  } else {
    console.warn("Tidak ada titik jembatan valid ditemukan.");
  }

  // === Tambahkan Legend warna (opsional tapi sangat direkomendasikan) ===
  const legend = L.control({ position: "bottomright" });
  legend.onAdd = function(map) {
    const div = L.DomUtil.create("div", "info legend bg-white p-2 rounded shadow");
    const labels = [
      { color: "green", text: "Baik" },
      { color: "blue", text: "Sedang" },
      { color: "yellow", text: "Rusak Ringan" },
      { color: "red", text: "Rusak Berat" }
    ];
    div.innerHTML = `<b>Kondisi Jembatan</b><br>`;
    labels.forEach(i => {
      div.innerHTML += `<i style="background:${i.color};width:12px;height:12px;display:inline-block;border-radius:50%;margin-right:6px;"></i>${i.text}<br>`;
    });
    return div;
  };
  legend.addTo(map);


</script>
@endsection

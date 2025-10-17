<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Jembatan - {{ $bridge->nama }} | SIJEMBAT Tanggamus</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <!-- FontAwesome & Lightbox -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f8fc;
            color: #2b2b2b;
            overflow-x: hidden;
        }

        /* === HEADER === */
        .detail-header {
            background: linear-gradient(90deg, #0052D4, #4364F7, #6FB1FC);
            color: white;
            padding: 25px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom-left-radius: 18px;
            border-bottom-right-radius: 18px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .detail-header .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .detail-header img {
            width: 50px;
            height: auto;
            filter: drop-shadow(0 3px 6px rgba(0, 0, 0, 0.25));
        }

        .detail-header h3 {
            font-weight: 700;
            font-size: 1.6rem;
            margin: 0;
        }

        .detail-header p {
            font-size: 0.95rem;
            margin: 0;
            opacity: 0.9;
        }

        /* === MAIN CONTAINER === */
        .container-wide {
            width: 95vw;
            max-width: 1800px;
            margin: 30px auto;
            padding: 0 25px;
        }

        .card {
            border-radius: 14px;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        /* === SECTION ATAS (NAMA + PETA) === */
        .bridge-top {
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 25px;
            align-items: start;
        }

        #map {
            height: 350px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* === GALERI === */
        .gallery img {
            border-radius: 10px;
            transition: 0.3s;
            border: 2px solid #f0f0f0;
            width: 100%;
            object-fit: cover;
        }

        .gallery img:hover {
            transform: scale(1.05);
            border-color: #007bff;
        }

        footer {
            background: linear-gradient(90deg, #0052D4, #4364F7, #6FB1FC);
            color: white;
            text-align: center;
            padding: 12px 0;
            margin-top: 40px;
            font-size: 0.95rem;
        }

        @media (max-width: 992px) {
            .bridge-top {
                grid-template-columns: 1fr;
            }

            #map {
                height: 260px;
            }
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <header class="detail-header">
        <div class="header-left">
            <img src="{{ asset('image/logo-tanggamus.png') }}" alt="Logo Tanggamus">
            <div>
                <h3>Sistem Informasi Jembatan</h3>
                <p>Dinas Pekerjaan Umum dan Perumahan Rakyat Kabupaten Tanggamus</p>
            </div>
        </div>
        <div>
            <a href="{{ route('public.jembatan') }}" class="btn btn-light fw-semibold">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </header>

    <!-- DETAIL CONTENT -->
    <div class="container-wide">
        <div class="card p-4">
            <div class="bridge-top mb-4">
                <!-- KIRI: Nama dan Informasi -->
                <div>
                    <h4 class="fw-bold text-primary mb-2"><i class="fas fa-bridge me-2"></i>Jbt.{{ $bridge->nama }}</h4>
                    <p class="text-muted mb-4">Kecamatan {{ $bridge->kecamatan }}</p>
                    <table class="table table-borderless">
                        <tr>
                            <th>Kode</th>
                            <td>: {{ $bridge->kode }}</td>
                        </tr>
                        <tr>
                            <th>Kondisi</th>
                            <td>: {{ $bridge->kondisi }}</td>
                        </tr>
                        <tr>
                            <th>Lokasi</th>
                            <td>: {{ $bridge->lokasi }}</td>
                        </tr>
                        <tr>
                            <th>Koordinat</th>
                            <td>: {{ $bridge->lat }}, {{ $bridge->lng }}</td>
                        </tr>
                        <tr>
                            <th>Deskripsi</th>
                            <td>: {{ $bridge->deskripsi ?? '-' }}</td>
                        </tr>
                    </table>
                </div>

                <!-- KANAN: Peta -->
                <div>
                    <div id="map"></div>
                </div>
            </div>

            <hr>

            <h5 class="fw-semibold mb-3"><i class="fas fa-camera me-2"></i> Dokumentasi Jembatan</h5>
            <div class="row gallery">
                @foreach (['foto_depan' => 'Tampak Depan', 'foto_belakang' => 'Tampak Belakang', 'foto_kanan' => 'Tampak Samping Kanan', 'foto_kiri' => 'Tampak Samping Kiri'] as $field => $label)
                    @if ($bridge->$field)
                        <div class="col-6 col-md-3 mb-3 text-center">
                            <a href="{{ asset('storage/' . $bridge->$field) }}" data-lightbox="gallery"
                                data-title="{{ $label }}">
                                <img src="{{ asset('storage/' . $bridge->$field) }}" class="img-fluid"
                                    alt="{{ $label }}">
                                <small class="d-block mt-1 text-muted">{{ $label }}</small>
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <footer>
        &copy; {{ date('Y') }} Dinas PUPR Kabupaten Tanggamus — Sistem Informasi Jembatan (SIJEMBAT)
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // === Inisialisasi peta ===
        var map = L.map('map').setView([{{ $bridge->lat ?? -5.498 }}, {{ $bridge->lng ?? 104.5093 }}], 13);
        var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        var satelit = L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            attribution: '© Google Maps'
        });

        L.control.layers({
            "🗺️ Peta": osm,
            "🛰️ Satelit": satelit
        }).addTo(map);

        // === Marker posisi jembatan ===
        L.marker([{{ $bridge->lat ?? -5.498 }}, {{ $bridge->lng ?? 104.5093 }}]).addTo(map)
            .bindPopup(`<b>{{ $bridge->nama }}</b><br>{{ $bridge->kecamatan }}<br><i>{{ $bridge->kondisi }}</i>`)
            .openPopup();
    </script>
</body>

</html>

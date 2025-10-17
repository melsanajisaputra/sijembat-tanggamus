<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIJEMBAT - Dinas PUPR Tanggamus</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    <!-- Fullscreen Plugin -->
    <link rel="stylesheet"
        href="https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css" />
    <script src="https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js"></script>

    <style>
        :root {
            --blue1: #007bff;
            --blue2: #007bff;
            --bg: #ffffff;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg);
            margin: 0;
            color: #222;
            overflow-x: hidden;
        }

        .hero {
            position: relative;
            height: 25vh;
            background-image: url('{{ asset('image/background-jembatan.jpg') }}');
            background-size: cover;
            background-position: center;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: left;
            padding: 0 5%;
        }

        .hero-inner {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .hero-logo img {
            width: 90px;
            height: auto;
            filter: drop-shadow(0 3px 6px rgba(0, 0, 0, 0.3));
            transition: transform 0.3s ease;
        }

        .hero-logo img:hover {
            transform: scale(1.05);
        }

        .hero-text h1 {
            padding-top: 2%;
            font-weight: 600;
            font-size: clamp(1.6rem, 4vw, 2.8rem);
            text-shadow: 0 6px 15px rgba(0, 0, 0, .4);
            white-space: nowrap;
            /* 🔹 cegah teks turun baris */
            overflow: hidden;
            text-overflow: ellipsis;
            text-shadow: #0008ff;
        }

        .hero-text p {
            font-size: 1.1rem;
            text-shadow: 0 4px 10px rgba(0, 0, 0, .3);
            margin-top: 4px;
            text-align: center;
        }

        .hero-actions {
            position: absolute;
            top: 20px;
            right: 25px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-glass {
            text-decoration: none;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            border-radius: 10px;
            padding: .35rem .8rem;
            backdrop-filter: blur(10px);
            transition: all .25s ease;
        }

        .btn-glass:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }

        #map {
            height: 70vh;
            width: 96vw;
            margin: 0 auto;
            border-radius: 18px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .15);
        }

        .container-wide {
            max-width: 96vw;
            margin: 40px auto;
        }

        .data-grid {
            display: grid;
            grid-template-columns: 3fr 1fr;
            gap: 20px;
        }

        .card-soft {
            background: #fff;
            border: 0;
            border-radius: 16px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, .08);
            overflow: hidden;
        }

        .card-soft .card-header {
            background: linear-gradient(90deg, var(--blue1), var(--blue2));
            color: #fff;
            font-weight: 600;
            border: 0;
        }

        .table thead th {
            background: linear-gradient(90deg, var(--blue1), var(--blue2));
            color: #fff;
            text-align: center;
            border: 0;
        }

        .stats-box {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, .08);
            overflow: hidden;
        }

        .stats-header {
            background: linear-gradient(90deg, var(--blue1), var(--blue2));
            color: #fff;
            font-weight: 600;
            padding: 10px 14px;
        }

        .stats-body {
            padding: 12px 16px;
            background: #f1f5ff;
        }

        .stat-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 6px 0;
            border-bottom: 1px solid rgba(0, 0, 0, .06);
            font-weight: 500;
        }

        .dot {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            margin-right: 6px;
        }

        footer {
            background: linear-gradient(90deg, var(--blue1), var(--blue2));
            color: #fff;
            text-align: center;
            padding: 14px 0;
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <!-- HERO -->
    <section class="hero">
        <div class="hero-inner">
            <div class="hero-logo"><img src="{{ asset('image/logo-tanggamus.png') }}" alt="Logo Tanggamus"></div>
            <div class="hero-text">
                <h1>SISTEM INFORMASI JEMBATAN KABUPATEN TANGGAMUS</h1>
                <p>Dinas Pekerjaan Umum dan Perumahan Rakyat Kabupaten Tanggamus</p>
            </div>
        </div>
        <div class="hero-actions">
            <a href="#mapSection" class="btn-glass"><i class="fas fa-map me-1"></i>Peta</a>
            <a href="#dataSection" class="btn-glass"><i class="fas fa-table me-1"></i>Data</a>
            <a href="{{ route('login') }}" class="btn-glass"><i class="fas fa-user-lock me-1"></i>Admin</a>
        </div>
    </section>

    <!-- PETA -->
    <section id="mapSection" class="mt-4 mb-5">
        <div id="map"></div>
    </section>

    <!-- DATA -->
    <section id="dataSection" class="container-wide">
        <div class="card card-soft">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fa-solid fa-bridge me-2"></i>Data Jembatan</span>
                <input id="search" type="text" class="form-control w-25" placeholder="🔍 Cari nama jembatan...">
            </div>
            <div class="card-body">
                <div class="data-grid">
                    <div>
                        <table class="table table-hover align-middle" id="bridgeTable">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Kecamatan</th>
                                    <th>Kondisi</th>
                                    <th>Lokasi</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="bridgeTableBody">
                                @foreach ($bridges as $b)
                                    <tr>
                                        <td>{{ $b->kode }}</td>
                                        <td>{{ $b->nama }}</td>
                                        <td>{{ $b->kecamatan }}</td>
                                        <td>{{ $b->kondisi }}</td>
                                        <td>{{ $b->lokasi }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('public.jembatan.show', $b->id) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="fa-solid fa-eye"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>Menampilkan {{ $bridges->firstItem() }} - {{ $bridges->lastItem() }} dari
                                {{ $bridges->total() }} data</div>
                            <div>{{ $bridges->onEachSide(1)->links('pagination::bootstrap-5') }}</div>
                        </div>
                    </div>

                    <!-- GRAFIK & STATISTIK -->
                    <div>
                        <div class="card card-soft mb-3">
                            <div class="card-header"><i class="fa-solid fa-chart-column me-2"></i> Grafik Kondisi</div>
                            <div class="card-body"><canvas id="condChart" height="260"></canvas></div>
                        </div>
                        <div class="stats-box">
                            <div class="stats-header"><i class="fa-solid fa-database me-2"></i> Data Statistik Jembatan
                            </div>
                            <div class="stats-body">
                                <div class="stat-item">
                                    <div><span class="dot" style="background:green;"></span>Baik</div><span
                                        id="statBaik">0</span>
                                </div>
                                <div class="stat-item">
                                    <div><span class="dot" style="background:blue;"></span>Sedang</div><span
                                        id="statSedang">0</span>
                                </div>
                                <div class="stat-item">
                                    <div><span class="dot" style="background:yellow;"></span>Rusak Ringan</div><span
                                        id="statRingan">0</span>
                                </div>
                                <div class="stat-item">
                                    <div><span class="dot" style="background:red;"></span>Rusak Berat</div><span
                                        id="statBerat">0</span>
                                </div>
                                <div class="stat-item fw-bold border-0">
                                    <div><i class="fa-solid fa-layer-group me-2"></i>Total Jembatan</div><span
                                        id="statTotal">0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer>© {{ date('Y') }} Dinas PUPR Kabupaten Tanggamus — Sistem Informasi Jembatan (SIJEMBAT)</footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        const map = L.map('map', {
            fullscreenControl: true
        }).setView([-5.4980, 104.5093], 9);
        const osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18
        }).addTo(map);
        const sat = L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        });
        L.control.layers({
            "🌍 Peta": osm,
            "🛰️ Satelit": sat
        }).addTo(map);

        function icon(c) {
            return L.icon({
                iconUrl: `https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-${c}.png`,
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.3/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });
        }
        const iconSet = {
            "Baik": icon('green'),
            "Sedang": icon('blue'),
            "Rusak Ringan": icon('yellow'),
            "Rusak Berat": icon('red'),
            "default": icon('white')
        };
        const bridges = @json($allBridges);
        const markers = [];
        let cB = 0,
            cS = 0,
            cR = 0,
            cRB = 0;

        bridges.forEach(b => {
            const lat = parseFloat(b.lat),
                lng = parseFloat(b.lng);
            if (!isNaN(lat) && !isNaN(lng)) {
                if (b.kondisi === 'Baik') cB++;
                else if (b.kondisi === 'Sedang') cS++;
                else if (b.kondisi === 'Rusak Ringan') cR++;
                else if (b.kondisi === 'Rusak Berat') cRB++;
                const m = L.marker([lat, lng], {
                    icon: iconSet[b.kondisi] || iconSet.default
                }).bindPopup(`<b>${b.nama}</b><br>${b.kecamatan}<br><i>${b.kondisi}</i>`).addTo(map);
                markers.push(m);
            }
        });
        if (markers.length) map.fitBounds(L.featureGroup(markers).getBounds().pad(0.18));

        new Chart(document.getElementById('condChart'), {
            type: 'bar',
            data: {
                labels: ['Baik', 'Sedang', 'Rusak Ringan', 'Rusak Berat'],
                datasets: [{
                    data: [cB, cS, cR, cRB],
                    backgroundColor: ['green', 'blue', 'yellow', 'red']
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
        const total = cB + cS + cR + cRB;
        $('#statBaik').text(cB);
        $('#statSedang').text(cS);
        $('#statRingan').text(cR);
        $('#statBerat').text(cRB);
        $('#statTotal').text(total);
        $('#search').on('keyup', function() {
            const v = $(this).val().toLowerCase();
            $('#bridgeTableBody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(v) > -1);
            });
        });
    </script>
</body>

</html>

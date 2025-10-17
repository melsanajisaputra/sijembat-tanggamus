<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Laporan Data Jembatan - Dinas PUPR Tanggamus</title>
  <style>
    body { font-family: sans-serif; font-size: 12px; }
    h2 { text-align: center; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th { border: 1px solid #000000; padding: 5px; text-align: center; }
    td { border: 1px solid #000000; padding: 5px; text-align: left; }
    th { background-color: #ddd; }
    td { white-space: nowrap; }
  </style>
</head>
<body>
  <h2>LAPORAN DATA JEMBATAN<br>Dinas PUPR Kabupaten Tanggamus</h2>
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Kode</th>
        <th>Nama</th>
        <th>Kecamatan</th>
        <th>Kondisi</th>
        <th>Lokasi</th>
        <th>Koordinat</th>
        <th>Panjang (m)</th>
        <th>Lebar (m)</th>
        <th>Tahun</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($bridges as $b)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $b->kode }}</td>
        <td>{{ $b->nama }}</td>
        <td>{{ $b->kecamatan }}</td>
        <td>{{ $b->kondisi }}</td>
        <td>{{ $b->lokasi }}</td>
        <td>{{$b->lat}}, {{$b->lng}}</td>
        <td>{{ $b->panjang }}</td>
        <td>{{ $b->lebar }}</td>
        <td>{{ $b->tahun }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <p style="text-align:right; margin-top:30px;">
    <i>Tanggamus, {{ date('d F Y') }}</i><br>
    <b>Dinas PUPR Kabupaten Tanggamus</b>
  </p>
</body>
</html>

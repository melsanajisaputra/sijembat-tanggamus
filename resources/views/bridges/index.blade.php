@extends('layouts.admin')

@section('content')
<style>
  body {
    background-color: #f4f6fa;
    font-family: 'Poppins', sans-serif;
  }

  /* === HEADER === */
  .page-header {
    background: linear-gradient(90deg, #0052D4, #4364F7, #6FB1FC);
    color: white;
    border-radius: 14px;
    padding: 20px 25px;
    margin-bottom: 25px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  }

  /* === CARD === */
  .card {
    border: none;
    border-radius: 14px;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
  }

  .btn-add {
    border-radius: 10px;
    font-weight: 600;
  }

  .table thead th {
    background-color: #007bff;
    color: white;
    text-align: center;
  }

  .table tbody td {
    vertical-align: middle;
  }

  /* === Kontrol atas tabel (search & tambah data) === */
  .table-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
    flex-wrap: wrap;
  }

  .table-controls .right-controls {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  /* === Pagination dan info sejajar === */
  .dataTables_wrapper .bottom-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 18px;
    flex-wrap: wrap;
  }

  .dataTables_info {
    color: #555;
    font-weight: 500;
    margin: 0 !important;
  }

  .dataTables_paginate {
    display: flex;
    justify-content: flex-end;
  }

  .dataTables_paginate .pagination {
    display: inline-flex;
    gap: 6px;
    margin: 0;
  }

  .dataTables_paginate .paginate_button {
    background: white !important;
    border: 1px solid #dee2e6 !important;
    color: #007bff !important;
    border-radius: 8px;
    padding: 6px 12px !important;
    font-weight: 500;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
  }

  .dataTables_paginate .paginate_button:hover {
    background: #007bff !important;
    color: white !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(0,0,0,0.15);
  }

  .dataTables_paginate .paginate_button.current {
    background: linear-gradient(90deg, #0052D4, #4364F7) !important;
    color: white !important;
    font-weight: 600;
    box-shadow: 0 3px 8px rgba(0,0,0,0.1);
  }

  /* === Dropdown dan Search === */
  .dataTables_length label {
    font-weight: 600;
    color: #333;
  }

  .dataTables_wrapper .dataTables_length select {
    border-radius: 8px;
    border: 1px solid #ddd;
    padding: 6px 10px;
  }

  .dataTables_wrapper .dataTables_filter input {
    border-radius: 10px;
    padding: 8px 12px;
    border: 1px solid #ddd;
  }

  /* === Responsif === */
  @media (max-width: 768px) {
    .bottom-controls {
      flex-direction: column;
      gap: 8px;
      align-items: center;
    }
  }
</style>

<div class="container-fluid px-3">
  <!-- HEADER -->
  <div class="page-header d-flex justify-content-between align-items-center">
    <div>
      <h4><i class="fas fa-database"></i> Data Jembatan</h4>
      <p class="mb-0">Manajemen data jembatan Dinas PUPR Kabupaten Tanggamus</p>
    </div>
  </div>

  <!-- PESAN SUKSES -->
  @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <!-- CARD DATA -->
  <div class="card p-4">
    <div class="table-controls">
      <div id="tableLength"></div>
      <div class="right-controls">
        <input type="text" id="customSearch" class="form-control" placeholder="🔍 Cari jembatan..." style="width: 250px;">
        <a href="{{ route('bridges.create') }}" class="btn btn-primary btn-add">
          <i class="fas fa-plus"></i> Tambah Data
        </a>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered table-striped" id="bridgeTable">
        <thead>
          <tr>
            <th>Kode</th>
            <th>Nama</th>
            <th>Kecamatan</th>
            <th>Kondisi</th>
            <th>Deskripsi</th>
            <th width="120">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($bridges as $b)
            <tr>
              <td>{{ $b->kode }}</td>
              <td>{{ $b->nama }}</td>
              <td>{{ $b->kecamatan }}</td>
              <td>{{ $b->kondisi }}</td>
              <td>{{ Str::limit($b->deskripsi, 60) }}</td>
              <td class="text-center">
                <a href="{{ route('bridges.edit', $b->id) }}" class="btn btn-sm btn-warning">
                  <i class="fas fa-edit"></i>
                </a>
                <form action="{{ route('bridges.destroy', $b->id) }}" method="POST" style="display:inline">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <!-- Kontrol bawah: info + pagination sejajar -->
    <div class="bottom-controls mt-3">
      <div id="tableInfo"></div>
      <div id="tablePagination"></div>
    </div>
  </div>
</div>

<!-- DATATABLES -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">

<script>
  $(document).ready(function() {
    const table = $('#bridgeTable').DataTable({
      language: {
        lengthMenu: "Tampilkan _MENU_ data per halaman",
        zeroRecords: "Tidak ada data ditemukan",
        info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
        search: "",
        paginate: { next: "›", previous: "‹" }
      },
      dom: '<"top">rt<"bottom"ip><"clear">',
      pageLength: 10
    });

    // Custom search
    $('#customSearch').on('keyup', function() {
      table.search(this.value).draw();
    });

    // Pindahkan elemen DataTables agar lebih rapi
    $('#tableLength').html($('.dataTables_length'));
    $('#tableInfo').html($('.dataTables_info'));
    $('#tablePagination').html($('.dataTables_paginate'));
  });
</script>
@endsection

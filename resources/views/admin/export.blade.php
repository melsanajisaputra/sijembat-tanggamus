@extends('layouts.admin')

@section('content')
<style>
  .page-header {
    background: linear-gradient(90deg, #0052D4, #4364F7, #6FB1FC);
    color: white;
    border-radius: 14px;
    padding: 20px 25px;
    margin-bottom: 25px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  }

  .export-card {
    border-radius: 14px;
    border: none;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
    text-align: center;
    padding: 30px;
  }

  .btn-export {
    border-radius: 12px;
    font-weight: 600;
    padding: 15px 25px;
    margin: 15px;
    transition: all 0.3s ease;
  }

  .btn-export i {
    font-size: 1.4rem;
  }

  .btn-excel {
    background: linear-gradient(90deg, #00b03e, #96c93d);
    color: white;
  }

  .btn-pdf {
    background: linear-gradient(90deg, #ff416c, #ff4b2b);
    color: white;
  }

  .btn-export:hover {
    transform: scale(1.05);
    opacity: 0.9;
  }
</style>

<div class="container-fluid px-3">
  <div class="page-header d-flex justify-content-between align-items-center">
    <div>
      <h4><i class="fas fa-file-export me-2"></i> Eksport Data Jembatan</h4>
      <p class="mb-0">Unduh seluruh data jembatan dalam format Excel atau PDF.</p>
    </div>
  </div>

  <div class="card export-card">
    <i class="fas fa-download fa-3x text-primary mb-3"></i>
    <h5 class="fw-bold">Pilih format file yang ingin diunduh:</h5>

    <div class="d-flex justify-content-center flex-wrap mt-4">
      <a href="{{ route('bridges.export.excel') }}" class="btn btn-export btn-excel">
        <i class="fas fa-file-excel me-2"></i> Unduh Excel
      </a>

      <a href="{{ route('bridges.export.pdf') }}" class="btn btn-export btn-pdf">
        <i class="fas fa-file-pdf me-2"></i> Unduh PDF
      </a>
    </div>

    <p class="text-muted mt-4">Pastikan data sudah lengkap dan valid sebelum mengekspor.</p>
  </div>
</div>
@endsection

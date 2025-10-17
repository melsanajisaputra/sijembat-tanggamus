@extends('layouts.admin')

@section('content')
<style>
  body {
    background-color: #f4f6fa;
    font-family: 'Poppins', sans-serif;
  }

  /* Header */
  .page-header {
    background: linear-gradient(90deg, #007bff, #00a2ff);
    color: white;
    border-radius: 14px;
    padding: 20px 25px;
    margin-bottom: 25px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  }

  .page-header h4 {
    font-weight: 700;
  }

  /* Card */
  .card {
    border: none;
    border-radius: 14px;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
  }

  .card-header {
    background: linear-gradient(90deg, #007bff, #00a2ff);
    color: white;
    font-weight: 600;
    border-top-left-radius: 14px;
    border-top-right-radius: 14px;
  }

  /* Form */
  label {
    font-weight: 600;
    color: #333;
  }

  .form-control {
    border-radius: 10px;
    padding: 10px;
    border: 1px solid #ced4da;
  }

  .btn-save {
    background: linear-gradient(90deg, #007bff, #00a2ff);
    color: white;
    border: none;
    font-weight: 600;
    border-radius: 10px;
    padding: 10px 20px;
    transition: all 0.3s ease;
  }

  .btn-save:hover {
    background: linear-gradient(90deg, #0069d9, #0091e6);
    transform: translateY(-2px);
  }

  .btn-danger {
    border-radius: 10px;
    font-weight: 600;
  }

  .alert-success {
    border-radius: 10px;
  }

  /* Responsif */
  @media (max-width: 768px) {
    .card-body {
      padding: 1rem;
    }
  }
</style>

<div class="container-fluid px-3">
  <!-- Header -->
  <div class="page-header d-flex justify-content-between align-items-center">
    <div>
      <h4><i class="fas fa-user-circle me-2"></i> Profil Admin</h4>
      <p class="mb-0">Kelola informasi akun dan keamanan Anda</p>
    </div>
  </div>

  <!-- Notifikasi -->
  @if (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="fas fa-check-circle me-2"></i> {{ session('status') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <!-- Form Profil -->
  <div class="card mb-4">
    <div class="card-header">
      <i class="fas fa-user-edit me-2"></i> Informasi Profil
    </div>
    <div class="card-body">
      <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="name">Nama Lengkap</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required autofocus>
          </div>

          <div class="col-md-6 mb-3">
            <label for="email">Alamat Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
          </div>

          <div class="col-md-6 mb-3">
            <label for="phone">Nomor Telepon</label>
            <input type="text" name="phone" id="phone" class="form-control" placeholder="Opsional">
          </div>

          <div class="col-md-6 mb-3">
            <label for="jabatan">Jabatan</label>
            <input type="text" name="jabatan" id="jabatan" class="form-control" placeholder="Misal: Kepala Seksi Infrastruktur">
          </div>
        </div>

        <div class="mt-3 d-flex justify-content-end">
          <button type="submit" class="btn btn-save"><i class="fas fa-save me-1"></i> Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Form Ganti Password -->
  <div class="card">
    <div class="card-header bg-danger">
      <i class="fas fa-lock me-2"></i> Ganti Password
    </div>
    <div class="card-body">
      <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="row">
          <div class="col-md-4 mb-3">
            <label for="current_password">Password Saat Ini</label>
            <input type="password" name="current_password" id="current_password" class="form-control" required>
          </div>

          <div class="col-md-4 mb-3">
            <label for="password">Password Baru</label>
            <input type="password" name="password" id="password" class="form-control" required>
          </div>

          <div class="col-md-4 mb-3">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
          </div>
        </div>

        <div class="mt-3 d-flex justify-content-end">
          <button type="submit" class="btn btn-danger">
            <i class="fas fa-key me-1"></i> Ubah Password
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Bootstrap Script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection

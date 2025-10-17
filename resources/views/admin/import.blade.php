@extends('layouts.admin')

@section('content')
<style>
.page-header {
    background: linear-gradient(90deg, #0052D4, #4364F7, #6FB1FC);
    color: white;
    border-radius: 14px;
    padding: 20px 25px;
    margin-bottom: 25px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
.card { border: none; border-radius: 14px; box-shadow: 0 3px 8px rgba(0,0,0,0.08); }
.btn-upload { border-radius: 10px; font-weight: 600; }
table th { background-color: #007bff; color: white; text-align: center; }
</style>

<div class="container-fluid px-3">
  <div class="page-header d-flex justify-content-between align-items-center">
    <div>
      <h4><i class="fas fa-file-import me-2"></i> Import Data Jembatan</h4>
      <p class="mb-0">Unggah file Excel untuk menambahkan data jembatan secara massal.</p>
    </div>
  </div>

  <div class="card p-4">
    <form id="importForm" enctype="multipart/form-data">
      @csrf
      <div class="row align-items-end">
        <div class="col-md-8 mb-3">
          <label class="form-label fw-bold">Pilih File Excel</label>
          <input type="file" name="file" id="fileInput" class="form-control" accept=".xlsx,.xls,.csv" required>
        </div>
        <div class="col-md-4 mb-3">
          <button type="button" id="previewBtn" class="btn btn-primary btn-upload w-100">
            <i class="fas fa-eye"></i> Preview Data
          </button>
        </div>
      </div>
    </form>
  </div>

  <div class="card mt-4" id="previewCard" style="display:none;">
    <div class="card-header bg-info text-white">
      <i class="fas fa-table me-2"></i> Preview Data Sebelum Import
    </div>
    <div class="card-body table-responsive">
      <table class="table table-bordered" id="previewTable">
        <thead>
          <tr>
            <th>Kode</th>
            <th>Nama</th>
            <th>Kecamatan</th>
            <th>Kondisi</th>
            <th>Latitude</th>
            <th>Longitude</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
      <button class="btn btn-success mt-3" id="importBtn">
        <i class="fas fa-check"></i> Import Sekarang
      </button>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
const fileInput = document.getElementById('fileInput');
const previewBtn = document.getElementById('previewBtn');
const previewCard = document.getElementById('previewCard');
const previewTable = document.querySelector('#previewTable tbody');
const importBtn = document.getElementById('importBtn');

previewBtn.addEventListener('click', () => {
  const file = fileInput.files[0];
  if (!file) return alert('Pilih file Excel terlebih dahulu!');
  const reader = new FileReader();
  reader.onload = function(e) {
    const data = new Uint8Array(e.target.result);
    const workbook = XLSX.read(data, { type: 'array' });
    const rows = XLSX.utils.sheet_to_json(workbook.Sheets[workbook.SheetNames[0]], { header: 1 });
    previewTable.innerHTML = '';
    rows.slice(1).forEach(r => {
      if (r.length > 0) {
        previewTable.innerHTML += `<tr>
          <td>${r[0] || ''}</td><td>${r[1] || ''}</td><td>${r[2] || ''}</td>
          <td>${r[3] || ''}</td><td>${r[4] || ''}</td><td>${r[5] || ''}</td>
        </tr>`;
      }
    });
    previewCard.style.display = 'block';
  };
  reader.readAsArrayBuffer(file);
});

importBtn.addEventListener('click', () => {
  const formData = new FormData();
  formData.append('file', fileInput.files[0]);

  fetch('{{ route('bridges.import') }}', {
    method: 'POST',
    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    alert(data.message);
    if (data.success) location.reload();
  })
  .catch(async err => {
    console.error('Server error:', err);
    alert('❌ Gagal mengimpor data. Periksa format file Excel.');
  });
});
</script>
@endsection

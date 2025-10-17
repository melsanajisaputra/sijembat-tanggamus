<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - SIJEMBAT</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(120deg, #0052D4, #4364F7, #6FB1FC);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
    }

    .login-card {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 16px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
      padding: 40px 35px;
      width: 100%;
      max-width: 420px;
      text-align: center;
      animation: fadeIn 0.8s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .login-card img {
      width: 90px;
      height: auto;
      margin-bottom: 10px;
      filter: drop-shadow(0 2px 6px rgba(0,0,0,0.2));
      user-select: none;
      -webkit-user-drag: none;
    }

    .login-card h3 {
      font-weight: 700;
      color: #0052D4;
      margin-bottom: 5px;
    }

    .login-card p {
      font-size: 0.9rem;
      color: #555;
      margin-bottom: 25px;
    }

    .form-control {
      border-radius: 10px;
      border: 1px solid #ccc;
      padding: 10px 14px;
      font-size: 0.95rem;
    }

    .form-control:focus {
      box-shadow: 0 0 8px rgba(0,82,212,0.3);
      border-color: #0052D4;
    }

    .btn-login {
      background: linear-gradient(90deg, #0052D4, #4364F7);
      border: none;
      color: #fff;
      border-radius: 10px;
      font-weight: 600;
      padding: 10px;
      transition: 0.3s;
      width: 100%;
    }

    .btn-login:hover {
      background: linear-gradient(90deg, #0042b0, #3353d4);
      transform: translateY(-2px);
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }

    .footer-text {
      color: #fff;
      position: absolute;
      bottom: 10px;
      width: 100%;
      text-align: center;
      font-size: 0.9rem;
      opacity: 0.8;
    }
  </style>
</head>
<body>

  <div class="login-card">
    <img src="{{ asset('image/logo-tanggamus.png') }}" alt="Logo Tanggamus">
    <h3>SIJEMBAT</h3>
    <p>Sistem Informasi Jembatan Kabupaten Tanggamus</p>

    <form method="POST" action="{{ route('login') }}">
      @csrf
      <div class="mb-3 text-start">
        <label for="email" class="form-label fw-semibold">Email</label>
        <input type="email" id="email" name="email" class="form-control" placeholder="Masukkan email" required autofocus>
      </div>

      <div class="mb-3 text-start">
        <label for="password" class="form-label fw-semibold">Password</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password" required>
      </div>

      <button type="submit" class="btn-login mt-2">
        <i class="fas fa-sign-in-alt me-2"></i> Masuk
      </button>

      @if (Route::has('password.request'))
        <div class="mt-3">
          <a href="{{ route('password.request') }}" class="text-decoration-none" style="color:#0052D4; font-weight:500;">
            Lupa Password?
          </a>
        </div>
      @endif
    </form>
  </div>

  <div class="footer-text">
    © {{ date('Y') }} Dinas PUPR Kabupaten Tanggamus — SIJEMBAT
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

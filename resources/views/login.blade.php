<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Portal Kurasi Akademik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fe; font-family: 'Segoe UI', sans-serif; }
        .login-card { border-radius: 20px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
        .btn-primary { background-color: #3b71ca; border: none; padding: 12px; font-weight: 600; }
        .security-box { background-color: #f3f2ff; border-radius: 12px; }
        .form-control { padding: 12px; border-radius: 8px; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card p-5 login-card">
                <h2 class="fw-bold mb-2">Selamat Datang.</h2>
                <p class="text-muted mb-4">Masuk ke portal kurasi akademik Anda.</p>

                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">ALAMAT EMAIL</label>
                        <input type="email" name="email" class="form-control" placeholder="nama@kampus.ac.id">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">KATA SANDI</label>
                        <input type="password" name="password" class="form-control" placeholder="••••••••">
                    </div>
                    <div class="d-flex justify-content-between mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="ingat">
                            <label class="form-check-label text-muted" for="ingat">Ingat Saya</label>
                        </div>
                        <a href="#" class="text-decoration-none text-primary fw-bold">Lupa Password?</a>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Masuk Sekarang</button>
                </form>

                <div class="text-center my-4 text-muted small">ATAU LANJUT DENGAN</div>
                
                <button class="btn btn-outline-secondary w-100">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" width="20" class="me-2">
                    Akun Google Kampus
                </button>

                <p class="text-center mt-4 text-muted">
                    Belum punya akun? <a href="#" class="text-decoration-none fw-bold">Gabung Sekarang</a>
                </p>
            </div>

            <div class="security-box p-3 mt-4 d-flex align-items-center">
                <div class="me-3 fs-3 text-primary">🛡️</div>
                <div>
                    <h6 class="fw-bold mb-0">KEAMANAN KAMPUS</h6>
                    <small class="text-muted">Enkripsi tingkat editorial melindungi transaksi akademik dan portofolio kreatif Anda setiap hari.</small>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
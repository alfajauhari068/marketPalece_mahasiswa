<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - The Scholarly Editorial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fe; font-family: 'Segoe UI', sans-serif; }
        .card { border-radius: 20px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
        .path-btn { border: 2px solid #e9ecef; border-radius: 12px; padding: 20px; cursor: pointer; transition: 0.3s; }
        .path-btn.active { border-color: #0d6efd; background-color: #f0f7ff; }
        .btn-primary { background: linear-gradient(90deg, #3b71ca, #4a86e8); border: none; padding: 14px; font-weight: 600; }
        .form-control { padding: 12px; border-radius: 8px; border: 1px solid #dee2e6; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card p-5">
                <h3 class="fw-bold text-center">The Scholarly Editorial</h3>
                <p class="text-muted text-center mb-4">Join the premium marketplace for campus talents.</p>

                <label class="form-label small fw-bold text-muted mb-3">CHOOSE YOUR PATH</label>
                <div class="row mb-4 g-3">
                    <div class="col-6">
                        <div class="path-btn active text-center">
                            <div class="mb-2">🎓</div>
                            <div class="fw-bold">Mahasiswa</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="path-btn text-center">
                            <div class="mb-2">💼</div>
                            <div class="fw-bold">Buyer</div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('register.post') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">NAMA LENGKAP</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter your full name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">EMAIL KAMPUS</label>
                        <input type="email" name="email" class="form-control" placeholder="example@university.ac.id">
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label small fw-bold text-muted">PASSWORD</label>
                            <input type="password" name="password" class="form-control" placeholder="••••••••">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label small fw-bold text-muted">KONFIRMASI</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-3">Daftar Sekarang</button>
                </form>

                <p class="text-center mt-4 text-muted">
                    Sudah punya akun? <a href="/" class="text-decoration-none fw-bold">Masuk di sini</a>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.path-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.path-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });
</script>
</body>
</html>
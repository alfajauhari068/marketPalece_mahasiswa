<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar | Marketplace Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            color-scheme: light;
            --bg: #F8FAFC;
            --surface: #FFFFFF;
            --text: #0F172A;
            --muted: #64748B;
            --accent: #2563EB;
            --accent-soft: rgba(37, 99, 235, 0.08);
            --border: rgba(15, 23, 42, 0.08);
            --shadow-soft: 0 18px 50px rgba(15, 23, 42, 0.08);
            --radius: 16px;
        }

        @media (prefers-color-scheme: dark) {
            :root {
                --bg: #0F172A;
                --surface: #111827;
                --text: #F8FAFC;
                --muted: #94A3B8;
                --accent: #2563EB;
                --accent-soft: rgba(37, 99, 235, 0.16);
                --border: rgba(148, 163, 184, 0.16);
                --shadow-soft: 0 18px 50px rgba(0, 0, 0, 0.30);
            }
        }

        * {
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            min-height: 100%;
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        body {
            display: grid;
            place-items: center;
            padding: 2rem;
        }

        .page-shell {
            width: min(1180px, 100%);
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
            gap: 2rem;
        }

        @media (max-width: 960px) {
            .page-shell {
                grid-template-columns: 1fr;
            }
        }

        .panel {
            position: relative;
            border-radius: var(--radius);
            border: 1px solid var(--border);
            background: var(--surface);
            box-shadow: var(--shadow-soft);
            padding: 2.5rem;
            overflow: hidden;
        }

        @media (max-width: 768px) {
            .panel {
                padding: 1.75rem;
            }
        }

        .dark-panel {
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.95), rgba(37, 99, 235, 0.18));
            color: #FFFFFF;
            border-color: rgba(255, 255, 255, 0.12);
            box-shadow: 0 18px 50px rgba(15, 23, 42, 0.24);
        }

        .brand-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: 999px;
            font-size: 0.9rem;
            font-weight: 700;
            background: rgba(255, 255, 255, 0.12);
            color: #DDE9FF;
        }

        .eyebrow {
            margin: 1.2rem 0 0.8rem;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.24em;
            text-transform: uppercase;
            color: #93C5FD;
        }

        .headline {
            margin: 0;
            font-size: clamp(2.2rem, 3.5vw, 3.4rem);
            line-height: 1.02;
            font-weight: 800;
        }

        .lead-text {
            margin: 1.25rem 0 0;
            max-width: 34rem;
            color: rgba(255, 255, 255, 0.78);
            line-height: 1.75;
            font-size: 1rem;
        }

        .hero-visual {
            display: grid;
            gap: 1rem;
            margin-top: 2rem;
        }

        .hero-card,
        .hero-illustration {
            border-radius: var(--radius);
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.14);
            box-shadow: 0 18px 50px rgba(15, 23, 42, 0.18);
            padding: 1.5rem;
        }

        .hero-card h2 {
            margin: 0;
            font-size: 0.98rem;
            font-weight: 800;
            color: #DDE9FF;
        }

        .hero-card p {
            margin: 1rem 0 0;
            color: rgba(255,255,255,0.72);
            line-height: 1.7;
            font-size: 0.95rem;
        }

        .hero-illustration {
            min-height: 220px;
            display: grid;
            place-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero-illustration svg {
            width: 100%;
            max-width: 260px;
            height: auto;
        }

        .auth-panel {
            display: flex;
            flex-direction: column;
            gap: 1.6rem;
        }

        .auth-panel h2 {
            margin: 0;
            font-size: clamp(2.1rem, 3vw, 2.6rem);
            font-weight: 800;
        }

        .auth-panel p {
            margin: 0;
            color: var(--muted);
            line-height: 1.8;
        }

        .form-card {
            display: grid;
            gap: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.55rem;
            color: var(--text);
            font-size: 0.88rem;
            font-weight: 700;
            letter-spacing: 0.03em;
        }

        .form-control {
            width: 100%;
            min-height: 54px;
            border-radius: 16px;
            border: 1px solid var(--border);
            background: var(--surface);
            padding: 1rem 1.1rem;
            color: var(--text);
            transition: border-color 0.22s ease, box-shadow 0.22s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: rgba(37, 99, 235, 0.55);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }

        .form-control::placeholder {
            color: rgba(71,85,105,0.65);
        }

        .input-group-text {
            border-radius: 0 16px 16px 0;
            border: 1px solid var(--border);
            border-left: 0;
            background: var(--surface);
            color: var(--accent);
            cursor: pointer;
            min-width: 5rem;
            justify-content: center;
        }

        .role-group {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
        }

        @media (max-width: 640px) {
            .role-group {
                grid-template-columns: 1fr;
            }
        }

        .role-card {
            border-radius: 16px;
            border: 1px solid var(--border);
            background: var(--surface);
            padding: 1rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.85rem;
            cursor: pointer;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .role-card input {
            accent-color: var(--accent);
        }

        .role-card:hover,
        .role-card:focus-within {
            border-color: rgba(37, 99, 235, 0.35);
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.08);
        }

        .role-card label {
            margin: 0;
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text);
        }

        .form-check-label {
            margin-left: 0.55rem;
            color: var(--text);
            font-size: 0.95rem;
        }

        .form-actions {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 1rem;
            align-items: center;
        }

        .btn-submit {
            border-radius: var(--radius);
            padding: 1rem 1.15rem;
            border: none;
            font-weight: 700;
            color: #ffffff;
            background: var(--accent);
            box-shadow: var(--shadow-soft);
            transition: transform 0.18s ease, box-shadow 0.18s ease, opacity 0.18s ease;
        }

        .btn-submit:hover:not(:disabled),
        .btn-submit:focus-visible {
            transform: translateY(-1px);
            background: #1D4ED8;
        }

        .btn-submit:disabled {
            opacity: 0.72;
            cursor: not-allowed;
        }

        .login-cta {
            color: var(--muted);
            font-size: 0.95rem;
            margin-top: 0.5rem;
        }

        .login-cta a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 700;
        }

        .status-alert {
            border-radius: 16px;
            padding: 1rem 1rem;
            background: rgba(248, 113, 113, 0.13);
            border: 1px solid rgba(248, 113, 113, 0.22);
            color: #B91C1C;
            font-size: 0.95rem;
        }

        .field-error {
            margin-top: 0.4rem;
            color: #DC2626;
            font-size: 0.88rem;
        }
    </style>
</head>
<body>
    <main class="page-shell" aria-label="Register page">
        <section class="panel dark-panel" aria-labelledby="register-welcome-heading">
            <div class="brand-pill">Marketplace Mahasiswa</div>
            <p class="eyebrow">Mulai perjalanan Anda</p>
            <h1 id="register-welcome-heading" class="headline">Mulai perjalanan freelance kampus Anda</h1>
            <p class="lead-text">Gabung sebagai klien atau freelancer untuk membangun reputasi, menawarkan jasa, dan memesan pekerjaan dengan pengalaman yang modern dan profesional.</p>

            <div class="hero-visual" aria-hidden="true">
                <div class="hero-card">
                    <h2>Marketplace internal kampus</h2>
                    <p>Percepat kolaborasi di lingkungan kampus dengan sistem order yang jelas, review terpercaya, dan profil profesional.</p>
                </div>
                <div class="hero-illustration">
                    <svg viewBox="0 0 360 260" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <rect x="22" y="42" width="316" height="148" rx="22" fill="rgba(255,255,255,0.1)" stroke="rgba(255,255,255,0.2)" stroke-width="2"/>
                        <path d="M76 86h208" stroke="#60A5FA" stroke-width="8" stroke-linecap="round" opacity="0.9"/>
                        <path d="M76 126h152" stroke="#60A5FA" stroke-width="8" stroke-linecap="round" opacity="0.72"/>
                        <path d="M76 166h106" stroke="#60A5FA" stroke-width="8" stroke-linecap="round" opacity="0.55"/>
                        <circle cx="92" cy="210" r="26" fill="rgba(255,255,255,0.16)"/>
                        <circle cx="168" cy="214" r="20" fill="rgba(255,255,255,0.18)"/>
                        <circle cx="248" cy="204" r="16" fill="rgba(255,255,255,0.22)"/>
                    </svg>
                </div>
            </div>
        </section>

        <section class="panel auth-panel" aria-labelledby="register-heading">
            <div>
                <h2 id="register-heading">Daftar</h2>
                <p>Isi data Anda untuk membuat akun marketplace kampus baru dan mulai menawarkan atau memesan jasa.</p>
            </div>

            @if(session('status'))
                <div class="status-alert" role="alert">{{ session('status') }}</div>
            @endif

            <form action="{{ route('register.post') }}" method="POST" novalidate>
                @csrf
                <div class="form-card">
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input id="name" name="name" type="text" autocomplete="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Nama lengkap Anda" required>
                        @error('name')<div class="field-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" name="email" type="email" autocomplete="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="nama@kampus.ac.id" required>
                        @error('email')<div class="field-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Kata sandi</label>
                        <div class="input-group">
                            <input id="password" name="password" type="password" autocomplete="new-password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" required>
                            <button class="input-group-text" type="button" id="togglePassword" aria-label="Tampilkan kata sandi">Tampilkan</button>
                        </div>
                        @error('password')<div class="field-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi kata sandi</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" class="form-control" placeholder="••••••••" required>
                    </div>
                    <div class="form-group">
                        <label class="d-block mb-2">Pilih peran</label>
                        <div class="role-group" role="radiogroup" aria-labelledby="role-group-label">
                            <label class="role-card">
                                <input type="radio" name="role" value="client" {{ old('role') !== 'seller' ? 'checked' : '' }}>
                                <span>Client</span>
                            </label>
                            <label class="role-card">
                                <input type="radio" name="role" value="seller" {{ old('role') === 'seller' ? 'checked' : '' }}>
                                <span>Seller/Freelancer</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="terms" id="terms" {{ old('terms') ? 'checked' : '' }} required>
                        <label class="form-check-label" for="terms">Saya menyetujui Syarat & Ketentuan</label>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit" id="submitBtn">
                        <span class="submit-text">Daftar</span>
                        <span class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

            <p class="login-cta">Sudah punya akun? <a href="/login">Login</a></p>
        </section>
    </main>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const form = document.querySelector('form');
        const submitBtn = document.getElementById('submitBtn');
        const spinner = submitBtn.querySelector('.spinner-border');

        togglePassword.addEventListener('click', () => {
            const show = passwordInput.type === 'password';
            passwordInput.type = show ? 'text' : 'password';
            togglePassword.textContent = show ? 'Sembunyikan' : 'Tampilkan';
        });

        form.addEventListener('submit', () => {
            submitBtn.disabled = true;
            spinner.classList.remove('d-none');
        });
    </script>
</body>
</html>

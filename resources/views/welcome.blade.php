<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BubblyWash Laundry</title>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --navy:      #3d5a80;
            --navy-deep: #2c4260;
            --blue-mid:  #7aafc9;
            --blue-soft: #b8d8ea;
            --blue-pale: #dceef7;
            --cream:     #f5f0eb;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            background: linear-gradient(145deg, var(--cream) 0%, var(--blue-pale) 50%, var(--blue-soft) 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 24px;
            position: relative;
            overflow: hidden;
        }

        /* Bubbles */
        .bubble {
            position: fixed;
            border-radius: 50%;
            background: rgba(184,216,234,0.3);
            border: 1.5px solid rgba(122,175,201,0.2);
            animation: float 6s ease-in-out infinite;
            pointer-events: none;
        }
        .bubble:nth-child(1) { width: 90px;  height: 90px;  top: 10%; left: 6%;   animation-delay: 0s;   animation-duration: 7s; }
        .bubble:nth-child(2) { width: 45px;  height: 45px;  top: 60%; left: 4%;   animation-delay: 1.5s; animation-duration: 5s; }
        .bubble:nth-child(3) { width: 65px;  height: 65px;  top: 20%; right: 5%;  animation-delay: 0.8s; animation-duration: 8s; }
        .bubble:nth-child(4) { width: 30px;  height: 30px;  top: 75%; right: 8%;  animation-delay: 2s;   animation-duration: 6s; }
        .bubble:nth-child(5) { width: 55px;  height: 55px;  bottom: 12%; left: 18%; animation-delay: 3s; animation-duration: 7s; }

        @keyframes float {
            0%, 100% { transform: translateY(0); opacity: 0.6; }
            50%       { transform: translateY(-16px); opacity: 1; }
        }

        /* Card */
        .card-wrap {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(184,216,234,0.6);
            border-radius: 28px;
            padding: 48px 44px;
            width: 100%;
            max-width: 420px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(61,90,128,0.12);
            position: relative;
            z-index: 2;
        }

        /* Logo */
        .logo-ring-wrap {
            position: relative;
            width: 100px;
            height: 100px;
            margin: 0 auto 20px;
        }

        .logo-ring {
            position: absolute;
            inset: 0;
            border-radius: 50%;
            border: 1.5px dashed rgba(122,175,201,0.4);
            animation: spin 20s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }

        .logo-ring-wrap img {
            position: relative;
            z-index: 1;
            width: 100px;
            height: 100px;
            object-fit: contain;
            animation: floatLogo 4s ease-in-out infinite;
        }

        @keyframes floatLogo {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-6px); }
        }

        /* Brand name */
        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 4px;
        }
        .brand-name span { color: var(--blue-mid); }

        .brand-tagline {
            font-size: 0.8rem;
            color: var(--blue-mid);
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 36px;
        }

        /* Divider */
        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, var(--blue-soft), transparent);
            margin-bottom: 32px;
        }

        /* Buttons */
        .btn-solid {
            display: block;
            width: 100%;
            background: var(--navy);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 14px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.95rem;
            font-weight: 500;
            text-decoration: none;
            transition: all .25s;
            margin-bottom: 12px;
            box-shadow: 0 4px 16px rgba(61,90,128,0.3);
        }
        .btn-solid:hover {
            background: var(--navy-deep);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(61,90,128,0.4);
        }

        .btn-ghost {
            display: block;
            width: 100%;
            background: transparent;
            color: var(--navy);
            border: 1.5px solid var(--blue-soft);
            border-radius: 50px;
            padding: 13px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.95rem;
            font-weight: 500;
            text-decoration: none;
            transition: all .25s;
        }
        .btn-ghost:hover {
            background: var(--blue-pale);
            border-color: var(--blue-mid);
            color: var(--navy);
        }

        .footer-text {
            margin-top: 28px;
            font-size: 0.75rem;
            color: #a0b4c4;
        }
    </style>
</head>

<body>

    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>

    <div class="card-wrap">

        <div class="logo-ring-wrap">
            <div class="logo-ring"></div>
            <img src="{{ asset('vendor/adminlte/dist/img/logo.png') }}" alt="BubblyWash Logo">
        </div>

        <div class="brand-name">Bubbly<span>Wash</span></div>
        <div class="brand-tagline">Clean · Fresh · Care</div>

        <div class="divider"></div>

        <a href="{{ route('register') }}" class="btn-solid">Daftar Sekarang</a>
        <a href="{{ route('login') }}" class="btn-ghost">Sudah punya akun? Masuk</a>

        <p class="footer-text">© 2025 BubblyWash Laundry</p>

    </div>

</body>
</html>
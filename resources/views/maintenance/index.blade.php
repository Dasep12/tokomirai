<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sedang Dalam Perbaikan — Tokomirai</title>
    <link rel="icon" href="{{ asset('assets/images/logo/tokomirai-logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.44.0/tabler-icons.min.css">
    <style>
        :root {
            --blue: #0453c4;
            --blue-d: #033a99;
            --blue-l: #e8f0fc;
            --blue-m: #1566d6;
            --green: #58f75a;
            --ink: #10182c;
            --muted: #5b6478;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 24px;
            color: var(--ink);
            background: radial-gradient(circle at 15% 20%, var(--blue-l) 0%, #fff 45%),
                radial-gradient(circle at 85% 80%, #eafcec 0%, #fff 50%);
            overflow-x: hidden;
        }

        .logo {
            height: 40px;
            margin-bottom: 40px;
        }

        .art {
            position: relative;
            width: 220px;
            height: 220px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 28px;
        }

        .art-ring {
            position: absolute;
            inset: 0;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--green) -60%, var(--blue) 65%);
            opacity: .12;
            animation: pulse 2.6s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(.92);
                opacity: .1;
            }

            50% {
                transform: scale(1.04);
                opacity: .2;
            }
        }

        .art-icon {
            position: relative;
            width: 110px;
            height: 110px;
            border-radius: 28px;
            background: linear-gradient(135deg, var(--blue-m), var(--blue-d));
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 18px 40px -10px rgba(4, 83, 196, .45);
            animation: float 3.2s ease-in-out infinite;
        }

        .art-icon i {
            font-size: 50px;
            color: #fff;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .badge {
            position: absolute;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 20px -6px rgba(16, 24, 44, .25);
        }

        .badge i {
            font-size: 20px;
        }

        .b1 {
            top: -4px;
            right: 6px;
            color: var(--green);
            animation: float 2.4s ease-in-out infinite .3s;
        }

        .b2 {
            bottom: 6px;
            left: -6px;
            color: var(--blue);
            animation: float 2.8s ease-in-out infinite .6s;
        }

        .b3 {
            bottom: -8px;
            right: 24px;
            color: #f5a623;
            animation: float 3s ease-in-out infinite .1s;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: .8rem;
            font-weight: 700;
            letter-spacing: .04em;
            text-transform: uppercase;
            color: var(--blue);
            background: var(--blue-l);
            padding: 6px 14px;
            border-radius: 999px;
            margin-bottom: 18px;
        }

        h1 {
            font-size: clamp(1.6rem, 4.5vw, 2.5rem);
            font-weight: 800;
            line-height: 1.25;
            max-width: 640px;
        }

        p.desc {
            margin-top: 14px;
            max-width: 480px;
            color: var(--muted);
            font-size: 1rem;
            line-height: 1.6;
        }

        .actions {
            margin-top: 32px;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            justify-content: center;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
            font-size: .92rem;
            padding: 13px 24px;
            border-radius: 12px;
            text-decoration: none;
            transition: transform .15s ease, box-shadow .15s ease;
        }

        .btn-primary {
            background: var(--blue);
            color: #fff;
            box-shadow: 0 10px 24px -8px rgba(4, 83, 196, .5);
        }

        .btn-outline {
            background: #fff;
            color: var(--ink);
            border: 1px solid #dfe4ee;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary:hover {
            box-shadow: 0 14px 28px -8px rgba(4, 83, 196, .6);
        }

        footer {
            margin-top: 56px;
            font-size: .82rem;
            color: var(--muted);
        }
    </style>
</head>

<body>
    <img class="logo" src="{{ asset('assets/images/logo/tokomirai-logo.png') }}" alt="Tokomirai">

    <div class="art">
        <div class="art-ring"></div>
        <div class="art-icon"><i class="ti ti-tool"></i></div>
        <div class="badge b1"><i class="ti ti-settings"></i></div>
        <div class="badge b2"><i class="ti ti-bolt"></i></div>
        <div class="badge b3"><i class="ti ti-hammer"></i></div>
    </div>

    <span class="eyebrow"><i class="ti ti-clock-hour-4"></i> Sedang Dalam Perbaikan</span>

    <h1>Kami sedang mempercantik toko kami untuk Anda</h1>
    <p class="desc">
        Halaman ini sedang dalam proses pengembangan. Tim kami bekerja keras agar
        Tokomirai bisa segera kembali melayani kebutuhan IT Anda dengan lebih baik.
        Terima kasih atas kesabarannya
    </p>

    <div class="actions">
        @if(!empty($global_settings['contact_marketing']->values))
        <a class="btn btn-primary" href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $global_settings['contact_marketing']->values) }}" target="_blank">
            <i class="ti ti-brand-whatsapp"></i> {{ $global_settings['contact_marketing']->values }}
        </a>
        @endif
        @if(!empty($global_settings['email_marketing']->values))
        <a class="btn btn-outline" href="mailto:{{ $global_settings['email_marketing']->values }}">
            <i class="ti ti-mail"></i> {{ $global_settings['email_marketing']->values }}
        </a>
        @endif
    </div>

    <footer>&copy; {{ date('Y') }} Tokomirai. All rights reserved.</footer>
</body>

</html>
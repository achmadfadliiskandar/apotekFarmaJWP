<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - JeWePE Farma</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Membuat halaman memenuhi layar dan memosisikan konten di tengah */
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <h3 class="text-center mb-4 fw-bold text-primary">JeWePE Farma</h3>
        <p class="text-center text-muted small mb-4">Silakan login untuk mengelola inventory obat</p>

        <form action="{{ url('authenticate') }}" method="POST">
            @csrf
             <div class="mb-3">
                <label for="email" class="form-label small fw-semibold">Alamat Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="nama@email.com" required autofocus>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label small fw-semibold">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary py-2">Login</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
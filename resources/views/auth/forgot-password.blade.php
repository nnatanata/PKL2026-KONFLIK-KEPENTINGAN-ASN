<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password - SIMAKK ASN</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box {
            background: #ffffff;
            width: 380px;
            padding: 32px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.12);
        }

        .login-header {
            text-align: center;
            margin-bottom: 24px;
        }

        .login-header h2 {
            margin: 0;
            font-size: 22px;
            color: #333;
            font-weight: 700;
        }

        .login-header p {
            margin-top: 6px;
            font-size: 13px;
            color: #777;
        }

        .form-group {
            margin-bottom: 16px;
        }

        label {
            font-size: 13px;
            color: #444;
            font-weight: 600;
        }

        input {
            width: 100%;
            padding: 10px 12px;
            margin-top: 6px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
            box-sizing: border-box;
        }

        input:focus {
            outline: none;
            border-color: #B11226;
            box-shadow: 0 0 0 1px rgba(177,18,38,0.15);
        }

        .error {
            font-size: 12px;
            color: #B11226;
            margin-top: 6px;
        }

        .success {
            font-size: 12px;
            color: green;
            margin-bottom: 10px;
            text-align: center;
        }

        .btn-login {
            width: 100%;
            background-color: #B11226;
            color: #ffffff;
            border: none;
            padding: 12px;
            border-radius: 6px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .btn-login:hover {
            background-color: #8B0000;
        }

        .login-footer {
            margin-top: 18px;
            text-align: center;
        }

        .login-footer a {
            font-size: 13px;
            color: #555;
            text-decoration: none;
        }

        .login-footer a:hover {
            color: #B11226;
            text-decoration: underline;
        }

        .copyright {
            margin-top: 20px;
            text-align: center;
            font-size: 11px;
            color: #aaa;
        }
    </style>
</head>
<body>

<div class="login-box">
    <div class="login-header">
        
    </div>

    @if (session('status'))
        <div class="success">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="error">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>

        <button type="submit" class="btn-login">
            Kirim Link Reset Password
        </button>
    </form>

    <div class="login-footer">
        <a href="{{ route('login') }}">Kembali ke Login</a>
    </div>

    <div class="copyright">
        © {{ date('Y') }} SIMAKK ASN
    </div>
</div>

</body>
</html>

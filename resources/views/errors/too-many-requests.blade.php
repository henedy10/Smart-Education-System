<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>محاولات كثيرة</title>
    <style>
        body {
            font-family: "Tahoma", sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .error-box {
            background: #fff;
            border: 1px solid #dee2e6;
            padding: 30px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,.1);
            max-width: 450px;
        }
        .error-box h2 {
            color: #dc3545;
            margin-bottom: 15px;
        }
        .error-box p {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="error-box">
        <h2>⚠️ عدد محاولات تسجيل الدخول كبير</h2>
        <p>لقد قمت بمحاولات كثيرة لتسجيل الدخول.</p>
        <p><strong>يرجى المحاولة مرة أخرى عند هذا التاريخ {{$availableAt}}</strong></p>
    </div>
</body>
</html>

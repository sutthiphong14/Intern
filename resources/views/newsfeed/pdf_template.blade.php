<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Newsfeed PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        .container {
            width: 90%;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>{{ $data['name'] }}</h1>
        <p>{{ $data['description'] }}</p>
        <p>สร้างเมื่อ: {{ $data['created_at'] }}</p>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">
  <style>
    body {
      font-family: "Kanit", sans-serif;
      font-style: normal;
      background: linear-gradient(135deg, #ecd716, #ddc806);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .login-card {
      width: 500px;
      padding: 2rem;
      border-radius: 15px;
      background-color: #fff;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .form-control:focus {
      border-color: #f3f3f3;
      box-shadow: 0 0 5px rgba(108, 99, 255, 0.5);
    }
    .btn-primary {
      background-color: #646461;
      border: none;
    }
    .btn-primary:hover {
      background-color: #e4ce0a;
      color: black
    }
    .brand-image {
      display: block;
      margin: 0 auto 20px;
      height: 70px;
    }
  </style>
</head>
<body>
  <div class="login-card">
    <!-- โลโก้ตรงกลาง -->
    <img src="/dist/img/ntlogo.png" alt="NT Logo" class="brand-image">

    <form>
      <div class="mb-3">
        <label for="fullname" class="form-label">Name-Surname</label>
        <input type="text" class="form-control" id="fullname" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <input type="email" class="form-control" id="email" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" required>
      </div>
      <div class="d-flex justify-content-between align-items-center">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="remember">
          <label class="form-check-label" for="remember">Remember me</label>
        </div>
        <a href="#" class="text-decoration-none">Forgot Password?</a>
      </div>
      <button type="submit" class="btn btn-primary w-100 mt-3">Sign In</button>
    </form>
    <p class="text-center mt-4">
      Already have an account? <a href="/signin" class="text-decoration-none">Sign In</a>
    </p>
  </div>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

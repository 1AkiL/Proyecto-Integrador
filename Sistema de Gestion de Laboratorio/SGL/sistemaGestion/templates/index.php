<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>SGL</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #fff4ff;
    }
    .header-img {
      width: 100%;
      height: auto;
      max-height: 180px;
      object-fit: cover;
      display: block;
    }
    .login-box {
      max-width: 420px;
      margin: 40px auto;
      border: 1px solid #e3e3e3;
      border-radius: 8px;
      background-color: white;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }
    .login-title {
      background: linear-gradient(to bottom, #f0f0f0, #e0e0e0);
      padding: 12px;
      font-weight: bold;
      font-size: 1rem;
      border-bottom: 1px solid #ccc;
      text-align: center;
    }
    .login-content {
      padding: 25px;
    }
    .btn-acceder {
      background-color: #682c8b;
      color: white;
      font-weight: bold;
      padding: 8px 20px;
      border-radius: 6px;
      border: none;
    }
    .forgot-password {
      display: block;
      margin-top: 15px;
      color: blueviolet;
      font-size: 0.9rem;
      text-decoration: none;
      text-align: center;
    }
    .forgot-password:hover {
      text-decoration: underline;
    }
  </style>

</head>
<body>
  <header>
    <img src="images\encabezado.png" alt="Encabezado" class="header-img"/>
  </header>
{%block content%}
  <div class="container">
    <div class="login-box">
      <div class="login-title">
        ACCEDER AL CALENDARIO DE RESERVAS
      </div>
      <div class="login-content">
        <form action="" method="POST">
          {% csrf_token %}
          <div class="mb-3">
            <label for="matricula" class="form-label fw-semibold">Matrícula:</label>
            <input type="text" class="form-control" id="matricula" name="matricula" placeholder="Matrícula" required />
          </div>
          <div class="mb-3">
            <label for="contrasena" class="form-label fw-semibold">Contraseña:</label>
            <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Contraseña" required />
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-acceder">Acceder</button>
          </div>
        </form>
        {{error}}
        <a href="#" class="forgot-password">¿Olvidó su contraseña?</a>
      </div>
    </div>
  </div>
{%endblock%}
</body>
</html>

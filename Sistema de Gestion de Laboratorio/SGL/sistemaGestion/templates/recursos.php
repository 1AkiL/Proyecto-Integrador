<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>SGL - Recursos</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

  <style>
    body {
      background-color: #fff4ff;
      margin: 0;
      font-family: sans-serif;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .header-img {
      width: 100%;
      height: auto;
      max-height: 180px;
      object-fit: cover;
      display: block;
      flex-shrink: 0;
    }

    .main-content {
      display: flex;
      flex-grow: 1;
      min-height: calc(100vh - 180px);
    }

    .sidebar-custom {
      background-color: #e3e3e3;
      border-right: 1px solid #ccc;
      width: 230px;
      padding: 0;
      font-size: 0.9rem;
      display: flex;
      flex-direction: column;
    }

    .sidebar-title {
      background-color: #f0f0f0;
      padding: 10px 12px;
      font-weight: bold;
      text-transform: uppercase;
      border-bottom: 1px solid #dcdcdc;
      text-align: center;
    }

    .sidebar-buttons {
      padding: 15px;
      flex-grow: 1;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
    }

    .sidebar-buttons .btn {
      width: 100%;
      margin-bottom: 10px;
      background-color: #682c8b;
      color: white;
      border: none;
      padding: 10px 0;
      font-weight: 600;
      border-radius: 5px;
      text-align: center;
      transition: background-color 0.3s ease;
      font-size: 0.95rem;
    }

    .sidebar-buttons .btn:hover {
      background-color: #501f65;
    }

    .buttons-container {
      background-color: #f9f5fb;
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
      padding: 20px;
    }

    .buttons-container .btn {
      background-color: #a8a3a3;
      color: white;
      border: none;
      padding: 12px 0;
      width: 150px;
      font-weight: 600;
      border-radius: 5px;
      font-size: 1rem;
      transition: background-color 0.3s ease;
      cursor: pointer;
    }

    .buttons-container .btn.active {
      background-color: #501f65 !important;
    }

    .programas {
      padding: 0 20px;
    }

    .programas ul {
      list-style-type: disc;
      padding-left: 20px;
      margin-top: 10px;
      margin-bottom: 30px;
    }

    .table-container {
      padding: 0 20px 20px 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 30px;
    }

    th, td {
      padding: 10px 15px;
      border: 1px solid #ccc;
      text-align: left;
    }

    th {
      background-color: #501f65;
      color: white;
      text-transform: uppercase;
    }

    .table-container > table {
      display: none;
    }

    .table-container > table.active {
      display: table;
    }
  </style>
</head>

<body>
  <header>
    <img src="images/encabezado.png" alt="Encabezado" class="header-img" />
  </header>

  <div class="main-content">
    <div class="sidebar-custom">
      <div class="sidebar-title">RECURSOS</div>
      <div class="sidebar-buttons">
        <a href="/reservar" class="btn"><i class="bi bi-calendar-check me-2"></i>Reserva</a>
        <a href="/calendario" class="btn"><i class="bi bi-search me-2"></i>Consulta</a>
        <a href="/logoff" class="btn"><i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión</a>
      </div>
    </div>

    <div class="flex-grow-1">
      <div class="buttons-container">
        <button class="btn active" data-lab="lab1">Lab1</button>
        <button class="btn" data-lab="lab2">Lab2</button>
        <button class="btn" data-lab="lab3">Lab3</button>
        <button class="btn" data-lab="lab4">Lab4</button>
        <button class="btn" data-lab="lab5">Lab5</button>
        <button class="btn" data-lab="lab6">Lab6</button>
        <button class="btn" data-lab="lab7">Lab7</button>
      </div>

      <div class="programas">
        <ul id="prog-lab1" class="programas-list">
          <li>{{laboratorio.programas_instalados}}
         
        </ul>
        <ul id="prog-lab2" class="programas-list" style="display:none;">
          <li>MATLAB</li>
          <li>SolidWorks</li>
          <li>Chrome</li>
        </ul>
        <ul id="prog-lab3" class="programas-list" style="display:none;">
          <li>Photoshop (5 licencias)</li>
          <li>Illustrator</li>
          <li>GIMP</li>
        </ul>
        <ul id="prog-lab4" class="programas-list" style="display:none;">
          <li>NetBeans</li>
          <li>Eclipse</li>
          <li>Java SDK</li>
        </ul>
        <ul id="prog-lab5" class="programas-list" style="display:none;">
          <li>MySQL Workbench</li>
          <li>HeidiSQL</li>
          <li>XAMPP</li>
        </ul>
        <ul id="prog-lab6" class="programas-list" style="display:none;">
          <li>Unity</li>
          <li>Unreal Engine</li>
          <li>Blender</li>
        </ul>
        <ul id="prog-lab7" class="programas-list" style="display:none;">
          <li>Python (Anaconda)</li>
          <li>JupyterLab</li>
          <li>RStudio</li>
        </ul>
      </div>
    {%block content%}
      <div class="table-container">
        <table id="lab1" class="active">
          <thead>
            <tr>
              <th>Modelo PC</th>
              <th>RAM</th>
              <th>Procesador</th>
              <th>Disco duro</th>
              <th>Sistema operativo</th>
            </tr>
          </thead>
          {%for recurso in recursos%}
          <tbody>
            <tr>
              <td>{{recurso.nombre_recurso}}</td>
              <td>{{recurso.memoria}} GB</td>
              <td>{{recurso.procesador}}</td>
              <td>{{recurso.almacenamiento}} GB</td>
              <td>{{recurso.sistema_operativo}}</td>
            </tr>
          </tbody>
          {%endfor%}
        </table>
    
        <table id="lab2">
          <thead>
            <tr>
              <th>Modelo PC</th>
              <th>RAM</th>
              <th>Procesador</th>
              <th>Disco duro</th>
              <th>Sistema operativo</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Dell OptiPlex 3080</td>
              <td>16 GB</td>
              <td>Intel i7</td>
              <td>1 TB</td>
              <td>Windows 11</td>
            </tr>
          </tbody>
        </table>

        <table id="lab3">
          <thead>
            <tr>
              <th>Modelo PC</th>
              <th>RAM</th>
              <th>Procesador</th>
              <th>Disco duro</th>
              <th>Sistema operativo</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Acer Aspire TC</td>
              <td>12 GB</td>
              <td>Intel i5</td>
              <td>1 TB</td>
              <td>Windows 10</td>
            </tr>
          </tbody>
        </table>

        <table id="lab4">
          <thead>
            <tr>
              <th>Modelo PC</th>
              <th>RAM</th>
              <th>Procesador</th>
              <th>Disco duro</th>
              <th>Sistema operativo</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Lenovo ThinkCentre</td>
              <td>8 GB</td>
              <td>Intel i3</td>
              <td>500 GB</td>
              <td>Ubuntu 22.04</td>
            </tr>
          </tbody>
        </table>

        <table id="lab5">
          <thead>
            <tr>
              <th>Modelo PC</th>
              <th>RAM</th>
              <th>Procesador</th>
              <th>Disco duro</th>
              <th>Sistema operativo</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>HP EliteDesk</td>
              <td>16 GB</td>
              <td>AMD Ryzen 5</td>
              <td>512 GB SSD</td>
              <td>Windows 11</td>
            </tr>
          </tbody>
        </table>

        <table id="lab6">
          <thead>
            <tr>
              <th>Modelo PC</th>
              <th>RAM</th>
              <th>Procesador</th>
              <th>Disco duro</th>
              <th>Sistema operativo</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>MSI Creator</td>
              <td>32 GB</td>
              <td>Intel i9</td>
              <td>2 TB SSD</td>
              <td>Windows 11 Pro</td>
            </tr>
          </tbody>
        </table>

        <table id="lab7">
          <thead>
            <tr>
              <th>Modelo PC</th>
              <th>RAM</th>
              <th>Procesador</th>
              <th>Disco duro</th>
              <th>Sistema operativo</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>ASUS VivoMini</td>
              <td>8 GB</td>
              <td>Intel i5</td>
              <td>256 GB SSD</td>
              <td>Linux Mint</td>
            </tr>
          </tbody>
    {%endblock%}
        </table>
      </div>
    </div>
  </div>

  <script>
    const buttons = document.querySelectorAll('.buttons-container .btn');
    const tables = document.querySelectorAll('.table-container > table');
    const programas = document.querySelectorAll('.programas-list');

    buttons.forEach(button => {
      button.addEventListener('click', () => {
        const labId = button.getAttribute('data-lab');

        // Activar tabla
        tables.forEach(table => {
          table.classList.toggle('active', table.id === labId);
        });

        // Activar botón
        buttons.forEach(btn => {
          btn.classList.toggle('active', btn === button);
        });

        // Activar lista de programas
        programas.forEach(prog => {
          prog.style.display = prog.id === `prog-${labId}` ? 'block' : 'none';
        });
      });
    });
  </script>
</body>
</html>





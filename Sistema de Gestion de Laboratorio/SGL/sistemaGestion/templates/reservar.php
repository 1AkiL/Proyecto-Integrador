<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>SGL - Reservar</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet" />

  <style>
    body { background-color: #fff4ff; }
    .header-img {
      width: 100%; height: auto; max-height: 180px;
      object-fit: cover; display: block;
    }

    .sidebar-custom {
      background-color: #e3e3e3; border-right: 1px solid #ccc;
      width: 230px; min-height: 100vh; padding: 0;
      font-family: sans-serif; font-size: 0.9rem;
    }

    .sidebar-title {
      background-color: #f0f0f0; padding: 10px 12px;
      font-weight: bold; text-transform: uppercase;
      border-bottom: 1px solid #dcdcdc;
    }

    .sidebar-buttons {
      padding: 15px;
    }

    .sidebar-buttons .btn {
      width: 100%; margin-bottom: 10px;
      background-color: #682c8b; color: white;
      border: none; padding: 10px 0;
      font-weight: 600; border-radius: 5px;
      font-size: 0.95rem; transition: 0.3s;
    }

    .sidebar-buttons .btn:hover {
      background-color: #501f65;
    }

    .form-panel {
      background-color: #f8f8f8;
      padding: 20px;
      border-radius: 10px;
    }

    #calendar {
      width: 100%;
      font-size: 0.85rem;
      background-color: white;
      padding: 15px;
      border-radius: 8px;
      box-shadow: 0 0 8px rgba(0,0,0,0.1);
    }

    .legend {
      font-size: 0.9rem; margin-bottom: 15px;
    }

    .legend span {
      display: inline-block;
      width: 15px; height: 15px;
      margin-right: 5px; vertical-align: middle;
      border-radius: 3px;
    }

    .disponible { background-color: #28a745; }
    .mantenimiento { background-color: orange; }
    .nodisponible { background-color: red; }

    .fc-event {
      background: transparent !important;
      border: none !important;
      box-shadow: none !important;
    }
  </style>
</head>

<body>
  <header>
    <img src="../images/encabezado.png" alt="Encabezado" class="header-img" />
  </header>

  <div class="container-fluid">
    <div class="row">
      <div class="col-auto px-0">
        <div class="sidebar-custom">
          <div class="sidebar-title text-center">RESERVA</div>
          <div class="sidebar-buttons">
            <a href="/recursos" class="btn"><i class="bi bi-pc-display me-2"></i>Recursos</a>
            <a href="/calendario" class="btn"><i class="bi bi-search me-2"></i>Consulta</a>
            <a href="/logoff" class="btn"><i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión</a>
          </div>
        </div>
      </div>
      {% block content%}
      <div class="col">
        <div class="row g-4 p-4">
          <!-- Formulario -->
          <div class="col-12 col-lg-3">
            <div class="form-panel">
              <h5 class="mb-3">Formulario de reserva</h5>
              <form id="formReserva">
                <div class="mb-3">
                  <label for="usuario" class="form-label">Usuario</label>
                  <input type="text" class="form-control" id="usuario" name="usuario" value="<?= htmlspecialchars($usuario) ?>" readonly />
                </div>

                <div class="mb-3">
                  <label for="correo" class="form-label">Correo</label>
                  <input type="email" class="form-control" id="correo" name="correo" value="<?= htmlspecialchars($correo) ?>" readonly />
                </div>

                <div class="mb-3">
                  <label for="matricula" class="form-label">Matrícula</label>
                  <input type="text" class="form-control" id="matricula" name="matricula" value="<?= htmlspecialchars($matricula) ?>" readonly />
                </div>

                <div class="mb-3">
                  <label for="fecha_reserva" class="form-label">Fecha de reserva</label>
                  <input type="date" class="form-control" id="fecha_reserva" name="fecha" required />
                </div>

                <div class="mb-3">
                  <label for="hora_inicio" class="form-label">Hora inicio</label>
                  <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" required />
                </div>

                <div class="mb-3">
                  <label for="hora_fin" class="form-label">Hora fin</label>
                  <input type="time" class="form-control" id="hora_fin" name="hora_fin" required />
                </div>

                <input type="hidden" id="laboratorio-hidden" name="laboratorio" />

                <div class="d-flex gap-3">
                  <button type="reset" class="btn btn-danger w-50" onclick="resetFormulario()">Cancelar</button>
                  <button type="submit" class="btn btn-success w-50">Confirmar</button>
                </div>
              </form>
              {{error}}
            </div>
      {%endblock%}
          </div>

          <!-- Calendario y selector -->
          <div class="col-12 col-lg-9">
            <div class="mb-3">
              <label for="laboratorio" class="form-label">Seleccionar laboratorio</label>
              <select class="form-select" id="laboratorio">
                <option disabled>Seleccione uno</option>
                <option value="Laboratorio 1" selected>Laboratorio 1</option>
                <option value="Laboratorio 2">Laboratorio 2</option>
                <option value="Laboratorio 3">Laboratorio 3</option>
                <option value="Laboratorio 4">Laboratorio 4</option>
                <option value="Laboratorio 5">Laboratorio 5</option>
                <option value="Laboratorio 6">Laboratorio 6</option>
                <option value="Laboratorio 7">Laboratorio 7</option>
              </select>
            </div>

            <!-- LEYENDA ARRIBA DEL CALENDARIO -->
            <div class="legend mb-3">
              <span class="disponible"></span> Disponible &nbsp;
              <span class="mantenimiento"></span> En mantenimiento &nbsp;
              <span class="nodisponible"></span> No disponible
            </div>
            <div id="calendar"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      let calendar;
      const calendarEl = document.getElementById('calendar');

      function cargarCalendario(lab) {
        if (calendar) calendar.destroy();

        calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          locale: 'es',
          headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: ''
          },
          buttonText: {
            today: 'Hoy'
          },
          eventTimeFormat: {
            hour: 'numeric',
            minute: '2-digit',
            hour12:true
          },
          events: `../get_reservas.php?lab=${encodeURIComponent(lab)}`,
          eventContent: function (arg) {
            const title = arg.event.title;
            const color = 'red';
            return {
              html: `
                <div style="display:flex; align-items:center; gap:4px; font-size:0.75rem; font-weight:500; color:#000; white-space: nowrap;">
                  <span style=" 
                    display:inline-block;
                    width: 12px;
                    height: 12px;
                    background-color: ${color};
                    border-radius: 50%;
                    flex-shrink: 0;
                  " title="${title}"></span>
                  <span>${title}</span>
                </div>
              `
            };
          },
          dateClick: function (info) {
            const fecha = info.dateStr;
            document.getElementById('fecha_reserva').value = fecha;
          },
          eventsSet: function (events) {
            console.log("Eventos cargados:", events);
          },
          eventDidMount: function (info) {
            info.el.style.background = 'transparent';
            info.el.style.border = 'none';
            info.el.style.boxShadow = 'none';
          }
        });

        calendar.render();
      }

      const selectLab = document.getElementById('laboratorio');
      const laboratorioHidden = document.getElementById('laboratorio-hidden');

      cargarCalendario('Laboratorio 1');
      selectLab.value = 'Laboratorio 1';
      laboratorioHidden.value = 'Laboratorio 1';

      selectLab.addEventListener('change', function () {
        const lab = this.value;
        cargarCalendario(lab);
        laboratorioHidden.value = lab;
        document.getElementById('fecha_reserva').value = '';
      });

      const form = document.getElementById('formReserva');
      form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        fetch('../procesar_reserva.php', {
          method: 'POST',
          body: formData
        })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              form.reset();
              const lab = laboratorioHidden.value;
              cargarCalendario(lab);
            } else {
              alert('Error al hacer la reserva: ' + data.error);
            }
          })
          .catch(error => {
            console.error('Error:', error);
          });
      });
    });
  </script>
</body>
</html>

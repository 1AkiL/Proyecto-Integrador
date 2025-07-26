<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SGL - Calendario</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <!-- FullCalendar CSS -->
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet" />

  <style>
    body {
      background-color: #fff4ff;
      font-family: Arial, sans-serif;
    }

    .header-img {
      width: 100%;
      height: auto;
      max-height: 180px;
      object-fit: cover;
      display: block;
    }

    .sidebar-custom {
      background-color: #e3e3e3;
      border-right: 1px solid #ccc;
      width: 230px;
      min-height: 100vh;
      padding: 0;
      font-family: sans-serif;
      font-size: 0.9rem;
    }

    .sidebar-title {
      background-color: #f0f0f0;
      padding: 10px 12px;
      font-weight: bold;
      text-transform: uppercase;
      border-bottom: 1px solid #dcdcdc;
    }

    .sidebar-buttons {
      padding: 15px;
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
      color: #fff;
    }

    
    .calendar-container {
      display: flex;
      justify-content: flex-start;  
      padding: 20px;
    }

    #calendar {
      width: 100%;  
      background-color: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .fc-event {
      background-color: transparent !important;
      border: none !important;
      box-shadow: none !important;
      color: black !important;
    }

    .fc-event-dot {
      width: 12px;
      height: 12px;
      border-radius: 50%;
      margin-right: 10px;
      display: inline-block;
    }

    .ocupado {
      background-color: red !important;
    }

    .mantenimiento {
      background-color: yellow !important;
    }

    .fc-daygrid-day-number {
      font-size: 1.1rem;
      font-weight: bold;
    }

    /* Leyenda de colores con los puntos */
    .legend {
      font-size: 1rem;
      display: flex;
      flex-direction: column;
      gap: 15px;
      justify-content: center;
      align-items: flex-start;  
      margin-left: 20px;  
    }

    .legend span {
      display: inline-block;
      width: 20px;
      height: 20px;
      border-radius: 50%;
    }

    /* Colores de los puntos */
    .disponible {
      background-color: green !important;
    }

    .mantenimiento {
      background-color: yellow !important;
    }

    .nodisponible {
      background-color: red !important;
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
          <div class="sidebar-title text-center">
            CONSULTA
          </div>
          <div class="sidebar-buttons">
            <a href="/recursos" class="btn d-block text-center text-white text-decoration-none">
              <i class="bi bi-pc-display me-2"></i>Recursos
            </a>
            <a href="/reservar" class="btn d-block text-center text-white text-decoration-none">
              <i class="bi bi-calendar-check me-2"></i>Reserva
            </a>
            <a href="/logoff" class="btn d-block text-center text-white text-decoration-none">
              <i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión
            </a>
          </div>
        </div>
      </div>
      <div class="col d-flex">
        
        <div id="calendar"></div>

       
        <div class="legend">
          <div>
            <span class="nodisponible"></span> No disponible
          </div>
          <div>
            <span class="mantenimiento"></span> En mantenimiento
          </div>
          <div>
            <span class="disponible"></span> Disponible
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var calendarEl = document.getElementById('calendar');

      var today = new Date();
      var currentMonth = today.getMonth(); 
      var currentYear = today.getFullYear(); 

      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        initialDate: today, 
        height: 'auto',
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: ''
        },
        events: function(info, successCallback, failureCallback) {
          
          fetch('../get_reservas_consultas.php')  
            .then(response => response.json())
            .then(events => {
              console.log('Eventos obtenidos:', events);  
              if (events.length === 0) {
                console.log('No hay reservas para mostrar.');
              } else {
                const calendarEvents = events.map(event => {
                  let colorClass = 'ocupado';  
                  if (event.color === 'yellow') {
                    colorClass = 'mantenimiento'; 
                  }
                  return {
                    title: event.title, 
                    start: event.start, 
                    end: event.end,     
                    color: event.color, 
                    description: event.description, 
                    extendedProps: {  
                      colorClass: colorClass
                    }
                  };
                });
                successCallback(calendarEvents);  
              }
            })
            .catch(error => {
              console.error('Error al cargar los eventos:', error);
              failureCallback(error);  
            });
        },

        eventContent: function(info) {
          const dotElement = document.createElement('span');
          dotElement.className = `fc-event-dot ${info.event.extendedProps.colorClass}`;  
          const eventTitle = document.createElement('span');
          eventTitle.className = 'fc-event-title';
          eventTitle.innerText = info.event.title;

          const eventDiv = document.createElement('div');
          eventDiv.appendChild(dotElement);
          eventDiv.appendChild(eventTitle);

          return { domNodes: [eventDiv] };
        }
      });

      calendar.render();
    });
  </script>
</body>
</html>














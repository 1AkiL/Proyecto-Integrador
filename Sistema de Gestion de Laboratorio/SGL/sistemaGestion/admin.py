from django.contrib import admin
from .models import Usuario,Rol,Recurso, Laboratorio, EstadoRecurso,Reserva, EstadoReserva, EstadoMantenimiento
# Register your models here.

admin.site.register(Usuario)
admin.site.register(Rol)
admin.site.register(Recurso)
admin.site.register(Laboratorio)
admin.site.register(EstadoRecurso)
admin.site.register(Reserva)
admin.site.register(EstadoReserva)
admin.site.register(EstadoMantenimiento)
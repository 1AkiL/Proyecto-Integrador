from django.contrib import admin
from .models import Usuario,Rol,Recurso, Laboratorio, EstadoRecurso, TipoRecurso
# Register your models here.

admin.site.register(Usuario)
admin.site.register(Rol)
admin.site.register(Recurso)
admin.site.register(Laboratorio)
admin.site.register(TipoRecurso)
admin.site.register(EstadoRecurso)
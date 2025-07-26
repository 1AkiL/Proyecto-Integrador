from django.db import models
from django.contrib.auth.models import User

# Create your models here.
class Rol(models.Model):
    idRol=models.IntegerField(primary_key=True, unique=True)
    nombre_rol=models.CharField(max_length=15)
    
    def __str__(self):
        return self.nombre_rol

class Usuario(models.Model):
    user=models.OneToOneField(User,on_delete=models.CASCADE)
    RolId=models.ForeignKey(Rol,on_delete=models.CASCADE,default=3)
    
class TipoRecurso(models.Model):
    idTipoRecurso=models.IntegerField(primary_key=True, unique=True)
    nombre_tipoRecurso=models.CharField(max_length=30)
    
    def __str__(self):
        return self.nombre_tipoRecurso
    
class EstadoRecurso(models.Model):
    idEstadoRecurso=models.IntegerField(primary_key=True,unique=True)
    nombre_estado=models.CharField(max_length=20)
    
    def __str__(self):
        return self.nombre_estado
    
class Laboratorio(models.Model):
    idLab=models.AutoField(primary_key=True, unique=True)
    nombre_lab=models.CharField(max_length=30)
    programas_instalados=models.TextField(default='Google Chrome')
    
    def __str__(self):
        return self.nombre_lab

class Recurso(models.Model):
    idRecurso=models.AutoField(primary_key=True,unique=True)
    nombre_recurso=models.CharField(max_length=40)
    tipo_recurso=models.ForeignKey(TipoRecurso, on_delete=models.CASCADE, null=True)
    descripcion=models.TextField(null=True)
    estado_recurso=models.ForeignKey(EstadoRecurso, on_delete=models.CASCADE, default=1)
    idLab=models.ForeignKey(Laboratorio, on_delete=models.CASCADE, null=True)
    memoria=models.IntegerField(null=True)
    procesador=models.CharField(max_length=25, null=True)
    almacenamiento=models.IntegerField(null=True, default=1)
    sistema_operativo=models.CharField(max_length=10, null= True)
    
class EstadoMantenimiento(models.Model):
    idEstadoMantenimiento=models.IntegerField(primary_key=True,unique=True)
    nombre_estado=models.CharField(max_length=20)
    
    def __str__(self):
        
        return self.nombre_estado

class Mantenimiento(models.Model):
    idMantenimiento=models.AutoField(primary_key=True, unique=True)
    idRecurso=models.ForeignKey(Recurso, on_delete=models.CASCADE, null=True)
    fecha_mantenimiento=models.DateField()
    descripcion=models.TextField()
    estado=models.ForeignKey(EstadoMantenimiento,on_delete=models.CASCADE)
    
    def __str__(self):
        return 'Mantenimiento'+ self.idMantenimiento


    

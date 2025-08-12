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
    
    def __str__(self):
        return self.user.username + ' - ' + self.RolId.nombre_rol
    
    
class EstadoRecurso(models.Model):
    idEstadoRecurso=models.IntegerField(primary_key=True,unique=True)
    nombre_estado=models.CharField(max_length=20)
    
    def __str__(self):
        return self.nombre_estado
    
class Laboratorio(models.Model):
    idLab=models.AutoField(primary_key=True, unique=True)
    nombre_lab=models.CharField(max_length=30)
    
    def __str__(self):
        return self.nombre_lab

class Recurso(models.Model):
    idRecurso=models.AutoField(primary_key=True,unique=True)
    nombre_recurso=models.CharField(max_length=40)
    estado_recurso=models.ForeignKey(EstadoRecurso, on_delete=models.CASCADE, default=1)
    idLab=models.ForeignKey(Laboratorio, on_delete=models.CASCADE, null=True)
    memoria=models.IntegerField(null=True)
    procesador=models.CharField(max_length=25, null=True)
    almacenamiento=models.IntegerField(null=True, default=1)
    sistema_operativo=models.CharField(max_length=10, null= True)

    def __str__(self):
        return self.nombre_recurso
    
class EstadoMantenimiento(models.Model):
    idEstadoMantenimiento=models.IntegerField(primary_key=True,unique=True)
    nombre_estado=models.CharField(max_length=20)
    
    def __str__(self):
        
        return self.nombre_estado

class Mantenimiento(models.Model):
    idMantenimiento=models.AutoField(primary_key=True, unique=True)
    idRecurso=models.ForeignKey(Recurso, on_delete=models.CASCADE, null=True)
    fecha_mantenimiento=models.DateField()
    estado=models.ForeignKey(EstadoMantenimiento,on_delete=models.CASCADE)
    
    def __str__(self):
        return 'Mantenimiento'+ self.idMantenimiento

class EstadoReserva(models.Model):
    id_EstadoReserva=models.IntegerField(unique=True, primary_key=True)
    nombre_estado_reserva= models.CharField(max_length=20)
    
    def __str__(self):
        return self.nombre_estado_reserva

class Reserva(models.Model):
    idReserva=models.AutoField(primary_key=True, unique=True)
    idUsuario=models.ForeignKey(User, on_delete=models.CASCADE)
    estado_reserva=models.ForeignKey(EstadoReserva, on_delete=models.CASCADE, blank=True)
    idLab=models.ForeignKey(Laboratorio, on_delete=models.CASCADE)
    fecha_reserva=models.DateField()
    inicio_reserva=models.TimeField()
    fin_reserva=models.TimeField()
    
    def __str__(self):
        return 'Reserva'
    

    

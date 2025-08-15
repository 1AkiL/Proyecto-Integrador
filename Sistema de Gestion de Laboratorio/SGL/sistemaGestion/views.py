from django.shortcuts import render, redirect
from django.contrib.auth import authenticate, login, logout
from django.contrib.auth.decorators import login_required
from .models import Recurso, Laboratorio, Usuario, Reserva, Mantenimiento, EstadoRecurso,Rol, EstadoMantenimiento
from django.contrib.auth.models import User
from django.core.mail import send_mail 
from SGL.settings import EMAIL_HOST_USER
from django.contrib.auth.hashers import make_password

# Create your views here.

#Login system does work, but sadly I couldn't get it to use the ID to log in :(
def signin(request):
    if request.method=='GET':
        return render (request,'index.html')
    else:
        user=authenticate(request, username=request.POST['matricula'], password=request.POST['contrasena'])
        print(request.POST)
        if user is None:
            return render(request,'index.html',{
                'error':'Matricula o contraseña incorrectos'
            })
        else:
            login(request,user)
            return redirect('calendario')

@login_required
def calendario(request):
    reservas=Reserva.objects.all()
    return render(request,'consultar_reservas.html', {'reservas':reservas})

@login_required
def recursos(request):
    UsuarioAdmin=Usuario.objects.filter(user=request.user, RolId=1)
    recursos=Recurso.objects.filter(idLab=1)  
    recursos2=Recurso.objects.filter(idLab=2)
    recursos3=Recurso.objects.filter(idLab=3)
    recursos4=Recurso.objects.filter(idLab=4)
    recursos5=Recurso.objects.filter(idLab=5)
    recursos6=Recurso.objects.filter(idLab=6)
    recursos7=Recurso.objects.filter(idLab=7)
    print(request.POST)
    return render(request,'recursos.html',{
        'recursos':recursos, 'recursos2': recursos2, 'recursos3':recursos3,'recursos4':recursos4,
        'recursos5':recursos5, 'recursos6':recursos6, 'recursos7':recursos7,'UsuarioAdmin':UsuarioAdmin})


@login_required
#TODO Make it so no reservation before now is allowed
def reservar(request):
    usuario=Usuario.objects.get(user=request.user.id)
    lab=Laboratorio.objects.all()
    if request.method=='GET':
        return render(request, 'add_reserva.html', {
            'usuario':usuario,
            'lab':lab
        })
    else:
        try:
            matricula=request.POST['matricula']
            fecha_res=request.POST['fecha_reserva']
            inicio_res=request.POST['inicio_reserva']
            fin_res=request.POST['fin_reserva']
            laboratorio=request.POST['lab']
            matricula=User.objects.get(id=matricula)
            laboratorio=Laboratorio.objects.get(idLab=laboratorio)
            nueva_reserva=Reserva(idUsuario=matricula, fecha_reserva=fecha_res, inicio_reserva=inicio_res,fin_reserva=fin_res, idLab=laboratorio)
            nueva_reserva.save()
            send_mail(subject= 'Reserva realizada',
                      message= f'Este email ha sido enviado para informar que su reserva para el dia {fecha_res} ha sido aceptada.',
                      from_email=EMAIL_HOST_USER,
                      recipient_list=[request.user.email])
            return redirect('calendario') 
        except ValueError:
            return render(request, 'add_reserva.html', {
                'error': 'Algun dato es invalido',
                'usuario':usuario,
                'lab':lab
            })

@login_required
def mis_reservas(request):
    reservas=Reserva.objects.filter(idUsuario=request.user)
    return render(request, 'misreservas.html',{'reservas':reservas})
        
@login_required
def admin_reservas(request):
    reservas=Reserva.objects.all()
    usuario=Usuario.objects.all()
    return render(request,'todas_las_reservas.html', {'reservas':reservas, 'usuario':usuario})

@login_required
def signoff(request):
    logout(request)
    return redirect('signin')

#Template for the emails

@login_required
#Permite a los sistemas que utilizan la sidebar funcionar, no remover.
def sidebar(request):
    UsuarioAdmin=Usuario.objects.filter(user=request.user, RolId=1)
    UsuarioDocente=Usuario.objects.filter(user=request.user, RolId=2)
    UsuarioAlumno=Usuario.objects.filter(user=request.user, RolId=3)
    return render(request, 'sidebar.html', {'UsuarioAdmin':UsuarioAdmin, 'UsuarioDocente':UsuarioDocente, 'UsuarioAlumno':UsuarioAlumno})

@login_required
#Es para mis_reservas, no confundir con borrar_reserva_admin
def borrar_mi_reserva(request, idReserva):
    reserva=Reserva.objects.get(idReserva=idReserva)
    email_borrar_reserva(request)
    reserva.delete()
    return redirect('mis-reservas')

@login_required
def borrar_reserva_admin(request,idReserva):
    reserva=Reserva.objects.get(idReserva=idReserva)
    email_borrar_reserva(request)
    reserva.delete()
    return redirect('admin-reservas')

def email_borrar_reserva(request):
    send_mail(subject="Borrado de reservas",
              message='Una reserva se ha borrado exitosamente',
              from_email=EMAIL_HOST_USER,
              recipient_list=[request.user.email])

@login_required
def borrar_mantenimientos(request,idMantenimiento):
    mantenimiento=Mantenimiento.objects.get(idMantenimiento=idMantenimiento)
    mantenimiento.delete()
    send_mail(subject='Borrado de mantenimientos',
              message='El mantenimiento se ha borrado exitosamente',
              from_email=EMAIL_HOST_USER,
              recipient_list=[request.user.email])
    return redirect('mantenimientos')


@login_required
def borrar_recursos(request,idRecurso):
    recurso=Recurso.objects.get(idRecurso=idRecurso)
    recurso.delete()
    send_mail(subject='Borrado de recursos',
              message='El recurso ha sido borrado exitosamente',
              from_email=EMAIL_HOST_USER,
              recipient_list=[request.user.email])
    return redirect('recursos')

@login_required    
def admin_usuarios(request):
    usuarios=Usuario.objects.all()
    return render(request, 'usuarios.html', {'usuarios':usuarios})

@login_required
def borrar_usuarios(request,user):
    usuarios=Usuario.objects.get(user=user)
    usuarios.delete()
    send_mail(subject='Borrado de usuarios',
              message=f'El borrado del usuario ha sido exitoso',
              from_email=EMAIL_HOST_USER,
              recipient_list=[request.user.email])
    return redirect('usuarios-admin')

@login_required
def mantenimientos(request):
    mantenimiento=Mantenimiento.objects.all()
    return render(request, 'mantenimiento.html',{'mantenimientos':mantenimiento})

@login_required
def addRecurso(request):
    lab=Laboratorio.objects.all()
    est_rec=EstadoRecurso.objects.all() #Estado recurso por si no se entiende
    if request.method=="GET":
        return render(request, 'add_recurso.html', {'lab':lab , 'est_rec':est_rec})
    else:
        try:
            nombre=request.POST['nombre']
            estado=request.POST['Estado']
            procesador=request.POST['Procesador']
            memoria=request.POST['memoria']
            almacenamiento=request.POST['almacenamiento']
            os=request.POST['os']
            laboratorio=request.POST['Laboratorio']
            estad=EstadoRecurso.objects.get(idEstadoRecurso=estado)
            labo=Laboratorio.objects.get(idLab=laboratorio)
            nuevo_recurso=Recurso(nombre_recurso=nombre, estado_recurso=estad, idLab=labo, memoria=memoria, procesador=procesador, almacenamiento=almacenamiento, sistema_operativo=os)
            nuevo_recurso.save()
            send_mail(subject='Agregado de recursos',
                      message='El recurso se ha agregado al sistema de forma exitosa',
                      from_email=EMAIL_HOST_USER,
                      recipient_list=[request.user.email])
            return redirect('recursos')
        except ValueError:
            return render(request,'add_recurso.html',{'lab':lab, 'est_rec':est_rec, 'error':'Algún dato es inválido'})

@login_required
def addUsuario(request):
    rol=Rol.objects.all()
    if request.method=="GET":
        return render(request, 'add_user.html',{'rol':rol})
    else:
        print(request.POST)
        try:
            nombre=request.POST['nombre']
            Email=request.POST['email']
            contraseña=request.POST['contrasena']
            rol=request.POST['rol']
            role=Rol.objects.get(idRol=rol)
            contraseña=make_password(contraseña)
            nuevo_usuario=User(username=nombre, email=Email, password=contraseña)
            nuevo_usuario.save()
            nuevo_Usuario=Usuario(user=nuevo_usuario, RolId=role)
            nuevo_Usuario.save()
            send_mail(subject='Adicion de usuarios',
                      message=f'El usuario nuevo de nombre {nombre} se ha agregado al sistema.',
                      from_email=EMAIL_HOST_USER,
                      recipient_list=[request.user.email])
            return redirect('usuarios-admin')
        except ValueError:
            return render(request,'add_user.html',{'rol':rol , 'error':'Algún dato es inválido'})

@login_required
def addMantenimiento(request):
    recurso=Recurso.objects.all()
    est_man=EstadoMantenimiento.objects.all() #Estado mantenimiento por si no se entiende
    if request.method=="GET":
        return render(request, 'add_mantenimiento.html',{'recursos':recurso, 'est_man':est_man})
    else:
        try:
            rec=request.POST['Recurso']
            fecha_man=request.POST['Fecha_mantenimiento']
            est=request.POST['Estado_mantenimiento']
            rec=Recurso.objects.get(idRecurso=rec)
            est=EstadoMantenimiento.objects.get(idEstadoMantenimiento=est)
            nuevo_mantenimiento=Mantenimiento(idRecurso=rec, fecha_mantenimiento=fecha_man, estado=est)
            nuevo_mantenimiento.save()
            send_mail(subject='Nuevo mantenimiento',
                      message=f'Un nuevo mantenimiento se ha asignado para el dia {fecha_man}',
                      from_email=EMAIL_HOST_USER,
                      recipient_list=[request.user.email])
            return redirect('mantenimientos')
        except ValueError:
            return render(request,'add_mantenimiento.html',{'error':'Algún dato es inválido', 'recursos':recurso, 'est_man':est_man})
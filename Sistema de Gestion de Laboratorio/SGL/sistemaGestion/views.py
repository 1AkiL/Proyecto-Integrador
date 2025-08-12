from django.shortcuts import render, redirect
from django.contrib.auth import authenticate, login, logout
from django.contrib.auth.decorators import login_required
from .models import Recurso, Laboratorio, Usuario, Reserva, Mantenimiento
from django.utils.timezone import localtime, localdate
from .forms import ReservaForm
from django.shortcuts import get_object_or_404
from django.http import HttpResponse
from django.core.mail import send_mail 
from SGL.settings import EMAIL_HOST_USER

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
        'recursos5':recursos5, 'recursos6':recursos6, 'recursos7':recursos7})


@login_required
#TODO Make reservations to work
def reservar(request):
    lab=Laboratorio.objects.all()
    reserva=Reserva.objects.all()
    if request.method=='GET':
        return render(request, 'reservar.html', {
            'usuario':request.user,
            'lab':lab
        })
    else:
        try:
            print(request.POST)
            
            return redirect('calendario')
        except ValueError:
            return render(request, 'reservar.html', {
                'form':ReservaForm,
                'error': 'Algun dato es invalido',
                'usuario':request.user,
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
def email_test(request):
    send_mail(subject= 'Test email',
              message= 'This is just a test email',
              from_email=EMAIL_HOST_USER,
              recipient_list=[request.user.email]
              )
    return HttpResponse('Message sent')

#Permite a los sistemas que utilizan la sidebar funcionar, no remover.
def sidebar(request):
    UsuarioAdmin=Usuario.objects.filter(user=request.user, RolId=1)
    UsuarioDocente=Usuario.objects.filter(user=request.user, RolId=2)
    UsuarioAlumno=Usuario.objects.filter(user=request.user, RolId=3)
    return render(request, 'sidebar.html', {'UsuarioAdmin':UsuarioAdmin, 'UsuarioDocente':UsuarioDocente, 'UsuarioAlumno':UsuarioAlumno})

#Es para mis_reservas, no confundir con borrar_reserva_admin
def borrar_mi_reserva(request, idReserva):
    reserva=get_object_or_404(Reserva,pk=idReserva, user=request.user)
    if request.method=="POST":
        reserva.delete()
        return redirect('mis_reservas')

def borrar_reserva_admin(request,idReserva):
    reserva=get_object_or_404(Reserva,pk=idReserva, user=request.user)
    if request.method=="POST":
        reserva.delete()
        return redirect('admin_reservas')
    
def admin_usuarios(request):
    usuarios=Usuario.objects.all()
    return render(request, 'usuarios.html', {'usuarios':usuarios})

def mantenimientos(request):
    mantenimiento=Mantenimiento.objects.all()
    return render(request, 'mantenimiento.html',{'mantenimientos':mantenimiento})

def addRecurso(request):
    return HttpResponse('Recurso added')
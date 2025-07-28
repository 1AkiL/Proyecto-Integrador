from django.shortcuts import render, redirect
from django.contrib.auth import authenticate, login, logout
from django.contrib.auth.decorators import login_required
from django.contrib.auth.models import User
from .models import Recurso, Laboratorio, Usuario
from django.utils.timezone import localtime, localdate
from .forms import ReservaForm
from django.shortcuts import get_object_or_404

# Create your views here.
#TODO Make the login system work
def signin(request):
    if request.method=='GET':
        return render (request,'index.php')
    else:
        user=authenticate(request, username=request.POST['matricula'], password=request.POST['contrasena'])
        print(request.POST)
        if user is None:
            return render(request,'index.php',{
                'error':'Matricula o contraseña incorrectos'
            })
        else:
            login(request,user)
            return redirect('calendario')

@login_required
def calendario(request):
    return render(request,'consultarcalendario.php')

@login_required
#TODO Try to make this today
def recursos(request):
    recursos=Recurso.objects.filter(idLab=1)  
    recursos2=Recurso.objects.filter(idLab=2)
    recursos3=Recurso.objects.filter(idLab=3)
    recursos4=Recurso.objects.filter(idLab=4)
    recursos5=Recurso.objects.filter(idLab=5)
    recursos6=Recurso.objects.filter(idLab=6)
    recursos7=Recurso.objects.filter(idLab=7)
    return render(request,'recursos.html',{
        'recursos':recursos, 'recursos2': recursos2, 'recursos3':recursos3,'recursos4':recursos4,
        'recursos5':recursos5, 'recursos6':recursos6, 'recursos7':recursos7})


@login_required
#TODO Make reservations to work
def reservar(request):
    if request.method=='GET':
        return render(request, 'reservar_test.html', {
            'form':ReservaForm
        })
    else:
        try:
            reserva=ReservaForm(request.POST)
            nueva_reserva=reserva.save(commit=False)
            nueva_reserva.idUsuario=request.user
            nueva_reserva.save()
            print (request.POST)
            return redirect('calendario')
        except ValueError:
            return render(request, 'reservar_test', {
                'form':ReservaForm,
                'error': 'Algun dato es invalido'
            })

@login_required
#TODO This needs the first system to work
def signoff(request):
    logout(request)
    return redirect('signin')
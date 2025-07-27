from django.shortcuts import render, redirect
from django.contrib.auth import authenticate, login, logout
from django.contrib.auth.decorators import login_required
from django.contrib.auth.models import User
from .models import Recurso, Laboratorio, Usuario
from django.utils.timezone import localtime, localdate

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
    recursos=Recurso.objects.all()
    laboratorio=Laboratorio.objects.all()
    return render(request,'recursos.php',{'recursos':recursos})

@login_required
#TODO Make reservations to work
def reservar(request):
    if request.method=='GET':
        return render(request, 'reservar.php')
    else:
        try:
            reserva=request.POST
            print (request.POST)
            return redirect('calendario')
        except ValueError:
            return render(request, 'reservar.php', {
                'error': 'Algun dato es invalido'
            })

@login_required
#TODO This needs the first system to work
def signoff(request):
    logout(request)
    return redirect('signin')
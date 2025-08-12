"""
URL configuration for SGL project.

The `urlpatterns` list routes URLs to views. For more information please see:
    https://docs.djangoproject.com/en/5.2/topics/http/urls/
Examples:
Function views
    1. Add an import:  from my_app import views
    2. Add a URL to urlpatterns:  path('', views.home, name='home')
Class-based views
    1. Add an import:  from other_app.views import Home
    2. Add a URL to urlpatterns:  path('', Home.as_view(), name='home')
Including another URLconf
    1. Import the include() function: from django.urls import include, path
    2. Add a URL to urlpatterns:  path('blog/', include('blog.urls'))
"""
from django.contrib import admin
from django.urls import path
from sistemaGestion import views
from . import settings
from sistemaGestion import static

urlpatterns = [
    path('admin/', admin.site.urls),
    path('',views.signin, name='signin'),
    path('reservas/',views.calendario,name='calendario'),
    path('recursos/',views.recursos, name='recursos'),
    path('reservar/',views.reservar, name='reservar'),
    path('logoff/',views.signoff,name='logout'),
    path('mis-reservas/',views.mis_reservas,name='mis-reservas'),
    path('reservas/admin/', views.admin_reservas,name='reservas-admin'),
    path('mail/', views.email_test),
    path('sidebar/',views.sidebar, name='sidebar'),
    path('reservas/<int:idReserva>/delete', views.borrar_mi_reserva, name='borrar-mi-reserva'),
    path('reservas/admin/<int:id>/delete', views.borrar_reserva_admin, name='borrar-reserva-admin'),
    path('usuarios/admin', views.admin_usuarios, name='usuarios-admin'),
    path('mantenimientos/', views.mantenimientos, name='mantenimientos'),
    path('recurso/add/',views.addRecurso, name="add-recurso"),
    path('usuarios/admin/add/',views.addUsuario, name='add-usuario'),
    path('mantenimientos/add/',views.addMantenimiento, name='add-mantenimiento'),
    path('usuarios/admin/<str:user>/delete/',views.borrar_usuarios, name='borrar-usuarios'),
    path('mantenimientos/<int:idMantenimiento>/delete/',views.borrar_mantenimientos, name='borrar-mantenimientos'),
    path('recursos/<int:idRecurso>/delete',views.borrar_recursos,name='borrar-recursos')
] + static(settings.STATIC_URL, document_root=settings.STATIC_ROOT)


from django.forms import ModelForm
from . import models

class ReservaForm(ModelForm):
    class Meta:
        model = models.Reserva
        fields=['inicio_reserva', 'fin_reserva']
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reserva Ambiente</title>
</head>
<body>
    <div style="max-width: 800px;text-align:center;color: #474798;font-family: monospace;">
    <u><h2>Reserva: {{$reserva->ambiente->nombre}}</h2></u>
    <h3 >Comunicarles que la {{$reserva->ambiente->nombre}} estará ocupada por motivo de "{{$reserva->motivo}}" con el siguiente cronograma programado.
Por favor tomar en cuenta la fecha y horario para no crear ningún contratiempo.</h3>
    <p><b>DÍA:</b> {{ date("d-m-Y", strtotime($reserva->fecha)) }} <br>
    <b>HORAS:</b> {{$reserva->hora_inicio}} a {{$reserva->hora_fin}} <br>
    <b>Usuario:</b> {{$reserva->user->name}} <br>
    </p>
    </div>
    
</body>
</html>

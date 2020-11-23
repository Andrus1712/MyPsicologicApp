<!DOCTYPE html>
<html>

<head>
    <title>Reporte de comportamientos</title>
    <style>
        table {
            border-collapse: collapse;
            margin: auto;
            font-family: 'Montserrat', sans-serif;
            font-style: normal;
            font-weight: normal;
            src: url('/fonts/Montserrat/Montserrat-Regular.ttf') format('truetype');
        }

        .verticalTableHeader {
            text-align: center;
            white-space: nowrap;
            transform-origin: 50% 50%;
            transform: rotate(90deg);
        }

        .verticalTableHeader:before {
            content: '';
            padding-top: 110%;
            /* takes width as reference, + 10% for faking some extra padding */
            display: inline-block;
            vertical-align: middle;
        }

        small {
            font-size: 0.7em;
        }
    </style>


</head>

<body>
    
    <table style="width: 100%;">
        <tr>
          {{-- <td align="left"><img src="{{ public_path('/img/log.png')}}" width="140"></td> --}}
          <td align="left"><img src="http://toolpsico.codet-colombia.com/img/logoreporte.png" width="140"></td>
        </tr>
    </table>

    <br>
  
    <h4 style="text-align: center">REPORTE DE CASOS DE DEPRESION Y AGRESIVIDAD QUE AFECTAN LA CONVIVENCIA ESCOLAR</h3>
    <br>
    <table border="1">
        <tr>
            <td align="center" colspan="8">
                <strong>
                    <span style="font-size: 0.8em;">REPORTE DE CASOS</span>
                </strong>
            </td>
        </tr>
        <tr>
            <td colspan="6">
                <strong style="margin-left: 10px;">
                    INSTITUCIÓN EDUCATIVA: LA RIBERA
                </strong>
            </td>

            <td colspan="2">
                <strong style="margin-left: 10px;">
                    FECHA DEL REPORTE: {{$modelo['fecha']}}
                </strong>
            </td>
        </tr>

        <tr>
            <td rowspan="2" align="center">
                <strong>
                    <small>
                        ID
                    </small>
                </strong>
            </td>

            <td rowspan="2" align="center" style="width: 10%;">
                <strong>
                    <small>
                        FECHA
                    </small>
                </strong>
            </td>

            <td rowspan="2" align="center">
                <strong>
                    <small>
                        CASO PRESENTADO
                    </small>
                </strong>
            </td>
            <td rowspan="2" align="center">
                <strong>
                    <small>
                        CARACTERISTICAS
                    </small>
                </strong>
            </td>
            <td rowspan="2" align="center">
                <strong>
                    <small>
                        ESTRATEGIA(S) UTILIZADA
                    </small>
                </strong>
            </td>
            <td align="center" rowspan="2">
                <strong>
                    <small>REMITIDO</small>
                </strong>
            </td>
            <td rowspan="2" style="width: 20%;" align="center">
                <strong>
                    <small>
                        ENTIDAD A LA QUE ES REMITIDO
                    </small>
                </strong>

            </td>
            <td align="center" style="width: 20%;">
                <strong>
                    <small>
                        ESTADO DE LA ATENCION
                    </small>
                </strong>
            </td>
        </tr>
        <tr>
            <td align="center">
                <table style="width: 100%;">
                    <tr>
                        <td rowspan="1" align="center">
                            <small>
                                Solucionado
                            </small>
                        </td>
                        <td rowspan="1" align="center">
                            <small>
                                Incumplido
                            </small>
                        </td>
                        <td rowspan="1" align="center">
                            <small>
                                En espera
                            </small>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        @foreach ($modelo['data'] as $item)
        <tr>
            <td align="center">{{$item->id}}</td>
            <td align="center">{{$item->fecha}}</td>
            <td align="center">{{$item->caso}}</td>
            <td align="center"> {{$item->descripcion}}</td>
            <td align="center"> {{$item->solucion}}</td>
            <td align="center"> {{$item->remitido == null? 'NO' : 'SI'}}</td>
            <td align="center"> {{$item->remitido == null? ' ' : $item->remitido}}</td>
            <td align="center">
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 33%; text-align: center;">{{$item->estado == 'Solucionado' ? 'X' : '&emsp;'}}</td>
                        <td style="width: 33%; text-align: center;">{{$item->estado == 'Incumplida' ? 'X' : '&emsp;'}}</td>
                        <td style="width: 33%; text-align: center;">{{$item->estado == 'En espera' ? 'X' : '&emsp;'}}</td>
                    </tr>
                </table>
            </td>
        </tr>
        @endforeach
    </table>
            
    <div style="page-break-after:always;"></div>

    <table style="width: 100%;">
        <tr>
          {{-- <td align="left"><img src="{{ public_path('/img/log.png')}}" width="140"></td> --}}
          <td align="left"><img src="http://toolpsico.codet-colombia.com/img/logoreporte.png" width="140"></td>
        </tr>
    </table>

    <br>
    <table>
      <tr>
        <td>
            
            <br>
          <br>
          <br>
          <p style="text-align: justify">
            Nota: Este formato es generado por la plataforma ToolPsico a la fecha de {{$modelo['fechaFormat'] }}, con
            el consentimiento de los directivos de la institucion educvativa la Ribera tomando como datos la informacion
            de los estudiantes registrados en el sistema. 
            
            <P>Esta informacion solo es manipulada por la psicoorientadora y algunos directivos de la institucion.</P>
          </p>
          <br>
          <br>
          <br>
          <p>
            Cordial saludo,
          </p>
          <br>
          <br>
          <br>
          @foreach ($modelo['psi'] as $item)

          @endforeach
          <p>
            {{$item->psicologo}}<br>
            {{$item->id}} <br>
            Tel: {{$item->telefono}} <br>
            e-mail: {{$item->correo}} <br>
          </p>
        </td>
      </tr>
    </table>
    
    
</body>

</html>
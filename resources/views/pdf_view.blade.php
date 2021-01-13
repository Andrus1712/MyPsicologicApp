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
            {{-- <td align="left"><img src="{{ public_path('/img/log.png') }}"
                    width="140"></td> --}}
            <td align="left"><img src="http://toolpsico.codet-colombia.com/img/logoreporte.png" width="140"></td>
        </tr>
    </table>

    <br>

    <h4 style="text-align: center">REPORTE DE CASOS QUE AFECTAN LA CONVIVENCIA ESCOLAR</h3>
        <p>Reporte general del sistema</p>
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
                        FECHA DEL REPORTE: {{ $comportamientos['fecha'] }}

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
                            SITUACIONES QUE AFECTAN LA CONVIVENCIA ESCOLAR
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
                            CARACTERISTICA DEL CASO
                        </small>
                    </strong>
                </td>
                <td rowspan="2" style="width: 20%;" align="center">
                    <strong>
                        <small>
                            ESTRATEGIA UTILIZADA PARA LA ATENCIÓN DEL CASO
                        </small>
                    </strong>

                </td>
                <td align="center">
                    <strong>
                        <small>
                            ESTADO DE ACTIVIDAD
                        </small>
                    </strong>
                </td>
            </tr>
            <tr>
                <td>
                    <table style="width: 100%;">
                        <tr>
                            <td align="center" style="width: 33%;">CM</td>
                            <td align="center" style="width: 33%;">IC</td>
                            <td align="center" style="width: 33%;">EE</td>
                        </tr>
                    </table>
                </td>
            </tr>
            @foreach ($comportamientos['data'] as $item)
                <tr>
                    <td align="center">CMP{{ $item->id }}</td>
                    <td align="center">{{ $item->fecha }}</td>
                    <td align="center">{{ $item->titulo }}</td>
                    <td align="center"> {{ $item->casos }}</td>
                    <td align="center"> {{ $item->caracteristicas }}</td>
                    <td align="center"> {{ $item->estrategia == null ? 'NaN' : $item->estrategia }}</td>
                    <td align="center">
                        <table style="width: 100%;">
                            <tr>
                                @if ($item->estado != null)
                                    <td style="width: 33%; text-align: center;">
                                        {{ $item->estado == 1 ? 'X' : '&emsp;' }}
                                    </td>
                                    <td style="width: 33%; text-align: center;">
                                        {{ $item->estado == 2 ? 'X' : '&emsp;' }}
                                    </td>
                                    <td style="width: 33%; text-align: center;">
                                        {{ $item->estado == 0 ? 'X' : '&emsp;' }}
                                    </td>
                                @endif
                            </tr>
                        </table>
                    </td>
                </tr>
            @endforeach
        </table>
        <span>Nota: El estado de la actividad es de tres tipos, CM: cumplida; IC: incumplida; EE: en espera</span>
        <br>
        <br>
        <br>
        <br>

        <div id="chartReport"></div>

        <table border="1" style="width: 70%;">
            <tr>
                <td colspan="2" align="center">
                    <strong>
                        <span style="font-size: 0.8em;">REPORTE DE NUMERO DE CASOS</span>
                    </strong>
                </td>
            </tr>
            <tr>
                <td colspan="1">
                    <strong style="margin-left: 10px;">
                        INSTITUCIÓN EDUCATIVA: LA RIBERA
                    </strong>
                </td>
                <td colspan="1">
                    <strong style="margin-left: 10px;">
                        FECHA DEL REPORTE: {{ $comportamientos['fecha'] }}

                    </strong>
                </td>
            </tr>
            <tr>
                <td rowspan="1" align="center">
                    <strong>
                        <small>
                            SITUACIONES QUE AFECTAN LA CONVIVENCIA ESCOLAR
                        </small>
                    </strong>
                </td>
                <td rowspan="1" align="center" style="width: 35%;">
                    <strong>
                        <small>
                            CANTIDAD DE CASOS PRESENTADOS
                        </small>
                    </strong>
                </td>
            </tr>
            @foreach ($comportamientos['count'] as $item)
                <tr>
                    <td>{{ $item->titulo }}</td>
                    <td align="center"> {{ $item->cantidad }} </td>
                </tr>
            @endforeach
        </table>


        <div style="page-break-after:always;"></div>

        <table style="width: 100%;">
            <tr>
                <td align="left"><img src="{{ public_path('/img/log.png') }}" width="140"></td>
                <td align="left"><img src="http://toolpsico.codet-colombia.com/img/logoreporte.png" width="130"></td>
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
                        Nota: Este formato es generado por la plataforma ToolPsico a la fecha de
                        {{ $comportamientos['fechaFormat'] }}, con

                        el consentimiento de los directivos de la institucion educvativa la Ribera tomando como datos la
                        informacion
                        de los estudiantes registrados en el sistema.

                    <P>Esta informacion solo es manipulada por la psicoorientadora y algunos directivos de la
                        institucion.</P>
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
                    {{-- @foreach ($comportamientos['psi'] as $item)

                    @endforeach
                    <p>
                        {{ $item->psicologo }}<br>
                        {{ $item->id }} <br>
                        Tel: {{ $item->telefono }} <br>
                        e-mail: {{ $item->correo }} <br>
                    </p> --}}
                </td>
            </tr>
        </table>


</body>

</html>

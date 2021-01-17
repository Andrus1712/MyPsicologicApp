<!DOCTYPE html>
<html>

<head>
    <title>Reporte de comportamientos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicons -->
    <link href="../template/img/favicon.png" rel="icon">
    <link href="../template/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css">

    <style>
        .page-break {
            page-break-after: always;
        }

    </style>

</head>

<body onload="init()">

    <div class="container">

        <div class="row">
            <table style="width: 100%;">
                <tr>
                    <td align="left"><img src="http://toolpsico.codet-colombia.com/img/logoreporte.png" width="140">
                    </td>
                </tr>
            </table>
            <h4 style="text-align: center">REPORTE DE CASOS QUE AFECTAN LA CONVIVENCIA ESCOLAR</h3>
                <br>

                <table class="table table-bordered">
                    <tr>
                        <td align="center" colspan="7">
                            <strong>
                                <span style="font-size: 0.8em;">REPORTE DE CASOS</span>
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <strong style="margin-left: 10px;">
                                INSTITUCIÓN EDUCATIVA: LA RIBERA
                            </strong>
                        </td>

                        <td colspan="2">
                            <strong style="margin-left: 10px;">
                                FECHA: {{ $fecha_hoy }}

                            </strong>
                        </td>
                    </tr>

                    <tr>
                        <td rowspan="2" align="center" style="width: 10%;">
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
                        <td rowspan="2" align="center" style="width: 15%;">
                            <strong>
                                <small>
                                    CASO PRESENTADO
                                </small>
                            </strong>
                        </td>
                        <td rowspan="2" align="center" style="width: 15%;">
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

                    @foreach ($consulta as $item)
                        <tr>
                            <td align="center">CMP-{{ $item->id }}</td>
                            <td align="center">{{ $item->fecha }}</td>
                            <td align="center">{{ $item->titulo }}</td>
                            <td align="center"> {{ $item->casos }} </td>
                            <td align="center"> {{ $item->caracteristicas }} </td>
                            <td align="center"> {{ $item->estrategia == null ? 'No establecida' : $item->estrategia }}
                            </td>
                            <td align="center">
                                @if ($item->estado != '')
                                    <table style="width: 100%;">
                                        <tr>
                                            <td style="width: 33%; text-align: center;">
                                                {{ $item->estado == 1 ? 'X' : '&emsp;' }}
                                            </td>
                                            <td style="width: 33%; text-align: center;">
                                                {{ $item->estado == 2 ? 'X' : '&emsp;' }}
                                            </td>
                                            <td style="width: 33%; text-align: center;">
                                                {{ $item->estado == 3 ? 'X' : '&emsp;' }}
                                            </td>
                                        </tr>
                                    </table>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                </table>
                <span>Nota: El estado de la actividad es de tres tipos, CM: cumplida; IC: incumplida; EE: en
                    espera</span>
        </div>

        <div class="page-break"></div>

        <div class="row">
            <table style="width: 100%;">
                <tr>
                    <td align="left"><img src="http://toolpsico.codet-colombia.com/img/logoreporte.png" width="140">
                    </td>
                </tr>
            </table>

            <h4 style="text-align: center">CONTEO DE CASOS QUE AFECTAN LA CONVIVENCIA ESCOLAR</h4>
            <br>

            <div class="col-xm-6 col-sm-6 col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <td align="center" colspan="2">
                            <strong>
                                <span style="font-size: 0.8em;">REPORTE DE CONDUCTAS</span>
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong style="margin-left: 10px;">
                                INSTITUCIÓN EDUCATIVA: LA RIBERA
                            </strong>
                        </td>

                        <td>
                            <strong style="margin-left: 10px;">
                                FECHA: {{ $fecha_hoy }}

                            </strong>
                        </td>
                    </tr>

                    <tr>
                        <td align="center">
                            <strong>
                                <small>
                                    CASO PRESENTADO
                                </small>
                            </strong>
                        </td>

                        <td align="center">
                            <strong>
                                <small>
                                    CANTIDAD
                                </small>
                            </strong>
                        </td>

                    </tr>

                    @foreach ($conteo as $item)
                        <tr>
                            <td>{{ $item->titulo }}</td>
                            <td>{{ $item->cantidad }}</td>
                        </tr>
                    @endforeach

                    <tr>
                        <td>
                            <strong>
                                Total
                            </strong>
                        </td>

                        <td>
                            <strong>
                                {{ $total }}
                            </strong>
                        </td>
                    </tr>

                </table>
            </div>

            <div class="col-xm-6 col-sm-6 col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <td align="center" colspan="3">
                            <strong>
                                <span style="font-size: 0.8em;">REPORTE DE CONDUCTAS POR GENERO</span>
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <strong style="margin-left: 10px;">
                                INSTITUCIÓN EDUCATIVA: LA RIBERA
                            </strong>
                        </td>

                        <td colspan="1">
                            <strong style="margin-left: 10px;">
                                FECHA: {{ $fecha_hoy }}
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2" align="center" style="width: 40%">
                            <strong>
                                <small>
                                    CASO PRESENTADO
                                </small>
                            </strong>
                        </td>

                        <td rowspan="1" align="center" style="width: 30%">
                            <strong>
                                <small>
                                    GENERO
                                </small>
                            </strong>
                        </td>

                        <td rowspan="2" align="center">
                            <strong>
                                <small>
                                    Total
                                </small>
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="1">
                            <table style="width: 100%;">
                                <tr>
                                    <td align="center" style="width: 33%;">Masculino</td>
                                    <td align="center" style="width: 33%;">Femenino</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    @foreach ($consulta2 as $item)
                        <tr>
                            <td align="center">{{ $item->titulo }}</td>
                            <td align="center">
                                <table style="width: 100%;">
                                    <tr>
                                        <td style="width: 33%; text-align: center;">
                                            {{ $item->Masculino }}
                                        </td>
                                        <td style="width: 33%; text-align: center;">
                                            {{ $item->Femenino }}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td align="center">{{ $item->total }}</td>
                        </tr>
                    @endforeach

                </table>

            </div>
        </div>


        <div class="page-break"></div>
        <div class="row">
            <img src="./documentosPSI/graph/foto.jpg" width="50%">
        </div>

    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>

</html>

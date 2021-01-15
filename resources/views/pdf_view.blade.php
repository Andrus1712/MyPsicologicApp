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

<body>

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
                                FECHA DEL REPORTE: {{ $fecha_hoy }}

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

                    @foreach ($consulta as $item)
                        <tr>
                            <td>CMP-{{ $item->id }}</td>
                            <td>{{ $item->fecha }}</td>
                            <td>{{ $item->titulo }}</td>
                            <td align="center"> {{ $item->casos }} </td>
                            <td align="center"> {{ $item->caracteristicas }} </td>
                            <td align="center"> {{ $item->estrategia }} </td>
                            <td align="center">
                                <table style="width: 100%;">
                                    <tr>
                                        <td style="width: 33%; text-align: center;">
                                            {{ $item->estado == 1 ? 'X' : '&emsp;' }}
                                        </td>
                                        <td style="width: 33%; text-align: center;">
                                            {{ $item->estado == 2 ? 'X' : '&emsp;' }}
                                        </td>
                                        <td style="width: 33%; text-align: center;">
                                            {{ $item->estado == 0 ? 'X' : '&emsp;' }}
                                        </td>
                                    </tr>
                                </table>
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
            <h4 style="text-align: center">Conteo de casos</h3>
                <br>

                <table class="table table-sm table-bordered">
                    <tr>
                        <td align="center" colspan="2">
                            <strong>
                                <span style="font-size: 0.8em;">REPORTE DE CASOS</span>
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <td >
                            <strong style="margin-left: 10px;">
                                INSTITUCIÓN EDUCATIVA: LA RIBERA
                            </strong>
                        </td>

                        <td >
                            <strong style="margin-left: 10px;">
                                FECHA DEL REPORTE: {{ $fecha_hoy }}

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

                        <td >
                            <strong>
                                {{ $total }}
                            </strong>
                        </td>
                    </tr>

                </table>
        </div>
    </div>




    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>

</html>

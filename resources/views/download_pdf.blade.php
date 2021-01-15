<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Toolpisco</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- Favicons -->
    <link href="../template/img/favicon.png" rel="icon">
    <link href="../template/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
        integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>


    <div class="container">

        <div class="row">
            <div class="col-lg-10">
                <!-- Just an image -->
                <nav class="navbar navbar-light" style="padding: 5px 10px;">
                    <a href="#"><img style="width: 200px;" src="img/logoreporte.png"></a>
                </nav>

                <div id="report-html">
                    <h4 style="text-align: center">REPORTE DE CASOS QUE AFECTAN LA CONVIVENCIA ESCOLAR</h4>

                    <table class="" border="1">
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
                        {{-- @foreach ($comportamientos['data'] as $item)
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
                        @endforeach --}}
                    </table>
                    <span>Nota: El estado de la actividad es de tres tipos, CM: cumplida; IC: incumplida; EE: en
                        espera</span>

                </div>

                <div id="chart_div"></div>

                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                <script type="text/javascript">

                    // Load the Visualization API and the corechart package.
                    google.charts.load('current', { 'packages': ['corechart'] });

                    // Set a callback to run when the Google Visualization API is loaded.
                    google.charts.setOnLoadCallback(drawChart);

                    // Callback that creates and populates a data table,
                    // instantiates the pie chart, passes in the data and
                    // draws it.
                    function drawChart() {

                        // Create the data table.
                        var data = new google.visualization.DataTable();
                        data.addColumn('string', 'Topping');
                        data.addColumn('number', 'Slices');
                        data.addRows([
                            ['Mushrooms', 3],
                            ['Onions', 1],
                            ['Olives', 1],
                            ['Zucchini', 1],
                            ['Pepperoni', 2]
                        ]);

                        // Set chart options
                        var options = {
                            'title': 'How Much Pizza I Ate Last Night',
                            'width': 400,
                            'height': 300
                        };

                        // Instantiate and draw our chart, passing in some options.
                        let char_div = document.getElementById('chart_div');
                        let chart = new google.visualization.PieChart(char_div);

                        google.visualization.events.addListener(chart, 'ready', function (){
                            char_div.innerHTML = ' <img scr="'+chart.getImageURI() + '"> ';
                        })
                        chart.draw(data, options);
                    }
                </script>


            </div>
        </div>
    </div>





    @include('layouts.scripts')
    
    {{-- <script src="js/reportes/main.js"></script> --}}
</body>

</html>

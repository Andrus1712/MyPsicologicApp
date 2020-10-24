var modal = $("#modal-modelo-seguimiento")
var AllRegister = []

var permisos = []

$(document).ready(function () {
    Reload()
    LoadChartEstado();
    LoadCharClasificacion();


    $('#modelo-table').on('click', '[id^=Btn_delete_]', function () {
        var id = $(this).attr('data-id')

        swal({
            title: "¿Realmente deseas eliminar el acudiente?",
            text: "Ten en cuenta que eliminaras toda su información del sistema",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Si, eliminar",
            closeOnConfirm: false
        },
            function () {
                $.ajax({
                    url: "/api/modelo_seguimientos/" + id,
                    type: "DELETE",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                })
                    .done(function () {
                        swal("Eliminado!", "Se ha eliminado el acudiente", "success");
                        Reload()
                        LoadChartEstado();
                        LoadCharClasificacion();
                    })
                    .fail(function () {
                        swal("Error!", "Ha ocurrido un error", "error");
                    });

            });
    })

    $("#modelo-table").on('click', '[id^=Btn_Edit_]', function () {

        var id = $(this).attr('data-id')
        var filtro = AllRegister.filter(f => f.id == id);

        if (filtro.length != 0) {
            modal.modal('show');
            Modal()

            $("#save").text("Actualizar")
            $("#save").attr("id", 'update')

            $("#fecha").val(filtro[0].fecha)
            $("#nombres").val(filtro[0].nombre)
            $("#estamento").val(filtro[0].estamento)
            $("#descripcion").val(filtro[0].descripcion)
            $("#remitido").val(filtro[0].remitido)
            $("#medio").val(filtro[0].medio_comunicacion)
            $("#clasificacion").val(filtro[0].clasificacion_caso_presentado)
            $("#solucion").val(filtro[0].solucion)
            $('#estado').val(filtro[0].estado)

            $('#update').on('click', function () {
                var fecha = $('#fecha').val(),
                    nombre = $('#nombres').val(),
                    estamento = $('#estamento').val(),
                    descripcion = $('#descripcion').val(),
                    remitido = $('#remitido').val(),
                    medio_comunicacion = $('#medio').val(),
                    clasificacion_caso_presentado = $('#clasificacion').val(),
                    solucion = $('#solucion').val(),
                    estado = $('#estado').val();

                if (fecha == '' || nombre == '' || estamento == '' || descripcion == '' || remitido == '' || medio_comunicacion == '' || clasificacion_caso_presentado == '' || solucion == '' || estado == '') {
                    toastr.warning("Complete todos los campos")
                }
                else {
                    $.ajax({
                        url: '/api/modelo_seguimientos/' + id,
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        type: 'PUT',
                        data: {
                            fecha: fecha,
                            nombre: nombre,
                            estamento: estamento,
                            descripcion: descripcion,
                            remitido: remitido,
                            medio_comunicacion: medio_comunicacion,
                            clasificacion_caso_presentado: clasificacion_caso_presentado,
                            solucion: solucion,
                            estado: estado
                        },
                    })
                        .done(function () {
                            setTimeout(function () { modal.modal("hide") }, 600);
                            toastr.info("información actualizada");
                            Reload()
                            LoadChartEstado();
                            LoadCharClasificacion();
                        })
                        .fail(function () {
                            toastr.error("Ha ocurrido un error");
                        })
                        .always(function () {
                            $("#update").addClass("disabled");
                        });
                }
            })


        }
    })

    $('#add-seguiento').on('click', function () {
        modal.modal('show')
        Modal()

        $('#save').on('click', function () {
            var fecha = $('#fecha').val(),
                nombre = $('#nombres').val(),
                estamento = $('#estamento').val(),
                descripcion = $('#descripcion').val(),
                remitido = $('#remitido').val(),
                medio_comunicacion = $('#medio').val(),
                clasificacion_caso_presentado = $('#clasificacion').val(),
                solucion = $('#solucion').val(),
                estado = $('#estado').val();

            if (fecha == '' || nombre == '', estamento == '', descripcion == '', remitido == '', medio == '', clasificacion == '', solucion == '', estado == '') {
                toastr.warning("Complete todos los campos")
            } else {
                $.ajax({
                    url: '/api/modelo_seguimientos',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    data: {
                        fecha: fecha,
                        nombre: nombre,
                        estamento: estamento,
                        medio_comunicacion: medio_comunicacion,
                        clasificacion_caso_presentado: clasificacion_caso_presentado,
                        descripcion: descripcion,
                        solucion: solucion,
                        remitido: remitido,
                        estado: estado
                    },
                })
                    .done(function () {
                        toastr.success("Datos guardados");
                        setTimeout(function () { modal.modal("hide") }, 600);
                        Reload()
                        LoadChartEstado();
                        LoadCharClasificacion();
                    })
                    .fail(function () {
                        toastr.error("Ha ocurrido un error");
                    })
                    .always(function () {
                        $("#save").addClass("disabled");
                    });
            }
        })
    })

})

// function data() {

//     $(function () {
//         /* ChartJS
//          * -------
//          * Here we will create a few charts using ChartJS
//          */

//         //--------------
//         //- AREA CHART -
//         //--------------

//         // Get context with jQuery - using jQuery's .get() method.
//         var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
//         // This will get the first returned node in the jQuery collection.
//         var areaChart = new Chart(areaChartCanvas)

//         var areaChartData = {
//             labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
//             datasets: [
//                 {
//                     label: 'Electronics',
//                     fillColor: 'rgba(210, 214, 222, 1)',
//                     strokeColor: 'rgba(210, 214, 222, 1)',
//                     pointColor: 'rgba(210, 214, 222, 1)',
//                     pointStrokeColor: '#c1c7d1',
//                     pointHighlightFill: '#fff',
//                     pointHighlightStroke: 'rgba(220,220,220,1)',
//                     data: [65, 59, 80, 81, 56, 55, 40]
//                 },
//                 {
//                     label: 'Digital Goods',
//                     fillColor: 'rgba(60,141,188,0.9)',
//                     strokeColor: 'rgba(60,141,188,0.8)',
//                     pointColor: '#3b8bba',
//                     pointStrokeColor: 'rgba(60,141,188,1)',
//                     pointHighlightFill: '#fff',
//                     pointHighlightStroke: 'rgba(60,141,188,1)',
//                     data: [28, 48, 40, 19, 86, 27, 90]
//                 }
//             ]
//         }

//         var areaChartOptions = {
//             //Boolean - If we should show the scale at all
//             showScale: true,
//             //Boolean - Whether grid lines are shown across the chart
//             scaleShowGridLines: false,
//             //String - Colour of the grid lines
//             scaleGridLineColor: 'rgba(0,0,0,.05)',
//             //Number - Width of the grid lines
//             scaleGridLineWidth: 1,
//             //Boolean - Whether to show horizontal lines (except X axis)
//             scaleShowHorizontalLines: true,
//             //Boolean - Whether to show vertical lines (except Y axis)
//             scaleShowVerticalLines: true,
//             //Boolean - Whether the line is curved between points
//             bezierCurve: true,
//             //Number - Tension of the bezier curve between points
//             bezierCurveTension: 0.3,
//             //Boolean - Whether to show a dot for each point
//             pointDot: false,
//             //Number - Radius of each point dot in pixels
//             pointDotRadius: 4,
//             //Number - Pixel width of point dot stroke
//             pointDotStrokeWidth: 1,
//             //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
//             pointHitDetectionRadius: 20,
//             //Boolean - Whether to show a stroke for datasets
//             datasetStroke: true,
//             //Number - Pixel width of dataset stroke
//             datasetStrokeWidth: 2,
//             //Boolean - Whether to fill the dataset with a color
//             datasetFill: true,
//             //String - A legend template
//             legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
//             //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
//             maintainAspectRatio: true,
//             //Boolean - whether to make the chart responsive to window resizing
//             responsive: true
//         }

//         //Create the line chart
//         areaChart.Line(areaChartData, areaChartOptions)

//         //-------------
//         //- LINE CHART -
//         //--------------
//         var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
//         var lineChart = new Chart(lineChartCanvas)
//         var lineChartOptions = areaChartOptions
//         lineChartOptions.datasetFill = false
//         lineChart.Line(areaChartData, lineChartOptions)

//         //-------------
//         //- PIE CHART -
//         //-------------
//         // Get context with jQuery - using jQuery's .get() method.
//         var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
//         var pieChart = new Chart(pieChartCanvas)
//         var PieData = [
//             {
//                 value: 700,
//                 color: '#f56954',
//                 highlight: '#f56954',
//                 label: 'Chrome'
//             },
//             {
//                 value: 500,
//                 color: '#00a65a',
//                 highlight: '#00a65a',
//                 label: 'IE'
//             },
//             {
//                 value: 400,
//                 color: '#f39c12',
//                 highlight: '#f39c12',
//                 label: 'FireFox'
//             },
//             {
//                 value: 600,
//                 color: '#00c0ef',
//                 highlight: '#00c0ef',
//                 label: 'Safari'
//             },
//             {
//                 value: 300,
//                 color: '#3c8dbc',
//                 highlight: '#3c8dbc',
//                 label: 'Opera'
//             },
//             {
//                 value: 100,
//                 color: '#d2d6de',
//                 highlight: '#d2d6de',
//                 label: 'Navigator'
//             }
//         ]
//         var pieOptions = {
//             //Boolean - Whether we should show a stroke on each segment
//             segmentShowStroke: true,
//             //String - The colour of each segment stroke
//             segmentStrokeColor: '#fff',
//             //Number - The width of each segment stroke
//             segmentStrokeWidth: 2,
//             //Number - The percentage of the chart that we cut out of the middle
//             percentageInnerCutout: 50, // This is 0 for Pie charts
//             //Number - Amount of animation steps
//             animationSteps: 100,
//             //String - Animation easing effect
//             animationEasing: 'easeOutBounce',
//             //Boolean - Whether we animate the rotation of the Doughnut
//             animateRotate: true,
//             //Boolean - Whether we animate scaling the Doughnut from the centre
//             animateScale: false,
//             //Boolean - whether to make the chart responsive to window resizing
//             responsive: true,
//             // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
//             maintainAspectRatio: true,
//             //String - A legend template
//             legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
//         }
//         //Create pie or douhnut chart
//         // You can switch between pie and douhnut using the method below.
//         pieChart.Doughnut(PieData, pieOptions)

//         //-------------
//         //- BAR CHART -
//         //-------------
//         var barChartCanvas = $('#barChart').get(0).getContext('2d')
//         var barChart = new Chart(barChartCanvas)
//         var barChartData = areaChartData
//         barChartData.datasets[1].fillColor = '#00a65a'
//         barChartData.datasets[1].strokeColor = '#00a65a'
//         barChartData.datasets[1].pointColor = '#00a65a'
//         var barChartOptions = {
//             //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
//             scaleBeginAtZero: true,
//             //Boolean - Whether grid lines are shown across the chart
//             scaleShowGridLines: true,
//             //String - Colour of the grid lines
//             scaleGridLineColor: 'rgba(0,0,0,.05)',
//             //Number - Width of the grid lines
//             scaleGridLineWidth: 1,
//             //Boolean - Whether to show horizontal lines (except X axis)
//             scaleShowHorizontalLines: true,
//             //Boolean - Whether to show vertical lines (except Y axis)
//             scaleShowVerticalLines: true,
//             //Boolean - If there is a stroke on each bar
//             barShowStroke: true,
//             //Number - Pixel width of the bar stroke
//             barStrokeWidth: 2,
//             //Number - Spacing between each of the X value sets
//             barValueSpacing: 5,
//             //Number - Spacing between data sets within X values
//             barDatasetSpacing: 1,
//             //String - A legend template
//             legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
//             //Boolean - whether to make the chart responsive
//             responsive: true,
//             maintainAspectRatio: true
//         }

//         barChartOptions.datasetFill = false
//         barChart.Bar(barChartData, barChartOptions)
//     })
// }

function LoadChartEstado(params) {

    var start = moment().subtract(29, 'days');
    var end = moment();

    var fi;
    var ff;
    function cb(start, end) {
        $('#reportrange1 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        fi = start.format('YYYY-MM-DD');
        ff = end.format('YYYY-MM-DD');

        var pieDataResponse = []
        var cat = []
        let arreglo = [];
        $.ajax({
            url: "/api/getEstados",
            type: "POST",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "JSON",
            data: { fechaInicial: fi, fechaFinal: ff }
        })
            .done(function (response) {
                pieDataResponse = []
                cat = []
                for (var i = 0; i < response.length; i++) {
                    cat.push(
                        response[i].fecha
                    )
                    console.log("fechas | " + response[i].fecha);
                }

                arreglo = [...new Set(cat)];
                // console.log("fechas sin repetir | " + arreglo);
                var contR = 0;
                var contE = 0;
                var contS = 0;
                var vR = []
                var vE = []
                var vS = []
                for (var i = 0; i < arreglo.length; i++) {
                    //console.log(arreglo[i] + "----" + response[i].fecha);
                    for (var j = 0; j < response.length; j++) {
                        if (arreglo[i] == response[j].fecha) {

                            if (response[j].estado == "Remitido") {
                                contR++;
                            } else if (response[j].estado == "En curso") {
                                contE++;
                            } else if (response[j].estado == "Resuelto") {
                                contS++;
                            }
                        }

                    }
                    vR.push(contR)
                    vE.push(contE)
                    vS.push(contS)
                    //console.log(contR + " | " + contE + " | " + contS)

                    contR = 0;
                    contE = 0;
                    contS = 0;

                }
                // console.log(vR)
                // console.log(vE)
                // console.log(vS)

                Highcharts.chart('chartEstamento', {
                    chart: {
                        type: 'column'
                    },
                    navigation: {
                        buttonOptions: {
                            enabled: true
                        }
                    },
                    title: {
                        text: 'Grafico de estados de por fecha'
                    },
                    xAxis: {
                        categories: arreglo
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Total de casos'
                        },
                        stackLabels: {
                            enabled: true,
                            style: {
                                fontWeight: 'bold',
                                color: ( // theme
                                    Highcharts.defaultOptions.title.style &&
                                    Highcharts.defaultOptions.title.style.color
                                ) || 'gray'
                            }
                        }
                    },
                    legend: {
                        align: 'right',
                        x: -30,
                        verticalAlign: 'top',
                        y: 25,
                        floating: true,
                        backgroundColor:
                            Highcharts.defaultOptions.legend.backgroundColor || 'white',
                        borderColor: '#CCC',
                        borderWidth: 1,
                        shadow: false
                    },
                    tooltip: {
                        headerFormat: '<b>{point.x}</b><br/>',
                        pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
                    },
                    plotOptions: {
                        column: {
                            stacking: 'normal',
                            dataLabels: {
                                enabled: true
                            }
                        }
                    },
                    series: [{
                        name: "Remitido",
                        data: vR
                    },
                    {
                        name: "En curso",
                        data: vE
                    },
                    {
                        name: "Resuelto",
                        data: vS
                    }]
                });





                $("#chartEstamento").removeClass('hide');
                if (arreglo.length == 0) {
                    $("#not-chart1").text('No hay datos registrados ')
                    $("#chartEstamento").addClass('hide');
                } else {
                    $("#not-chart1").text('')
                }

            })

            .fail(function () {
                toastr.error("No se han podido cargar los datos")
            });

    }

    $('#reportrange1').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);


}

function LoadCharClasificacion(data) {

    var start = moment().subtract(29, 'days');
    var end = moment();

    var fi;
    var ff;
    function cb(start, end) {
        $('#reportrange2 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        fi = start.format('YYYY-MM-DD');
        ff = end.format('YYYY-MM-DD');

        var pieDataResponse = []
        $.ajax({
            url: "/api/getClasificacion",
            type: "POST",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "JSON",
            data: { fechaInicial: fi, fechaFinal: ff }
        })
            .done(function (response) {
                pieDataResponse = []
                for (var i = 0; i < response.length; i++) {
                    pieDataResponse.push(
                        {
                            name: response[i].clasificacion,
                            y: response[i].cantidad
                        }
                    )
                }

                Highcharts.chart('chartClasificacion', {
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie'
                    },
                    title: {
                        text: 'Grafico de clasificaciones de los casos'
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.y:.f}</b>'
                    },
                    accessibility: {
                        point: {
                            valueSuffix: ' casos'
                        }
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '<b>{point.name}</b>: {point.y:f} caso(s)'
                            },
                            showInLegend: true
                        }
                    },
                    series: [{
                        name: 'Casos',
                        colorByPoint: true,
                        data: pieDataResponse
                    }]
                });





                $("#chartClasificacion").removeClass('hide');
                if (pieDataResponse.length == 0) {
                    $("#not-chart2").text('No hay datos registrados ')
                    $("#chartClasificacion").addClass('hide');
                } else {
                    $("#not-chart2").text('')
                }

            })

            .fail(function () {
                toastr.error("No se han podido cargar los datos")
            });
    }


    $('#reportrange2').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);

}

function Modal() {
    modal.find('.modal-content').empty().append(`
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Registro de atencion personalizada y gestion institucional</h4>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-6">
    
                        <div class="form-group">
                            <label>Nombre completo: </label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-users"></i>
                                </div>
                                <input type="text" class="form-control" placeholder="Escriba el nombre completo de la persona" id="nombres">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Fecha del registro: </label>
                            <div class="input-group date" id="timepicker">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="fecha" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Estamento: </label>
                            <select class="form-control" id="estamento" name="state">
                                <option value="">Seleccione</option>
                                <option value="Padre de familia">Padre de familia</option>
                                <option value="Madre de familia">Madre de familia</option>
                                <option value="Acudiente">Acudiente</option>
                                <option value="Docente">Docente</option>
                                <option value="Administrativo<">Administrativo</option>
                                <option value="Practicante">Practicante</option>
                                <option value="Psicoorientador">Psicoorientador</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Descripcion del caso: </label>
                            <textarea id="descripcion" class="form-control" style="resize: vertical;" rows="3" placeholder="Escriba aqui la descripcion del caso ..."></textarea>
                        </div>

                        <div class="form-group">
                        <spam class="fa fa-info"></span>
                            <label>Remitido a: </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" placeholder="Escriba el nombre de la persona a quien es remitido" id="remitido">
                            </div>
                        </div>
    
                    </div>
    
                    <div class="col-md-6">
    
                        <div class="form-group">
                            <label>Medio de comunicacion: </label>
                            <select class="form-control" id="medio" name="state">
                                <option value="">Seleccione</option>
                                <option value="WhatApp">WhatApp</option>
                                <option value="Llamada">Llamada</option>
                                <option value="Video Llamada">Video Llamada</option>
                                <option value="Correo">Correo</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
    
                        <div class="form-group">
                            <label>Clasificacion del caso presentado: </label>
                            <select class="form-control" id="clasificacion" name="state">
                                <option value="">Selecione una opcion</option>
                                <option value="Queja contra estudiante">Queja contra estudiante</option>
                                <option value="Queja contra docente">Queja contra docente</option>
                                <option value="Queja contra directivo">Queja contra directivo</option>
                                <option value="Queja contra administrativo">Queja contra administrativo</option>
                                <option value="Queja contra vecino">Queja contra vecino</option>
                                <option value="Robo">Robo</option>
                                <option value="Agresividad">Agresividad</option>
                                <option value="Depresion">Depresion</option>
                                <option value="Abuso">Abuso</option>
                                <option value="Violacion">Violacion</option>
                                <option value="Embarazo">Embarazo</option>
                                <option value="Violencia">Violencia</option>
                                <option value="Bullying">Bullying</option>
                                <option value="Sexting">Sexting</option>
                                <option value="ideacion suicida">ideacion suicida</option>
                                <option value="Intento suicida">Intento suicida</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
    
                        <div class="form-group">
                            <label>Solucion dada: </label>
                            <textarea id="solucion" class="form-control" style="resize: vertical;" rows="3" placeholder="Escriba aqui la solucion dada ..."></textarea>
                        </div>

                        <div class="form-group">
                            <label>Estado de la gestion: </label>
                            <select class="form-control" id="estado" name="state">
                                <option value="">Seleccione</option>
                                <option value="Remitido">Remitido</option>
                                <option value="Resuelto">Resuelto</option>
                                <option value="En curso">En curso</option>
                            </select>
                        </div>
    
                    </div>

                </div>
    
            </div>
    
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="save">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        `)
    $("#timepicker").datetimepicker({
        format: "YYYY-MM-DD"
    });
}

function Reload() {
    $.ajax({
        url: "/getModeloSeguimiento",
        type: "GET",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        dataType: "JSON",
    })

        .done(function (response) {
            if (response.length != 0) {
                AllRegister = response.modeloSeguimiento;
                permisos = response.permisos;
                DataTable(response.modeloSeguimiento);
            } else {
                $('#modelo-table').dataTable().fnClearTable();
                $('#modelo-table').dataTable().fnDestroy();
                $('#modelo-table thead').empty()
            }
        })

        .fail(function () {
            console.log("error");
        });
}

function DataTable(response) {
    if ($.fn.DataTable.isDataTable('#modelo-table')) {
        $('#modelo-table').dataTable().fnClearTable();
        $('#modelo-table').dataTable().fnDestroy();
        $('#modelo-table thead').empty()
    }
    else {
        $('#modelo-table thead').empty()
    }

    if (response.length != 0) {
        let my_columns = []
        $.each(response[0], function (key, value) {
            var my_item = {};
            // my_item.class = "filter_C";
            my_item.data = key;
            if (key == 'created_at') {

                my_item.title = 'Acción';

                my_item.render = function (data, type, row) {
                    return `<div align="center">

                                <div class="btn-group btn-group-circle btn-group-solid" align="center">

                                    <a data-id=${row.id} id="Btn_Edit_${row.id}" class='btn btn-circle btn-sm btn-primary'>
                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                    </a>

                                    <a data-id=${row.id} id="Btn_delete_${row.id}" class='btn btn-circle btn-sm btn-danger'>
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a> 
                                </div>
                            </div>`
                }
                my_columns.push(my_item);

            }
            else if (key == 'id') {

                my_item.title = '#';

                my_item.render = function (data, type, row) {
                    return `  <div> 
                                ${row.id}
                            </div>`
                }
                my_columns.push(my_item);


            }

            else if (key == 'fecha') {

                my_item.title = 'Fecha';

                my_item.render = function (data, type, row) {
                    return `  <div> 
                                ${row.fecha}
                            </div>`
                }
                my_columns.push(my_item);
            }

            else if (key == 'nombre') {

                my_item.title = 'Nombre';

                my_item.render = function (data, type, row) {
                    return `<div>
                                ${row.nombre} 
                            </div>`
                }
                my_columns.push(my_item);
            }

            else if (key == 'estamento') {

                my_item.title = 'Estamento';

                my_item.render = function (data, type, row) {
                    return `<div>
                                ${row.estamento} 
                            </div>`
                }
                my_columns.push(my_item);
            }

            else if (key == 'medio_comunicacion') {

                my_item.title = 'Medio de comunicacion';

                my_item.render = function (data, type, row) {
                    return `<div>
                                ${row.medio_comunicacion} 
                            </div>`
                }
                my_columns.push(my_item);
            }

            else if (key == 'clasificacion_caso_presentado') {

                my_item.title = 'Clasificacion del caso presentado';

                my_item.render = function (data, type, row) {
                    return `<div>
                                ${row.clasificacion_caso_presentado} 
                            </div>`
                }
                my_columns.push(my_item);
            }

            else if (key == 'descripcion') {

                my_item.title = 'Descripcion';

                my_item.render = function (data, type, row) {
                    return `<div>
                                ${row.descripcion} 
                            </div>`
                }
                my_columns.push(my_item);
            }

            else if (key == 'solucion') {

                my_item.title = 'Solucion';

                my_item.render = function (data, type, row) {
                    return `<div>
                                ${row.solucion} 
                            </div>`
                }
                my_columns.push(my_item);
            }

            else if (key == 'remitido') {

                my_item.title = 'Remitido';

                my_item.render = function (data, type, row) {
                    return `<div>
                                ${row.remitido} 
                            </div>`
                }
                my_columns.push(my_item);
            }

            else if (key == 'estado') {

                my_item.title = 'Estado';

                my_item.render = function (data, type, row) {
                    return `<div>
                                ${row.estado} 
                            </div>`
                }
                my_columns.push(my_item);
            }

        })

        $('#modelo-table').DataTable({
            //responsive: true,
            'scrollX': true,
            "destroy": true,
            data: response,
            "columns": my_columns,
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No hay datos registrados",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ modelo",
                "infoEmpty": "No hay modelo de seguimento registrados",
                "infoFiltered": "(Filtrado de _MAX_  modelo)",
                "lengthMenu": "_MENU_ modelo de seguimento",
                "search": "Buscar:",
                "zeroRecords": "No se han encontrado registros"
            },
            responsive: "true",
            dom: 'Bfrtilp',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel"></i> ',
                    titleAttr: 'Exportar a Excel',
                    className: 'btn btn-success',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf"></i> ',
                    titleAttr: 'Exportar a PDF',
                    className: 'btn btn-danger',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i> ',
                    titleAttr: 'Imprimir',
                    className: 'btn btn-info',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                    }
                },
            ],
            "order": [
                [0, 'asc']
            ],

            "columnDefs": [
                { "width": "30%", "targets": 2 },
                { "width": "30%", "targets": 10 }
            ],

            "lengthMenu": [
                [10, 15, 20, -1],
                [10, 15, 20, "Todos"]
            ]
        });


    }

}
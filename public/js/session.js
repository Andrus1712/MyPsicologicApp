
$.ajax({
    url: "/getCountComp",
    type: "GET",
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    dataType: "JSON",
})

.done(function (response) {
    if (response.length > 0) {
        $("#numbercomportaiment").text(response.length)
        $("#numbercomportaiment").removeClass('hide')
    }
})

.fail(function () {
    console.log("error");
});

$.ajax({
    url: "/getCountAct",
    type: "GET",
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    dataType: "JSON",
})

.done(function (response) {
    if (response.length > 0) {
        $("#numberactivities").text(response.length)
        $("#numberactivities").removeClass('hide')
    }
})

.fail(function () {
    console.log("error");
});



setInterval(function () {
    $.ajax({
        url: "/getCountComp",
        type: "GET",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        dataType: "JSON",
    })

        .done(function (response) {
            if (response.length > 0) {
                $("#numbercomportaiment").text(response.length)
                $("#numbercomportaiment").removeClass('hide')
            }
        })

        .fail(function () {
            console.log("error");
        });
}, 60000);

setInterval(function () {
    $.ajax({
        url: "/getCountAct",
        type: "GET",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        dataType: "JSON",
    })

        .done(function (response) {
            if (response.length > 0) {
                $("#numberactivities").text(response.length)
                $("#numberactivities").removeClass('hide')
            }
        })

        .fail(function () {
            console.log("error");
        });
}, 60000);

$('#readNotification').on('click', function () {
    var id_n = $(this).attr('data-id');
    // alert("id: " + id_n)
    $.ajax({
        url: "/readNotification/" + id_n,
        type: "POST",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: { id: id_n },
    })

        .done(function (response) {
            if (response.length > 0) {
                $("#numberactivities").text(response.length)
                $("#numberactivities").removeClass('hide')
            }
        })

        .fail(function () {
            console.log("error");
        });
});

var modal_menu = $('#modal-menu-1');
var modal2_menu = $('#modal-menu-2');

$('#generar_reportes_menu').on('click', function () {

    // alert("Hola reporte")

    modal_menu.modal("show");
    ModalReporte_menu();

    //Reporte general
    $('#btn_reporte_general').on('click', function () {
        modal_menu.modal("hide");

        modal2_menu.modal("show");
        ModalReporteGeneral_menu();
        $('#back').on('click', function () {
            modal2_menu.modal("hide");
            modal_menu.modal("show");
        });


        //** ****************************DateRangepicker**************************** */
        // Se carga de dateRangePicker
        var start = moment().subtract(29, 'days');
        var end = moment();

        var fechas;

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            fechas = {
                fecha_i: start.format('YYYY-MM-DD'),
                fecha_f: end.format('YYYY-MM-DD')
            };
            console.log(fechas);
        }


        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Hoy': [moment(), moment()],
                'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Últimos 7 dias': [moment().subtract(6, 'days'), moment()],
                'Últimos 30 dias': [moment().subtract(29, 'days'), moment()],
                'Este mes': [moment().startOf('month'), moment().endOf('month')],
                'Ultimo mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            "locale": {
                "separator": " - ",
                "applyLabel": "Aplicar",
                "cancelLabel": "Cancelar",
                "fromLabel": "DE",
                "toLabel": "HASTA",
                "customRangeLabel": "Custom",
                "daysOfWeek": [
                    "Dom",
                    "Lun",
                    "Mar",
                    "Mie",
                    "Jue",
                    "Vie",
                    "Sáb"
                ],
                "monthNames": [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre"
                ],
                "firstDay": 1
            }
        }, cb);

        cb(start, end);
        //** ********************************************************************** */

        /** Acion al generar el pdf */
        $('#generar').on('click', function () {
            // https://quickchart.io/chart?bkg=white&c={type:%27bar%27,data:{labels:[2012,2013,2014,2015,2016],datasets:[{label:%27Users%27,data:[120,60,50,180,120]}]}}
            openWindowWithPostRequest('/reporte_general', fechas)
        });


    });
    // ************************

    //Reporte Avanzado
    $('#btn_reporte_avanzado').on('click', function () {
        modal_menu.modal("hide");
        modal2_menu.modal("show");
        ModalReporteAvanzado_menu();
        $('#back').on('click', function () {
            modal2_menu.modal("hide");
            modal_menu.modal("show");
        });

        //** ****************************DateRangepicker**************************** */
        var start = moment().subtract(29, 'days');
        var end = moment();

        var fechas = [];

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            fechas = {
                fecha_i: start.format('YYYY-MM-DD'),
                fecha_f: end.format('YYYY-MM-DD')
            };
            console.log(fechas);
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Hoy': [moment(), moment()],
                'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Últimos 7 dias': [moment().subtract(6, 'days'), moment()],
                'Últimos 30 dias': [moment().subtract(29, 'days'), moment()],
                'Este mes': [moment().startOf('month'), moment().endOf('month')],
                'Ultimo mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            "locale": {
                "separator": " - ",
                "applyLabel": "Aplicar",
                "cancelLabel": "Cancelar",
                "fromLabel": "DE",
                "toLabel": "HASTA",
                "customRangeLabel": "Custom",
                "daysOfWeek": [
                    "Dom",
                    "Lun",
                    "Mar",
                    "Mie",
                    "Jue",
                    "Vie",
                    "Sáb"
                ],
                "monthNames": [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre"
                ],
                "firstDay": 1
            }
        }, cb);

        cb(start, end);
        //** ********************************************************************** */


        //** ****************************Slider**************************** */
        $('#range').html(`
            <input id="mySlider" type="text" class="span2" value="" data-slider-min="0" data-slider-max="50" data-slider-step="1" data-slider-value="[5,20]"/>
            <span style="
            margin-left: 10px;" id="mySliderCurrentSliderValLabel">Intervalo: 
                [<span id="mySliderVal">5,20</span>] (años)
            </span>
        `);

        $("#mySlider").slider();

        $("#mySlider").on("slide", function (slideEvt) {
            $("#mySliderVal").text(slideEvt.value);
        });
        //** ********************************************************************** */


        //** ********************************************************************** */
        $("#check_conducta").append(`
                    <div class="checkbox">
                        <label>
                            <input id="tc_all" value="all" type="checkbox">Selecionar todo
                        </label>
                    </div>
                `);
        LoadTiposComportamientosCheck();

        $('#tc_all').on('click', function () {
            var checked = this.checked;
            $('input[name="conducta"]:checkbox').each(function () {
                this.checked = checked;
            });
        });

        $('#i_genero').on('click', function () {
            var checked = this.checked;
            if (checked) {
                $('#check_genero').show();
                $('input[name="genero"]:checkbox').prop('checked', true);
            } else {
                $('#check_genero').hide();
                $('input[name="genero"]:checkbox').prop('checked', false);
            }
        });

        var status = false;
        $('#i_grupo').on('click', function () {
            var checked = this.checked;
            if (!status) {
                LoadGrupos();
                status = true;
            }
            if (checked) {
                $('#check_grupo').show();
                $("#all_grupos").on('click', function () {
                    var checked = this.checked;
                    if (checked) {
                        $("#grupo_id option").prop('selected', true);
                        $("#grupo_id").trigger('change');
                    } else {
                        $("#grupo_id option").prop('selected', false);
                        $("#grupo_id").trigger('change');
                    }
                });
            } else {
                $('#check_grupo').hide();
                $("#all_grupos").prop('checked', false);
                $("#grupo_id option").prop('selected', false);
                $("#grupo_id").trigger('change');
            }
        });


        $('#i_edad').on('click', function () {
            var checked = this.checked;
            if (checked) {
                $('#check_edad').show();
            } else {
                $('#check_edad').hide();
            }
        });
        //** ********************************************************************** */

        $('#generar').on('click', function () {
            var ArrayConducta = [];
            var ArrayGenero = [];
            var ArrayEdad = [];
            var ArrayGrupo = [];

            $('input[name="conducta"]:checkbox:checked').each(
                function () {
                    if ($(this).val() != 'on') {
                        ArrayConducta.push($(this).val());
                    }
                }
            );
            $('input[name="genero"]:checkbox:checked').each(
                function () {
                    if ($(this).val() != 'on') {
                        ArrayGenero.push($(this).val());
                    }
                }
            );

            // var rangoEdad = $('#mySlider').val();
            if ($('#i_edad').prop('checked') == true) {
                ArrayEdad = $('#mySlider').val().split(",");
            }
            if ($('#i_grupo').prop('checked') == true) {
                ArrayGrupo = $('#grupo_id').val();
            }

            let datos = {
                fecha_i: fechas.fecha_i,
                fecha_f: fechas.fecha_f,
                conductas_id: ArrayConducta,
                generos: ArrayGenero,
                edades: ArrayEdad != null ? ArrayEdad : null,
                grupos_id: ArrayGrupo
            };
            openWindowWithPostRequest('/reporte_avanzado', datos);
        });
    });
    //** ********************************************************************** */

});

function openWindowWithPostRequest(url, params) {
    var winName = 'reporte';
    var winURL = url;
    // var windowoption = 'resizable=yes,height=1000,width=800,location=0,menubar=0,scrollbars=1';

    var form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("action", winURL);
    form.setAttribute("target", winName);
    for (var i in params) {
        if (params.hasOwnProperty(i)) {
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = i;
            input.value = params[i];
            form.appendChild(input);
        }
    }

    let csrfField = document.createElement('input');
    csrfField.setAttribute('type', 'hidden');
    csrfField.setAttribute('name', '_token');
    csrfField.setAttribute('value', $('meta[name="csrf-token"]').attr('content'));
    form.appendChild(csrfField);

    document.body.appendChild(form);
    window.open('', winName);
    form.target = winName;
    form.submit();
    document.body.removeChild(form);
}

function ModalReporteAvanzado_menu() {
    $('#modal2_menu_tam').removeClass('modal-lg');
    $('#modal2_menu_tam').addClass('modal-md');
    modal2_menu.find('.modal-content').empty().append(`
    <div class="modal-header">
        <a class="btn pull-left" id="back"><i class="fas fa-arrow-left"></i></a>
        <h4 class="modal-title">Crear Reportes</h4>
    </div>

    <div class="modal-body">


        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <label>Fecha del registro: </label>
                <div id="reportrange"
                    style="background: #fff; cursor: pointer; 
                    padding: 5px 10px; border: 1px solid #ccc; 
                    width: 100%; margin-bottom: 10px;>
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span> <i class="fa fa-caret-down"></i>
                </div>
            </div>
        </div> 

        <div class="row">
            <div class="col-lg-6 col-sm-12 col-xs-12">
                <label>Incluir</label>
                <div class="checkbox">
                    <label>
                        <input id="i_grupo" type="checkbox">Grupo
                    </label>
                </div>
                <div id="check_grupo" style="display: none; margin-left: 10px;">
                    <div class="input-group">
                        <select class="form-control" name="gupos[]" multiple="multiple" id="grupo_id" style="width: 100% !important;">

                        </select>
                        <input type="checkbox" id="all_grupos" >Seleccionar todos
                    </div>
                </div>
                <div class="checkbox">
                    <label>
                        <input id="i_genero" type="checkbox">Género
                    </label>
                </div>
                <div id="check_genero" style="display: none; margin-left: 10px;">
                    <div class="checkbox">
                        <label>
                            <input id="i_m" value="M" name="genero" type="checkbox">Masculino
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="i_f" value="F" name="genero" type="checkbox">Femenino
                        </label>
                    </div>
                </div>

                <div class="checkbox">
                    <label>
                        <input id="i_edad" type="checkbox">Edad
                    </label>
                </div>
                <div id="check_edad" style="display: none; margin-left: 10px;">
                    <div style="margin-top: 10px;" id="range" style="margin-left: 10px;"></div>
                </div>
            </div>

            <div class="col-lg-6 col-sm-12 col-xs-12">
                <label>Tipos de Conductas</label>
                <div id="check_conducta">

                </div>
            </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="generar">Generar PDF</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    </div>
`);
}

function ModalReporteGeneral_menu() {
    $('#modal2_menu_tam').removeClass('modal-lg');
    $('#modal2_menu_tam').addClass('modal-md');
    modal2_menu.find('.modal-content').empty().append(`
    <div class="modal-header">
        <a class="btn pull-left" id="back"><i class="fas fa-arrow-left"></i></a>
        <h4 class="modal-title">Crear Reportes</h4>
    </div>
    <div class="modal-body">

            <div class="row">

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label>Fecha del registro: </label>
                    <div id="reportrange"
                        style="background: #fff; cursor: pointer; 
                        padding: 5px 10px; border: 1px solid #ccc; 
                        width: 100%; margin-bottom: 10px;>
                        <i class="fa fa-calendar"></i>&nbsp;
                        <span></span> <i class="fa fa-caret-down"></i>
                    </div>
                </div>
            </div>

    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="generar">Generar PDF</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    </div>
`);
}

function ModalReporte_menu() {
    $('#modal1_menu_tam').removeClass('modal-lg');
    $('#modal1_menu_tam').addClass('modal-md');
    modal_menu.find('.modal-content').empty().append(/* html */`
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Seleccione el tipo de  Reporte</h4>
    </div>
    <div class="container mt-3">

        <div class="d-flex justify-content-around bg-secondary mb-3">

            <div class="">
                <p>qweqwe</p>
                <a id="btn_reporte_general" class="btn bg-purple">Reporte General</a>
            </div>
            <div class="">
                <p>zxzxzqweqwe</p>
                <a id="btn_reporte_avanzado" class="btn bg-purple">Reporte Avanzado</a>
            </div>

        </div>
    </div>
`);
}



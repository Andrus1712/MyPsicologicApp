var modal = $('#modal-actividades');
var AllRegister = []

$(document).ready(function () {
    Reload()
    ReloadCalendario()

    $('#act-table').on('click', '[id^=Btn_Edit_]', function () {
        var id = $(this).attr('data-id')
        var filtro = AllRegister.filter(f => f.id == id);

        if (filtro.length != 0) {
            modal.modal('show');
            Modal()
            $('#input_actividad').show()
            LoadTiposComportamientos()
            LoadComportamientos()

            $("#save").text("Actualizar")
            $("#save").attr("id", 'update')

            $("#comportamiento_id").val(filtro[0].comportamiento_id)
            $("#comportamiento_id").attr("readonly", true)

            $("#titulo").val(filtro[0].titulo)
            $("#descripcion").val(filtro[0].descripcion)
            $("#fecha").val(filtro[0].fecha)
            $('#estado').val(filtro[0].estado)
            $("#tipo_comportamiento_id").val(filtro[0].tipo_comportamiento_id)

            $('#update').on('click', function () {
                var comportamiento_id = $("#tipo_comportamiento_id").val(),
                    titulo = $("#titulo").val(),
                    descripcion = $("#descripcion").val(),
                    fecha = $("#fecha").val(),
                    estado = $('#estado').val(),
                    tipo_comportamiento_id = $("#tipo_comportamiento_id").val();

                if (comportamiento_id == '' || titulo == '' || descripcion == '' || fecha == '' || estado == '' || tipo_comportamiento_id == '') {
                    toastr.warning("Complete todos los campos")
                }
                else {
                    $.ajax({
                        url: '/api/actividades/' + id,
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        type: 'PUT',
                        data: {
                            comportamiento_id: comportamiento_id,
                            titulo: titulo,
                            descripcion: descripcion,
                            fecha: fecha,
                            estado: estado,
                            tipo_comportamiento_id: tipo_comportamiento_id,
                        },
                    })
                        .done(function () {
                            setTimeout(function () { modal.modal("hide") }, 600);
                            toastr.info("información actualizada");
                            Reload()
                            ReloadCalendario()
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

    $('#act-table').on('click', '[id^=Btn_delete_]', function () {
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
                    url: "/api/actividades/" + id,
                    type: "DELETE",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                })
                    .done(function () {
                        swal("Eliminado!", "Se ha eliminado el acudiente", "success");
                        Reload();
                    })
                    .fail(function () {
                        swal("Error!", "Ha ocurrido un error", "error");
                    });

            });


    })

    $('#add-actividades').on('click', function () {
        modal.modal('show');
        Modal()
        $('#input_actividad').hide()
        LoadComportamientos()
        LoadTiposComportamientos()

        $('#save').on('click', function () {
            var comportamiento_id = $("#comportamiento_id").val(),
                titulo = $("#titulo").val(),
                descripcion = $("#descripcion").val(),
                fecha = $("#fecha").val(),
                tipo_comportamiento_id = $("#tipo_comportamiento_id").val(),
                estado = 0 //estado por defecto de las actividades

            if (comportamiento_id == '' || titulo == '' || descripcion == '' || fecha == '' || tipo_comportamiento_id == '') {
                toastr.warning("Complete todos los campos")
            } else {
                $.ajax({
                    url: '/api/actividades',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    data: {
                        comportamiento_id: comportamiento_id,
                        titulo: titulo,
                        descripcion: descripcion,
                        fecha: fecha,
                        estado: estado,
                        tipo_comportamiento_id: tipo_comportamiento_id,
                        estado: estado
                    },
                })
                    .done(function () {
                        setTimeout(function () { modal.modal("hide") }, 600);
                        Reload()
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


    // Check estatus
    $('#act-table').on('click', '[id^=btn_cumplido_]', function(){
        alert("check")
    })

    $('#act-table').on('click', '[id^=btn_incumplido_]', function(){
        alert("check imcumplido")
    })
});

function validarFechaMenorActual(date) {
    var x = new Date();
    var fecha = date.split("/");
    x.setFullYear(fecha[2], fecha[1] - 1, fecha[0]);
    var today = new Date();

    if (x >= today)
        return false;
    else
        return true;
}

function LoadTiposComportamientos() {
    $("#tipo_comportamiento_id").select2({
        placeholder: 'Seleccione el tipo comportamiento',
        allowClear: true,
        dropdownParent: modal,
        width: 'resolve'
    });

    $.ajax({
        url: '/api/tipo_comportamientos',
    })
        .done(function (response) {
            for (var i in response.data) {
                $("#tipo_comportamiento_id").append(`<option value='${response.data[i].id}'>${response.data[i].titulo}</option>`)
            }

        })
        .fail(function () {
            console.log("error");
        })
}

function LoadComportamientos() {
    $("#comportamiento_id").select2({
        placeholder: 'Seleccione el comportamiento',
        allowClear: true,
        dropdownParent: modal,
        width: 'resolve'
    });

    $.ajax({
        url: '/api/comportamientos',
    })
        .done(function (response) {
            for (var i in response.data) {
                $("#comportamiento_id").append(`<option value='${response.data[i].id}'>${response.data[i].titulo} | ${response.data[i].nombres}  ${response.data[i].apellidos} | CMP${response.data[i].id} </option>`)
            }

        })
        .fail(function () {
            console.log("error");
        })
}

function Modal() {
    modal.find('.modal-content').empty().append(`
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Formulario de Actividades</h4>
        </div>
        <div class="modal-body">

            <div class="row">

                <div class="col-md-6">

                    <div class="form-group">
                        <label >Comportamiento: </label>
                        <div class="input-group">
                            <select class="form-control" id="comportamiento_id" style="width: 100%;">

                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Titulo: </label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control" placeholder="titulo de la actividad" id="titulo">
                        </div>
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label >Tipo de comportamiento: </label>
                        <div class="input-group">
                            <select class="form-control" id="tipo_comportamiento_id" style="width: 100%;">

                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Fecha de la actividad: </label>
                        <div class="input-group date" id="timepicker">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" id="fecha" >
                        </div>
                    </div>

                    <div class="form-group" id="input_actividad">
                        <label>Estado de la actividad: </label>
                        <select class="form-control" id="estado">
                            <option value=""> Selecione un estado </option>
                            <option value="1"> cumplida </option>
                            <option value="2"> incumplida </option>
                            <option value="0"> en espera </option>
                        </select>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Descripcion la actividad: </label>
                        <textarea id="descripcion" class="form-control" style="resize: vertical;" rows="3" placeholder="Escriba aqui la descripción de la actividad ..."></textarea>
                    </div>
                </div>
            </div>

                
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="save">Guardar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    `)
    $("#fecha").datetimepicker({
        format: "YYYY-MM-DD"
    });
}

// function LoadCalendario() {
//     var calendarEl = document.getElementById('calendar');
//     var calendar = new FullCalendar.Calendar(calendarEl, {
//         timeZone: 'America/Bogota',
//         locale: 'es',
//         themeSystem: 'bootstrap',
//         headerToolbar: {
//             left: 'prev,next today',
//             center: 'title',
//             right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
//         },
//         weekNumbers: true,
//         dayMaxEvents: true, // allow "more" link when too many events
//         events: [{

//         }]
//     });

//     calendar.render();
// }


function ReloadCalendario() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        timeZone: 'America/Bogota',
        height: 650,
        locale: 'es',
        themeSystem: 'bootstrap4',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
        },
        weekNumbers: true,
        dayMaxEvents: true, // allow "more" link when too many events
        events: [{}],
        eventClick: function (info) {
            var actividadFilter = JSON.parse(info.event.groupId);
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const event = new Date(actividadFilter.fecha.replace('-', '/'));
            // console.log(actividadFilter)
            modal.modal('show')
            modal.find('.modal-content').empty().append(`
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Actividad ${actividadFilter.titulo}</h4>
            </div>
            <div class="modal-body">

                <div class="row">

                    <div class="col-md-6">
                        <div class="clearfix"></div>

                        <div class="box box-widget">
                            <div class="box-header">
                                <h3 class="box-title">Informacion de la actividad</h3>
                            </div>
                            <div class="box-body with-border">
                                <div class="form-group">
                                    <label>Estado</label>
                                    <input type="text" class="form-control" value="${actividadFilter.estado == 0 ? "En espera" : actividadFilter.estado == 1 ? "Cumplida" : "Inclumplida"}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Fecha</label>
                                    <input type="text" class="form-control" value="${event.toLocaleDateString('es-CO', options)}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Descripción</label>
                                    <textarea class="form-control" readonly>${actividadFilter.descripcion}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        
                    </div>

                    <div class="col-md-6">
                        <div class="clearfix"></div>
                        <div class="box box-widget">
                            <div class="box-header with-border">
                                <h3 class="box-title">Datos del estudiante</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Estudiante</label>
                                    <input type="text" class="form-control" value="${actividadFilter.nombre_estudiante} ${actividadFilter.apellido_estudiante}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="box box-widget">
                            <div class="box-header with-border">
                                <h3 class="box-title">Datos del Comportamiento</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Titulo de comportamiento</label>
                                    <input type="text" class="form-control" value="${actividadFilter.titulo_comportamiento}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Tipo de comportamiento</label>
                                    <input type="text" class="form-control" value="${actividadFilter.titulo_tipo_comportamiento}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>

                <div>

                
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
            `)

        }
    });
    calendar.render();

    $.ajax({
        url: "/api/actividades",
        type: "GET",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        dataType: "JSON",
    })

        .done(function (response) {
            if (response.length != 0) {

                for (var i = 0; i < response.data.length; i++) {
                    calendar.addEvent({
                        id: response.data[i].id,
                        groupId: JSON.stringify(response.data[i]),
                        title: response.data[i].titulo,
                        start: response.data[i].fecha,
                        backgroundColor: response.data[i].estado == 0 ? '#F4A460' : response.data[i].estado == 1 ? '#3CB371' : '#FF6347',
                        borderColor: "gray",
                    })
                }
            } else {
                alert("Sin actividades")
            }
        })
        .fail(function () {
            console.log("error");
        });
}

function Reload() {
    $.ajax({
        url: "/api/actividades",
        type: "GET",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        dataType: "JSON",
    })

        .done(function (response) {
            if (response.length != 0) {
                AllRegister = response.data;
                DataTable(response.data);
            } else {
                $('#actividades-table').dataTable().fnClearTable();
                $('#actividades-table').dataTable().fnDestroy();
                $('#actividades-table thead').empty()
            }
        })

        .fail(function () {
            console.log("error");
        });
}


function DataTable(response) {

    console.log("datatable", response)
    if ($.fn.DataTable.isDataTable('#act-table')) {
        $('#act-table').dataTable().fnClearTable();
        $('#act-table').dataTable().fnDestroy();
        $('#act-table thead').empty()
    }
    else {
        $('#act-table thead').empty()
    }


    if (response.length != 0) {
        let my_columns = []
        $.each(response[0], function (key, value) {
            var my_item = {};
            // my_item.class = "filter_C";
            my_item.data = key;

            if (key == 'created_at') {

                my_item.title = 'Culminación';

                my_item.render = function (data, type, row) {
                    return `<div align="center">

                                <div class="btn-group btn-group-circle btn-group-solid" align="center">
                                    <a data-id=${row.id} id="btn_cumplido_${row.id}" class='btn btn-circle btn-sm btn-success'>
                                        <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                                    </a>

                                    <a data-id=${row.id} id="btn_incumplido_${row.id}" class='btn btn-circle btn-sm btn-danger'>
                                        <i class="fa fa-thumbs-o-down" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>`

                }
                my_columns.push(my_item);

            }

            if (key == 'deleted_at') {

                my_item.title = 'Actividades';

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
                    return `  <div'> 
                                ${row.id}
                            </div>`
                }
                my_columns.push(my_item);

            }
            else if (key == 'titulo') {

                my_item.title = 'Titulo Actividad';

                my_item.render = function (data, type, row) {
                    return `  <div'> 
                                ${row.titulo}
                            </div>`
                }
                my_columns.push(my_item);

            }

            else if (key == 'fecha') {

                my_item.title = 'Fecha';

                my_item.render = function (data, type, row) {
                    return `<div>
                                ${row.fecha} 
                            </div>`
                }
                my_columns.push(my_item);
            }

            else if (key == 'descripcion') {

                my_item.title = 'Descripcion de la actividad';

                my_item.render = function (data, type, row) {
                    return `<div>
                                ${row.descripcion} 
                            </div>`
                }
                my_columns.push(my_item);
            }

            else if (key == 'titulo_comportamiento') {

                my_item.title = 'Comportamiento';

                my_item.render = function (data, type, row) {
                    return `  <div'> 
                                ${row.titulo_comportamiento}
                            </div>`
                }
                my_columns.push(my_item);
            }

            else if (key == 'descripcion_comportamiento') {

                my_item.title = 'Descripcion comportamiento';

                my_item.render = function (data, type, row) {
                    return `  <div'> 
                                ${row.descripcion_comportamiento}
                            </div>`
                }
                my_columns.push(my_item);
            }

            else if (key == 'estado') {

                my_item.title = 'Estado Actividad';

                my_item.render = function (data, type, row) {

                    return `${row.estado == 1 ? `<i class="fa fa-check-circle text-success"></i>Cumplida` :
                        row.estado == 2 ? `<i class="fa fa-exclamation-circle text-danger"></i>Incumplida` :
                            `<i class="fa  fa-exclamation-triangle text-warning"></i>En espera`}`;

                    // return `<i class="fa fa-circle-o text-success">Incumplida</i>`;
                    // if (row.estado == 2) { return `Cumplida` }
                    // else if (row.estado == 1) { return `Incumplida` }
                    // else if (row.estado == 0) { return `En espera` }

                }
                my_columns.push(my_item);
            }

            else if (key == 'nombre_estudiante') {

                my_item.title = 'Estudiante';

                my_item.render = function (data, type, row) {
                    return `<div>
                                ${row.nombre_estudiante + " " + row.apellido_estudiante} 
                            </div>`
                }
                my_columns.push(my_item);
            }

            else if (key == 'titulo_tipo_comportamiento') {

                my_item.title = 'Conducta';

                my_item.render = function (data, type, row) {
                    return `<div>
                                ${row.titulo_tipo_comportamiento} <a data-id=${row.id} id="Btn_search_${row.id}" class='btn btn-circle btn-xs btn-default'>
                                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                </a>
                            </div>`
                }
                my_columns.push(my_item);
            }

        })

        $('#act-table').DataTable({
            'responsive': true,
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
                "info": "Mostrando _START_ a _END_ de _TOTAL_ comportamientos",
                "infoEmpty": "No hay comportamientos registrados",
                "infoFiltered": "(Filtrado de _MAX_  comportamientos)",
                "lengthMenu": "_MENU_ comportamientos",
                "search": "Buscar:",
                "zeroRecords": "No se han encontrado registros"
            },
            buttons: [
                'copy', 'excel', 'pdf'
            ],


            "order": [
                [0, 'asc']
            ],

            "columnDefs": [
                { "width": "20%", "targets": 8 }
            ],

            "lengthMenu": [
                [10, 15, 20, -1],
                [10, 15, 20, "Todos"]
            ]
        });
        $('thead > tr> th:nth-child(4)').css({ 'min-width': '140px', 'max-width': '140px' });
        $('thead > tr> th:nth-child(9)').css({ 'min-width': '140px', 'max-width': '140px' });
        $('thead > tr> th:nth-child(10)').css({ 'min-width': '140px', 'max-width': '140px' });
    }
}

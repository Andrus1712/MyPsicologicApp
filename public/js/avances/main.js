var modal = $('#modal-avances')
var AllRegister = []

$(document).ready(function () {
    Reload()

    $('#add-avance').on('click', function () {
        modal.modal('show')
        Modal()
        LoadActividad()
        establecer_fecha()

        $('#save').on('click', function () {
            var actividad_id = $('#actividad_id').val(),
                descripcion = $('#descripcion').val(),
                fecha = $('#fecha').val(),
                evidencias = $('#evidencias')[0].files[0];

            if (actividad_id == '' || descripcion == '' || fecha == '') {
                toastr.warning("Complete todos los campos")
            }
            else {
                var form =new FormData();
                form.append('actividad_id', actividad_id)
                form.append('descripcion', descripcion)
                form.append('fecha_avance', fecha)
                form.append('evidencias', evidencias)               

                $.ajax({
                    url: '/api/avances',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: form,
                })
                    .done(function () {
                        toastr.success("Avance registrado");
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

    $('#avances-table').on('click', '[id^=Btn_Edit_]', function () {
        var id = $(this).attr('data-id');

        const filtro = AllRegister.filter(f => f.id == id);

        if (filtro.length != 0) {
            modal.modal("show");
            Modal()
            LoadActividad()

            $("#save").text("Actualizar")
            $("#save").attr("id", 'update')
            $("#actividad_id").val(filtro[0].actividad_id)
            $("#descripcion").val(filtro[0].avance)
            $("#fecha").val(filtro[0].fecha_avance)

            $('#rutaFile').removeClass('hide')
            $("#rutaFile").attr('href',filtro[0].evidencias)
            $('#rutaFile').attr('target', '_blank')
            $("#rutaFile").text('Ver documento')

            $("#update").on('click', function () {
                var actividad_id = $("#actividad_id").val(),
                    descripcion = $("#descripcion").val(),
                    fecha_avance = $("#fecha").val(),
                    evidencias = $("#evidencias")[0].files[0] == undefined ? $("#rutaFile").attr('href') : $("#evidencias")[0].files[0];

                if (actividad_id == '' || evidencias == '' || descripcion == '' || fecha_avance == '') {
                    toastr.warning("Complete todos los campos")
                }
                else {

                    var form = new FormData();

                    form.append('actividad_id', actividad_id)
                    form.append('descripcion', descripcion)
                    form.append('fecha_avance', fecha_avance)
                    form.append('evidencias', evidencias) 
                    form.append('id', id)
                    form.append('method', 'update')
                    
                    
                    
                    $.ajax({
                        url: '/api/avances',
                        headers: { 
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        data: form,
                        
                    })
                    .done(function () {
                        setTimeout(function () { modal.modal("hide") }, 600);
                        toastr.info("información actualizada");
                        Reload()
                    })
                    .fail(function (errorM) {
                        toastr.error(errorM.responseJSON.message == undefined ? 'Ha ocurrido un error' : errorM.responseJSON.message);
                    })
                    .always(function () {
                        $("#update").addClass("disabled");
                    });
                }
            })
        }
    })

    $('#avances-table').on('click', '[id^=Btn_delete_]', function () {
        var id = $(this).attr('data-id')

        swal({
            title: "¿Realmente deseas eliminar el avance?",
            text: "Ten en cuenta que eliminaras toda su información del sistema",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Si, eliminar",
            closeOnConfirm: false
        },
            function () {
                $.ajax({
                    url: "/api/avances/" + id,
                    type: "DELETE",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                })
                    .done(function () {
                        swal("Eliminado!", "Se ha eliminado el avance", "success");
                        Reload();
                    })
                    .fail(function () {
                        swal("Error!", "Ha ocurrido un error", "error");
                    });

            });


    })

});

function establecer_fecha() {
    var hoy = new Date();
    hoy.setMinutes(hoy.getMinutes() - hoy.getTimezoneOffset());
    hoy = hoy.toJSON().slice(0, 10);
    $("#fecha").val(hoy);
}

function LoadActividad() {
    $("#actividad_id").select2({
        placeholder: 'Seleccionela actividad',
        allowClear: true,
        dropdownParent: modal,
        width: 'resolve'
    });

    $.ajax({
        url: '/api/actividades',
    })
        .done(function (response) {
            for (var i in response.data) {
                $("#actividad_id").append(`<option value='${response.data[i].id}'>${response.data[i].titulo} | ${response.data[i].titulo_comportamiento} | ${response.data[i].nombre_estudiante} ${response.data[i].apellido_estudiante}</option>`)
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
            <h4 class="modal-title">Registar Avances de Actividades</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">

                    <div class="form-group">
                        <label>Actividad: </label>
                        <select class="form-control" id="actividad_id" style="width: 100%;">

                        </select>
                    </div>

                    <div class="form-group">
                        <label>Descripcion del avance: </label>
                        <textarea id="descripcion" class="form-control" style="resize: vertical;" rows="3" placeholder="Escriba aqui la descripcion del avance ..."></textarea>
                    </div>

                </div>
                <div class="col-md-6">

                    <div class="form-group">
                        <label>Fecha del Avance: </label>
                        <div class="input-group date" id="timepicker">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" id="fecha" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <a class="btn btn-secondary hide" id="rutaFile"></a>
                        <br>
                        <label>Evidencias: </label>
                        <input type="file" id="evidencias">
                        
                        <p class="help-block">Suba archivo que evdencie el avance.</p>
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
        url: "/api/avances",
        type: "GET",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        dataType: "JSON",
    })

        .done(function (response) {
            if (response.length != 0) {
                AllRegister = response.data;

                DataTable(response.data);
            } else {
                $('#avances-table').dataTable().fnClearTable();
                $('#avances-table').dataTable().fnDestroy();
                $('#avances-table thead').empty()
            }
        })

        .fail(function () {
            console.log("error");
        });
}

function DataTable(response) {

    console.log(response)
    if ($.fn.DataTable.isDataTable('#avances-table')) {
        $('#avances-table').dataTable().fnClearTable();
        $('#avances-table').dataTable().fnDestroy();
        $('#avances-table thead').empty()
    }
    else {
        $('#avances-table thead').empty()
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
                    return `  <div'> 
                                ${row.id}
                            </div>`
                }
                my_columns.push(my_item);

            }

            else if (key == 'avance') {

                my_item.title = 'Avance';

                my_item.render = function (data, type, row) {
                    return `  <div'> 
                                ${row.avance}
                            </div>`
                }
                my_columns.push(my_item);
            }

            else if (key == 'titulo_actividad') {

                my_item.title = 'Actividad';

                my_item.render = function (data, type, row) {
                    return `<div>
                                ${row.titulo_actividad} 
                            </div>`
                }
                my_columns.push(my_item);
            }
            else if (key == 'descripcion_actividad') {

                my_item.title = 'Descripcion de la actividad';

                my_item.render = function (data, type, row) {
                    return `<div>
                                ${row.descripcion_actividad} 
                            </div>`
                }
                my_columns.push(my_item);
            }
            else if (key == 'comportamiento_registrado') {

                my_item.title = 'Comportamiento';

                my_item.render = function (data, type, row) {
                    return `<div>
                                ${row.comportamiento_registrado} 
                            </div>`
                }
                my_columns.push(my_item);
            }

            else if (key == 'titulo_tipo_comportamiento') {

                my_item.title = 'Tipo de comportamiento';

                my_item.render = function (data, type, row) {
                    return `<div>
                                ${row.titulo_tipo_comportamiento} 
                            </div>`
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
            else if (key == 'evidencias') {

                my_item.title = 'Evidencias';

                my_item.render = function (data, type, row) {
                    return `<div align="center">
                                <a href=" ${row.evidencias} " class="btn btn-default" target="_blank">
                                    <i class="fa fa-file"></i>
                                </a>
                            </div>`
                }
                my_columns.push(my_item);
            }

        })

        $('#avances-table').DataTable({
            // responsive: true,
            "destroy": true,
            data: response,
            "columns": my_columns,
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No hay datos registrados",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ avances",
                "infoEmpty": "No hay avances registrados",
                "infoFiltered": "(Filtrado de _MAX_  avances)",
                "lengthMenu": "_MENU_ avances",
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
                { "width": "20%", "targets": 1 },
                { "width": "20%", "targets": 2 },
                { "width": "20%", "targets": 4 },
                { "width": "20%", "targets": 8 }
            ],

            "lengthMenu": [
                [10, 15, 20, -1],
                [10, 15, 20, "Todos"]
            ]
        });
    }
}

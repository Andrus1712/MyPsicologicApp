var modal = $('#modal-comportamientos')
var AllRegister = []

$(document).ready(function () {
    Reload()

    $('#comportamientos-table').on('click', '[id^=Btn_act_]', function () {
        modal.modal('show');
        ModalActividades()
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

    $('#comportamientos-table').on('click', '[id^=Btn_Edit_]', function () {
        var id = $(this).attr('data-id');

        const filtro = AllRegister.filter(f => f.id == id);

        if (filtro.length != 0) {
            modal.modal("show");
            Modal()
            LoadEstudiantes()


            $("#save").text("Actualizar")
            $("#save").attr("id", 'update')

            $("#cod_comportamiento").val(filtro[0].cod_comportamiento)
            $("#cod_comportamiento").attr("disabled", true)
            $("#titulo").val(filtro[0].titulo)
            $("#estudiante_id").val(filtro[0].estudiante_id)
            $("#descripcion").val(filtro[0].descripcion)
            $("#fecha").val(filtro[0].fecha)
            $("#emisor").val(filtro[0].emisor)

            $("#update").on('click', function () {
                var cod_comportamiento = $("#cod_comportamiento").val(),
                    estudiante_id = $("#estudiante_id").val(),
                    titulo = $("#titulo").val(),
                    descripcion = $("#descripcion").val(),
                    fecha = $("#fecha").val(),
                    emisor = "X",
                    multimedia = $("#multimedia").val();

                if (cod_comportamiento == '' || estudiante_id == '' || titulo == '' || descripcion == '' || fecha == '') {
                    toastr.warning("Complete todos los campos")
                }
                else {
                    $.ajax({
                        url: '/api/comportamientos/' + id,
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        type: 'PUT',
                        data: {
                            cod_comportamiento: cod_comportamiento,
                            estudiante_id: estudiante_id,
                            titulo: titulo,
                            descripcion: descripcion,
                            fecha: fecha,
                            emisor: emisor,
                            multimedia: multimedia,

                        },
                    })
                        .done(function () {
                            setTimeout(function () { modal.modal("hide") }, 600);
                            toastr.info("información actualizada");
                            Reload()
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

    $('#comportamientos-table').on('click', '[id^=Btn_delete_]', function () {
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
                    url: "/api/comportamientos/" + id,
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

    $('#add-comportamientos').on('click', function () {
        modal.modal('show')
        Modal()
        LoadEstudiantes()
        establecer_fecha()

        // $('#btn_add').on('click', function(){
        //     alert("agregar estudiante")
        // })

        $('#save').on('click', function () {
            var cod_comportamiento = Math.random() * 9999,
                estudiante_id = $("#estudiante_id").val(),
                titulo = $("#titulo").val(),
                descripcion = $("#descripcion").val(),
                fecha = $("#fecha").val(),
                emisor = "X",
                multimedia = $("#multimedia").val();

            if (cod_comportamiento == '' || estudiante_id == '' || titulo == '' || descripcion == '' || fecha == '') {
                toastr.warning("Complete todos los campos")
            }
            else {
                $.ajax({
                    url: '/api/comportamientos',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    data: {
                        cod_comportamiento: cod_comportamiento,
                        estudiante_id: estudiante_id,
                        titulo: titulo,
                        descripcion: descripcion,
                        fecha: fecha,
                        emisor: emisor,
                        multimedia: multimedia,

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


});

function LoadEstudiantes() {
    $("#estudiante_id").select2({
        placeholder: 'Seleccione el estudiante',
        allowClear: true,
        dropdownParent: modal,
        width: 'resolve'
    });

    $.ajax({
        url: '/api/estudiantes',
    })
        .done(function (response) {
            for (var i in response.data) {
                $("#estudiante_id").append(`<option value='${response.data[i].id}'>${response.data[i].nombres} ${response.data[i].apellidos}</option>`)
            }

        })
        .fail(function () {
            console.log("error");
        })
}

function establecer_fecha() {
    var hoy = new Date();
    hoy.setMinutes(hoy.getMinutes() - hoy.getTimezoneOffset());
    hoy = hoy.toJSON().slice(0, 10);
    $("#fecha").val(hoy);
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

function Reload() {
    $.ajax({
        url: "/api/comportamientos",
        type: "GET",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        dataType: "JSON",
    })

        .done(function (response) {
            if (response.length != 0) {
                AllRegister = response.data;

                DataTable(response.data);
            } else {
                $('#comportamientos-table').dataTable().fnClearTable();
                $('#comportamientos-table').dataTable().fnDestroy();
                $('#comportamientos-table thead').empty()
            }
        })

        .fail(function () {
            console.log("error");
        });
}

// function ReloadAct() {
//     $.ajax({
//         url: "/api/actividades",
//         type: "GET",
//         headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
//         dataType: "JSON",
//     })

//         .done(function (response) {
//             if (response.length != 0) {
//                 AllRegister = response.data;

//                 DataTableAct(response.data);
//             } else {
//                 $('#act-table').dataTable().fnClearTable();
//                 $('#act-table').dataTable().fnDestroy();
//                 $('#act-table thead').empty()
//             }
//         })

//         .fail(function () {
//             console.log("error");
//         });
// }

function Modal() {
    modal.find('.modal-content').empty().append(`
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Formulario de Comportamientos</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">

                    <div class="form-group">
                        <label>Titulo Comportamiento: </label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-thumb-tack"></i></span>
                            <input type="text" class="form-control" placeholder="Titulo" id="titulo">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label >Estudiante: </label>
                        <div class="input-group">
                            <select class="form-control" id="estudiante_id" style="width: 100%;">

                            </select>
                            <span class="input-group-btn">
                                <button id="btn_add" type="button" class="btn btn-circle btn-sm btn-success">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                </button>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Fecha del Comportamiento: </label>
                        <div class="input-group date" id="timepicker">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="fecha" class="form-control pull-right" id="fecha" disabled>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Descripcion: </label>
                        <textarea id="descripcion" class="form-control" style="resize: vertical;" rows="3" placeholder="Descripcion ..."></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Multimedia: </label>
                        <input type="file" id="multimedia">
                        
                        <p class="help-block">Suba archivo que ayude a reportar el comportamiento.</p>
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

function ModalActividades() {
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


function DataTable(response) {

    console.log(response)
    if ($.fn.DataTable.isDataTable('#comportamientos-table')) {
        $('#comportamientos-table').dataTable().fnClearTable();
        $('#comportamientos-table').dataTable().fnDestroy();
        $('#comportamientos-table thead').empty()
    }
    else {
        $('#comportamientos-table thead').empty()
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

                                    <a data-id=${row.id} id="Btn_act_${row.id}" class='btn btn-circle btn-sm btn-success'>
                                        <i class="fa fa-calendar-plus-o" aria-hidden="true"></i>
                                    </a>

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
                                CMP${row.id}
                            </div>`
                }
                my_columns.push(my_item);

            }

            else if (key == 'titulo') {

                my_item.title = 'Titulo';

                my_item.render = function (data, type, row) {
                    return `<div>
                                ${row.titulo} 
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

            else if (key == 'nombres') {

                my_item.title = 'Estudiante';

                my_item.render = function (data, type, row) {
                    return `<div>
                                ${row.nombres + " " + row.apellidos} 
                            </div>`
                }
                my_columns.push(my_item);
            }

            else if (key == 'nombre_acudiente') {

                my_item.title = 'Acudiente';

                my_item.render = function (data, type, row) {
                    return `<div>
                                ${row.nombre_acudiente + " " + row.apellido_acudiente}
                                <a data-id=${row.id} id="Btn_search_${row.id}" class='btn btn-circle btn-xs btn-default'>
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </a>
                            </div>`
                }
                my_columns.push(my_item);
            }

            else if (key == 'grado') {

                my_item.title = 'Curso';

                my_item.render = function (data, type, row) {
                    return `<div>
                                ${row.grado + "-" + row.curso} 
                            </div>`
                }
                my_columns.push(my_item);
            }

            else if (key == 'multimedia') {

                my_item.title = 'Multimedia';

                my_item.render = function (data, type, row) {
                    return `<div align="center">
                                <a href="${row.multimedia} " class="btn btn-default" target="_blank">
                                    <i class="fa fa-file"></i>
                                </a>
                            </div>`
                }
                my_columns.push(my_item);
            }
        })

        $('#comportamientos-table').DataTable({
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
                { "width": "15%", "targets": 1 },
                { "width": "20%", "targets": 2 },
                { "width": "20%", "targets": 7 },
                { "width": "16%", "targets": 4 }
            ],

            "lengthMenu": [
                [10, 15, 20, -1],
                [10, 15, 20, "Todos"]
            ]
        });
    }
}

// function DataTableAct(response) {

//     console.log(response)
//     if ($.fn.DataTable.isDataTable('#act-table')) {
//         $('#act-table').dataTable().fnClearTable();
//         $('#act-table').dataTable().fnDestroy();
//         $('#act-table thead').empty()
//     }
//     else {
//         $('#act-table thead').empty()
//     }


//     if (response.length != 0) {
//         let my_columns = []
//         $.each(response[0], function (key, value) {
//             var my_item = {};
//             // my_item.class = "filter_C";
//             my_item.data = key;
//             if (key == 'created_at') {

//                 my_item.title = 'Actividades';

//                 my_item.render = function (data, type, row) {
//                     return `<p>
//                             <span class="label label-danger">A</span>
//                             <span class="label label-success">C</span>
//                             <span class="label label-danger">C</span>
//                             </p>`

//                 }
//                 my_columns.push(my_item);

//             }

//             else if (key == 'id') {

//                 my_item.title = '#';

//                 my_item.render = function (data, type, row) {
//                     return `  <div'> 
//                                 ${row.id}
//                             </div>`
//                 }
//                 my_columns.push(my_item);

//             }

//             else if (key == 'titulo_comportamiento') {

//                 my_item.title = 'Comportamiento';

//                 my_item.render = function (data, type, row) {
//                     return `  <div'> 
//                                 ${row.titulo_comportamiento}
//                             </div>`
//                 }
//                 my_columns.push(my_item);
//             }

//             else if (key == 'nombre_estudiante') {

//                 my_item.title = 'Estudiante';

//                 my_item.render = function (data, type, row) {
//                     return `<div>
//                                 ${row.nombre_estudiante+" "+row.apellido_estudiante} 
//                             </div>`
//                 }
//                 my_columns.push(my_item);
//             }

//             else if (key == 'conducta') {

//                 my_item.title = 'Conducta';

//                 my_item.render = function (data, type, row) {
//                     return `<div>
//                                 ${row.conducta} <a data-id=${row.id} id="Btn_search_${row.id}" class='btn btn-circle btn-xs btn-default'>
//                                                     <i class="fa fa-info-circle" aria-hidden="true"></i>
//                                                 </a>
//                             </div>`
//                 }
//                 my_columns.push(my_item);
//             }

//             else if (key == 'fecha') {

//                 my_item.title = 'Fecha';

//                 my_item.render = function (data, type, row) {
//                     return `<div>
//                                 ${row.fecha} 
//                             </div>`
//                 }
//                 my_columns.push(my_item);
//             }
//         })

//         $('#act-table').DataTable({
//             // responsive: true,
//             "destroy": true,
//             data: response,
//             "columns": my_columns,
//             "language": {
//                 "aria": {
//                     "sortAscending": ": activate to sort column ascending",
//                     "sortDescending": ": activate to sort column descending"
//                 },
//                 "emptyTable": "No hay datos registrados",
//                 "info": "Mostrando _START_ a _END_ de _TOTAL_ comportamientos",
//                 "infoEmpty": "No hay comportamientos registrados",
//                 "infoFiltered": "(Filtrado de _MAX_  comportamientos)",
//                 "lengthMenu": "_MENU_ comportamientos",
//                 "search": "Buscar:",
//                 "zeroRecords": "No se han encontrado registros"
//             },
//             buttons: [
//                 'copy', 'excel', 'pdf'
//             ],


//             "order": [
//                 [0, 'asc']
//             ],

//             "columnDefs": [
//                 { "width": "15%", "targets": 3 }
//             ],

//             "lengthMenu": [
//                 [10, 15, 20, -1],
//                 [10, 15, 20, "Todos"]
//             ]
//         });
//     }
// }
var modal = $("#modal-docentes")
var AllRegister = []

var permisos = []

$(document).ready(function() {
    Reload()

    $('#docentes-table').on('click', '[id^=Btn_Edit_]', function() {
        var id = $(this).attr('data-id');

        const filtro = AllRegister.filter(f => f.id == id);

        if (filtro.length != 0) {
            modal.modal("show");
            Modal()
            $("#save").text("Actualizar")
            $("#save").attr("id", 'update')

            $("#identificacion").val(filtro[0].identificacion)
            $("#identificacion").attr("readonly", true)

            $("#nombres").val(filtro[0].nombres)
            $("#apellidos").val(filtro[0].apellidos)
            $("#telefono").val(filtro[0].telefono)
            $("#correo").val(filtro[0].correo)
            $("#direccion").val(filtro[0].direccion)
            $("#fechaNacimiento").val(filtro[0].fechaNacimiento)
            $("#tipoIdentificacion").empty()
            $("#tipoIdentificacion").append(`<option value="${filtro[0].tipoIdentificacion}">
                ${filtro[0].tipoIdentificacion == 'CC' ? 'Cédula de ciudadania' : filtro[0].tipoIdentificacion == 'CE' ? 'Cédula extranjera' : 'Pasaporte'}
            </option>`)


            $("#update").on('click', function() {
                var tipoIdentificacion = $("#tipoIdentificacion").val(),
                    identificacion = $("#identificacion").val(),
                    nombres = $("#nombres").val(),
                    apellidos = $("#apellidos").val(),
                    correo = $("#correo").val(),
                    fechaNacimiento = $("#fechaNacimiento").val(),
                    telefono = $("#telefono").val(),
                    direccion = $("#direccion").val();

                if (tipoIdentificacion == '' || identificacion == '' || nombres == '' || apellidos == '' || correo == '' || fechaNacimiento == '' || telefono == '' || direccion == '') {
                    toastr.warning("Complete todos los campos")
                } else {
                    $.ajax({
                            url: '/api/docentes/' + id,
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            type: 'PUT',
                            data: {
                                id: id,
                                tipoIdentificacion: tipoIdentificacion,
                                identificacion: identificacion,
                                nombres: nombres,
                                apellidos: apellidos,
                                correo: correo,
                                fechaNacimiento: fechaNacimiento,
                                telefono: telefono,
                                direccion: direccion,
                            },
                        })
                        .done(function() {
                            setTimeout(function() { modal.modal("hide") }, 600);
                            toastr.info("información actualizada");
                            Reload()
                        })
                        .fail(function() {
                            toastr.error("Ha ocurrido un error");
                        })
                        .always(function() {
                            $("#update").addClass("disabled");
                        });
                }
            });

        }
    })

    $('#docentes-table').on('click', '[id^=Btn_delete_]', function() {
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
            function() {
                $.ajax({
                        url: "/api/docentes/" + id,
                        type: "DELETE",
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    })
                    .done(function() {
                        swal("Eliminado!", "Se ha eliminado el acudiente", "success");
                        Reload();
                    })
                    .fail(function() {
                        swal("Error!", "Ha ocurrido un error", "error");
                    });

            });


    })

    $('#add-docentes').on('click', function() {
        modal.modal('show');
        Modal();

        $("#save").on('click', function() {
            var tipoIdentificacion = $("#tipoIdentificacion").val(),
                identificacion = $("#identificacion").val(),
                nombres = $("#nombres").val(),
                apellidos = $("#apellidos").val(),
                correo = $("#correo").val(),
                fechaNacimiento = $("#fechaNacimiento").val(),
                telefono = $("#telefono").val(),
                direccion = $("#direccion").val();

            if (tipoIdentificacion == '' || identificacion == '' || nombres == '' || apellidos == '' || correo == '' || fechaNacimiento == '' || telefono == '' || direccion == '') {
                toastr.warning("Complete todos los campos")

            } else {
                var data = {
                    tipoIdentificacion: tipoIdentificacion,
                    identificacion: identificacion,
                    nombres: nombres,
                    apellidos: apellidos,
                    correo: correo,
                    fechaNacimiento: fechaNacimiento,
                    telefono: telefono,
                    direccion: direccion,
                };
                console.log(data)
                $('#loading-spinner').show();
                $.ajax({
                        url: '/api/docentes',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        type: 'POST',
                        data: {
                            tipoIdentificacion: tipoIdentificacion,
                            identificacion: identificacion,
                            nombres: nombres,
                            apellidos: apellidos,
                            correo: correo,
                            fechaNacimiento: fechaNacimiento,
                            telefono: telefono,
                            direccion: direccion,
                        },
                    })
                    .done(function(response) {
                        toastr.success("Docente agregado");
                        setTimeout(function() {
                            $('#loading-spinner').hide();
                            modal.modal("hide")
                        }, 600);
                        Reload();
                    })
                    .fail(function(response) {
                        $('#loading-spinner').hide();
                        // console.log(response.responseJSON);
                        if (response.responseJSON.message == "id-registrada") {
                            toastr.warning("La identificacion ya se encuentra registrada");
                        } else {
                            toastr.error("Ha ocurrido un error");
                        }
                    })
                    .always(function() {
                        $("#save").addClass("disabled");
                    });
            }

        });
    })
});

function Modal() {
    modal.find('.modal-content').empty().append(`
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Formulario de Docentes</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tipo de identificación: </label>
                        <select class="form-control" id="tipoIdentificacion" name="state">
                            <option value="">Seleccione</option>
                            <option value="CC">Cédula de ciudadania</option>
                            <option value="TI">Tarjeta de identidad</option>
                            <option value="CE">Cédula extranjera</option>
                            <option value="PS">Pasaporte</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Nombres: </label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control" placeholder="Nombres" id="nombres">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Apellidos: </label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control" placeholder="Apellidos" id="apellidos">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Correo: </label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                            <input type="email" class="form-control" placeholder="Correo" id="correo">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label># identificación: </label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control" placeholder="Identificación" id="identificacion">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Fecha de nacimiento: </label>
                        <div class="input-group date" id="timepicker">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" id="fechaNacimiento" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Telefono: </label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <input type="text" class="form-control" data-inputmask="&quot;mask&quot;: &quot;(999) 999-9999&quot;" data-mask="" id="telefono" maxlength="10">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Direccion de recidencia: </label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-map-pin"></i></span>
                            <input type="text" class="form-control" placeholder="Dirección: " id="direccion">
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="save" >Guardar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    `)
    $("#timepicker").datetimepicker({
        format: "YYYY-MM-DD"
    });
}

function Reload() {
    $.ajax({
        url: "/getDocentes",
        type: "GET",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        dataType: "JSON",
    })

    .done(function(response) {
        if (response.length != 0) {
            AllRegister = response.docentes;
            permisos = response.permisos;
            DataTable(response.docentes);
        } else {
            $('#docentes-table').dataTable().fnClearTable();
            $('#docentes-table').dataTable().fnDestroy();
            $('#docentes-table thead').empty()
        }
    })

    .fail(function() {
        console.log("error");
    });
}

function DataTable(response) {

    console.log(response)
    if ($.fn.DataTable.isDataTable('#docentes-table')) {
        $('#docentes-table').dataTable().fnClearTable();
        $('#docentes-table').dataTable().fnDestroy();
        $('#docentes-table thead').empty()
    } else {
        $('#docentes-table thead').empty()
    }


    if (response.length != 0) {
        let my_columns = []
        $.each(response[0], function(key, value) {
            var my_item = {};
            // my_item.class = "filter_C";
            my_item.data = key;
            if (key == 'created_at') {

                my_item.title = 'Acción';

                my_item.render = function(data, type, row) {
                    var html = '';
                    for (let i = 0; i < permisos.length; i++) {

                        if (permisos[i] == "delete.docentes") {
                            html += `
                                    <a data-id=${row.id} id="Btn_delete_${row.id}" class='btn btn-circle btn-sm btn-danger'>
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a> `
                        } else if (permisos[i] == "edit.docentes") {
                            html += `
                                    <a data-id=${row.id} id="Btn_Edit_${row.id}" class='btn btn-circle btn-sm btn-primary'>
                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                    </a>`
                        }
                    }
                    return `<div align="center">
                                <div class="btn-group btn-group-circle btn-group-solid" align="center">
                                    ${html}
                                </div>
                                
                            </div>`
                }
                if (permisos.length != 0) {
                    my_columns.push(my_item);
                }

            } else if (key == 'id') {

                my_item.title = '#';

                my_item.render = function(data, type, row) {
                    return `  <div'> 
                                ${row.id}
                            </div>`
                }
                my_columns.push(my_item);


            } else if (key == 'tipoIdentificacion') {

                my_item.title = 'Tipo ID';

                my_item.render = function(data, type, row) {
                    return `  <div'> 
                                ${row.tipoIdentificacion}
                            </div>`
                }
                my_columns.push(my_item);
            } else if (key == 'identificacion') {

                my_item.title = 'Identidicacion';

                my_item.render = function(data, type, row) {
                    return `  <div'> 
                                ${row.identificacion}
                            </div>`
                }
                my_columns.push(my_item);
            } else if (key == 'nombres') {

                my_item.title = 'Docente';

                my_item.render = function(data, type, row) {
                    return `<div>
                                ${row.nombres + " " + row.apellidos}
                            </div>`
                }
                my_columns.push(my_item);
            } else if (key == 'correo') {

                my_item.title = 'Email';

                my_item.render = function(data, type, row) {
                    return `<div>
                                ${row.correo} 
                            </div>`
                }
                my_columns.push(my_item);
            } else if (key == 'telefono') {

                my_item.title = 'Télefono';

                my_item.render = function(data, type, row) {
                    return `<div>
                                ${row.telefono} 
                            </div>`
                }
                my_columns.push(my_item);
            } else if (key == 'direccion') {

                my_item.title = 'Dirección';

                my_item.render = function(data, type, row) {
                    return `<div>
                                ${row.direccion} 
                            </div>`
                }
                my_columns.push(my_item);
            }

        })

        $('#docentes-table').DataTable({
            "scrollX": screen.width < 400 ? true : false,
            "destroy": true,
            data: response,
            "columns": my_columns,
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No hay datos registrados",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ docentes",
                "infoEmpty": "No hay docentes registrados",
                "infoFiltered": "(Filtrado de _MAX_  docentes)",
                "lengthMenu": "_MENU_ docentes",
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
                { "width": "15%", "targets": 3 }
            ],

            "lengthMenu": [
                [10, 15, 20, -1],
                [10, 15, 20, "Todos"]
            ]
        });
    }
}
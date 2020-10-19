var modal = $("#modal-estudiantes")
var AllRegister = []


$(document).ready(function () {
    Reload()

    $("#estudiantes-table").on('click', '[id^=Btn_Edit_]', function () {

        var id = $(this).attr('data-id')
        var filtro = AllRegister.filter(f => f.id == id);

        if (filtro.length != 0) {
            modal.modal('show');
            Modal()
            LoadAcudiente()
            LoadCurso()

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

            $('#update').on('click', function () {
                var tipoIdentificacion = $("#tipoIdentificacion").val(),
                    identificacion = $("#identificacion").val(),
                    nombres = $("#nombres").val(),
                    apellidos = $("#apellidos").val(),
                    correo = $("#correo").val(),
                    fechaNacimiento = $("#fechaNacimiento").val(),
                    edad = calcularEdad(fechaNacimiento),
                    telefono = $("#telefono").val(),
                    acudiente_id = $('#acudiente_id').val(),
                    grupo_id = $('#grupo_id').val();

                if (tipoIdentificacion == '' || identificacion == '' || nombres == '' || apellidos == '' || correo == '' || fechaNacimiento == '' || telefono == '' || acudiente_id == '' || grupo_id == '') {
                    toastr.warning("Complete todos los campos")
                }
                else {
                    $.ajax({
                        url: '/api/estudiantes/' + id,
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        type: 'PUT',
                        data: {
                            tipoIdentificacion: tipoIdentificacion,
                            identificacion: identificacion,
                            nombres: nombres,
                            apellidos: apellidos,
                            edad: edad,
                            telefono: telefono,
                            correo: correo,
                            fechaNacimiento: fechaNacimiento,
                            acudiente_id: acudiente_id,
                            grupo_id: grupo_id

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

    $('#estudiantes-table').on('click', '[id^=Btn_delete_]', function () {
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
                    url: "/api/estudiantes/" + id,
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

    $("#add-estudiante").on('click', function () {
        modal.modal('show');
        Modal()
        LoadAcudiente()
        LoadCurso()

        $('#save').on('click', function () {
            var tipoIdentificacion = $("#tipoIdentificacion").val(),
                identificacion = $("#identificacion").val(),
                nombres = $("#nombres").val(),
                apellidos = $("#apellidos").val(),
                correo = $("#correo").val(),
                fechaNacimiento = $("#fechaNacimiento").val(),
                edad = calcularEdad(fechaNacimiento),
                telefono = $("#telefono").val(),
                acudiente_id = $('#acudiente_id').val(),
                grupo_id = $('#grupo_id').val();

            if (tipoIdentificacion == '' || identificacion == '' || nombres == '' || apellidos == '' || correo == '' || fechaNacimiento == '' || telefono == '' || acudiente_id == '' || grupo_id == '') {
                toastr.warning("Complete todos los campos")
            }
            else {
                $.ajax({
                    url: '/api/estudiantes',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    data: {
                        tipoIdentificacion: tipoIdentificacion,
                        identificacion: identificacion,
                        nombres: nombres,
                        apellidos: apellidos,
                        edad: edad,
                        telefono: telefono,
                        correo: correo,
                        fechaNacimiento: fechaNacimiento,
                        acudiente_id: acudiente_id,
                        grupo_id: grupo_id

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

    });


});

function calcularEdad(fecha) {
    var hoy = new Date();
    var dt = Date.parse(fecha)
    var cumpleanos = new Date(dt);
    var edad = hoy.getFullYear() - cumpleanos.getFullYear();
    var m = hoy.getMonth() - cumpleanos.getMonth();

    if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
        edad--;
    }

    return edad;
}

function LoadAcudiente() {
    $("#acudiente_id").select2({
        placeholder: 'Seleccione un acudiente',
        allowClear: true,
        dropdownParent: modal,
        width: 'resolve'
    });

    $.ajax({
        url: '/api/acudientes',
    })
        .done(function (response) {
            for (var i in response.data) {
                $("#acudiente_id").append(`<option value='${response.data[i].id}'>${response.data[i].nombres} ${response.data[i].apellidos}</option>`)
            }

        })
        .fail(function () {
            console.log("error");
        })
}

function LoadCurso() {
    $("#grupo_id").select2({
        placeholder: 'Seleccione un grupo',
        allowClear: true,
        dropdownParent: modal,
        width: 'resolve'
    });

    $.ajax({
        url: '/api/grupos',
    })
        .done(function (response) {
            for (var i in response.data) {
                $("#grupo_id").append(`<option value='${response.data[i].id}'>${response.data[i].grado} - ${response.data[i].curso}</option>`)
            }

        })
        .fail(function () {
            console.log("error");
        })
}

function Reload() {
    $.ajax({
        url: "/api/estudiantes",
        type: "GET",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        dataType: "JSON",
    })

        .done(function (response) {
            if (response.length != 0) {
                AllRegister = response.data;

                DataTable(response.data);
            } else {
                $('#estudiantes-table').dataTable().fnClearTable();
                $('#estudiantes-table').dataTable().fnDestroy();
                $('#estudiantes-table thead').empty()
            }
        })

        .fail(function () {
            console.log("error");
        });
}

function Modal() {
    modal.find('.modal-content').empty().append(`
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Formulario de Estudiantes</h4>
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

                    <div class="form-group">
                        <label >Acudiente: </label>
                        <div class="input-group">
                            <select class="form-control" id="acudiente_id" style="width: 100%;">

                            </select>
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
                        <label >Curso: </label>
                        <div class="input-group">
                            <select class="form-control" id="grupo_id" style="width: 100%;">

                            </select>
                        </div>
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

function DataTable(response) {

    console.log(response)
    if ($.fn.DataTable.isDataTable('#estudiantes-table')) {
        $('#estudiantes-table').dataTable().fnClearTable();
        $('#estudiantes-table').dataTable().fnDestroy();
        $('#estudiantes-table thead').empty()
    }
    else {
        $('#estudiantes-table thead').empty()
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

                                    <a data-id=${row.id} id="Btn_Edit_${row.id}" class='btn btn-circle btn-sm btn-info'>
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

            else if (key == 'tipoIdentificacion') {

                my_item.title = 'Tipo ID';

                my_item.render = function (data, type, row) {
                    return `  <div'> 
                                ${row.tipoIdentificacion}
                            </div>`
                }
                my_columns.push(my_item);
            }

            else if (key == 'identificacion') {

                my_item.title = 'Identificacion';

                my_item.render = function (data, type, row) {
                    return `<div>
                                ${row.identificacion} 
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

            else if (key == 'edad') {

                my_item.title = 'Edad';

                my_item.render = function (data, type, row) {
                    return `<div>
                                ${row.edad} 
                            </div>`
                }
                my_columns.push(my_item);
            }

            else if (key == 'telefono') {

                my_item.title = 'Contacto';

                my_item.render = function (data, type, row) {
                    return `<div>
                                ${row.telefono}
                            </div>`
                }
                my_columns.push(my_item);
            }

            else if (key == 'correo') {

                my_item.title = 'Correo';

                my_item.render = function (data, type, row) {
                    return `<div>
                                ${row.correo} 
                            </div>`
                }
                my_columns.push(my_item);
            }
            else if (key == 'nombre_acudiente') {

                my_item.title = 'Acudiente';

                my_item.render = function (data, type, row) {
                    return `<div>
                                ${row.nombre_acudiente + " " + row.apellido_acudiente} 
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

        })

        $('#estudiantes-table').DataTable({
            "responsive": true,
            "destroy": false,
            data: response,
            "columns": my_columns,
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No hay datos registrados",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ estudiantes",
                "infoEmpty": "No hay estudiantes registrados",
                "infoFiltered": "(Filtrado de _MAX_  estudiantes)",
                "lengthMenu": "_MENU_ estudiantes",
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
                { "width": "20%", "targets": 8 },
                { "width": "20%", "targets": 3 }
            ],

            "lengthMenu": [
                [10, 15, 20, -1],
                [10, 15, 20, "Todos"]
            ]
        });
    }
}

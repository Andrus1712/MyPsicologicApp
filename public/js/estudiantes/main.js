var modal = $("#modal-estudiantes")
var AllRegister = []

var permisos = [];


$(document).ready(function () {
    Reload()

    $("#estudiantes-table").on('click', '[id^=Btn_Edit_]', function () {

        var id = $(this).attr('data-id')
        var filtro = AllRegister.filter(f => f.id == id);

        if (filtro.length != 0) {
            modal.modal('show');
            Modal()
            LoadAcudiente(filtro[0].id_acudiente);
            LoadCurso(filtro[0].grupo_id)

            $("#save").text("Actualizar")
            $("#save").attr("id", 'update')

            $("#identificacion").val(filtro[0].identificacion)
            $("#identificacion").attr("readonly", true)

            $("#nombres").val(filtro[0].nombres)
            $("#apellidos").val(filtro[0].apellidos)
            $("#telefono").val(filtro[0].telefono)
            $("#genero").val(filtro[0].sexo)
            $("#correo").val(filtro[0].correo)
            $("#direccion").val(filtro[0].direccion)
            $('#acudiente_id').val(filtro[0].id_acudiente),
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
                    sexo = $("#genero").val(),
                    fechaNacimiento = $("#fechaNacimiento").val(),
                    edad = calcularEdad(fechaNacimiento),
                    telefono = $("#telefono").val(),
                    acudiente_id = $('#acudiente_id').val(),
                    grupo_id = $('#grupo_id').val();

                if (tipoIdentificacion == '' || identificacion == '' || nombres == '' || apellidos == '' || correo == '' || fechaNacimiento == '' || telefono == '' || acudiente_id == '' || grupo_id == '') {
                    toastr.warning("Complete todos los campos")
                } else if (validar_fecha(fechaNacimiento) == false) {
                    toastr.warning("Fecha no valida");
                } else {

                    $('#loading-spinner').show();
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
                            sexo: sexo,
                            correo: correo,
                            fechaNacimiento: fechaNacimiento,
                            acudiente_id: acudiente_id,
                            grupo_id: grupo_id

                        },
                    })
                        .done(function (response) {
                            toastr.success("Datos editados correctamente");
                            setTimeout(function () {
                                $('#loading-spinner').hide();
                                modal.modal("hide")
                            }, 600);
                            Reload();
                        })
                        .fail(function (response) {
                            $('#loading-spinner').hide();
                            // console.log(response.responseJSON);
                            if (response.responseJSON.message == "id-registrada") {
                                toastr.warning("La identificacion ya se encuentra registrada");
                            } else {
                                toastr.error("Ha ocurrido un error");
                            }
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
                sexo = $("#genero").val(),
                acudiente_id = $('#acudiente_id').val(),
                grupo_id = $('#grupo_id').val();


            if (tipoIdentificacion == '' || identificacion == '' || nombres == '' || apellidos == '' || correo == '' || fechaNacimiento == '' || sexo == '' || telefono == '' || acudiente_id == '' || grupo_id == '') {
                toastr.warning("Complete todos los campos");
            } else if (validar_fecha(fechaNacimiento) == false) {
                toastr.warning("Fecha no valida");
            } else {

                toastr.success("ingresado");
                $('#loading-spinner').show();

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
                        sexo: sexo,
                        telefono: telefono,
                        correo: correo,
                        fechaNacimiento: fechaNacimiento,
                        acudiente_id: acudiente_id,
                        grupo_id: grupo_id

                    },
                })
                    .done(function () {
                        toastr.success("estudiante agregado");
                        setTimeout(function () {
                            $('#loading-spinner').hide();
                            modal.modal("hide")
                        }, 600);
                        Reload();
                    })
                    .fail(function (response) {
                        $('#loading-spinner').hide();
                        // console.log(response.responseJSON);
                        if (response.responseJSON.message == "id-registrada") {
                            toastr.warning("La identificacion ya se encuentra registrada");
                        } else {
                            toastr.error("Ha ocurrido un error");
                        }
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

function LoadAcudiente(id) {
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

            $("#acudiente_id").val(id);

        })
        .fail(function () {
            console.log("error");
        })
}

function LoadCurso(id) {
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

            $("#grupo_id").val(id);
        })
        .fail(function () {
            console.log("error");
        })
}

function Reload() {
    $.ajax({
        url: "/getEstudiantes",
        type: "GET",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        dataType: "JSON",
    })

        .done(function (response) {
            if (response.length != 0) {
                AllRegister = response.estudiantes;
                // console.log(AllRegister);
                permisos = response.permisos;
                // console.table(permisos.permisos);
                DataTable(response.estudiantes);
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

function validar_fecha(fecha) {
    var hoy = new Date();
    hoy.setMinutes(hoy.getMinutes() - hoy.getTimezoneOffset());
    hoy = hoy.toJSON().slice(0, 10);


    if (fecha < hoy) {
        return true;
    } else if (fecha == hoy) {
        return false;
    } else {
        return false;
    }
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
                            <input type="text"  maxlength="10" class="form-control" placeholder="Identificación" id="identificacion">
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
                            <label>Sexo: </label>
                            <select class="form-control" id="genero" name="state">
                                <option value="">Seleccione</option>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>
                        </div>

                    <div class="form-group">
                        <label>Telefono: </label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <input type="text" class="form-control" id="telefono" maxlength="10">
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
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
    `)
    $("#timepicker").datetimepicker({
        format: "YYYY-MM-DD"
    });

    // Listen for the input event.
    jQuery("#identificacion").on('input', function (evt) {
        // Allow only numbers.
        jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
    });
    jQuery("#telefono").on('input', function (evt) {
        // Allow only numbers.
        jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
    });

    var hoy = new Date();
    hoy.setMinutes(hoy.getMinutes() - hoy.getTimezoneOffset());
    hoy = hoy.toJSON().slice(0, 10);
    $('#fechaNacimiento').val(hoy);
}

function DataTable(response) {


    if ($.fn.DataTable.isDataTable('#estudiantes-table')) {
        $('#estudiantes-table').dataTable().fnClearTable();
        $('#estudiantes-table').dataTable().fnDestroy();
        $('#estudiantes-table thead').empty()
    } else {
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
                    var html = '';
                    for (let i = 0; i < permisos.length; i++) {
                        if (permisos[i] == "delete.estudiantes") {
                            html += `
                                    <a data-id=${row.id} id="Btn_delete_${row.id}" class='btn btn-circle btn-sm btn-danger'>
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a> `
                        } else if (permisos[i] == "edit.estudiantes") {
                            html += `
                                    <a data-id=${row.id} id="Btn_Edit_${row.id}" class='btn btn-circle btn-sm btn-primary'>
                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                    </a>
                                    `
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

            } 
            // else if (key == 'id') {

            //     my_item.title = '#';

            //     my_item.render = function (data, type, row) {
            //         return `  <div'> 
            //                     ${row.id}
            //                 </div>`
            //     }
            //     my_columns.push(my_item);


            // } else if (key == 'tipoIdentificacion') {

            //     my_item.title = 'Tipo ID';

            //     my_item.render = function (data, type, row) {
            //         return `  <div'> 
            //                     ${row.tipoIdentificacion}
            //                 </div>`
            //     }
            //     my_columns.push(my_item);
            // } 
            else if (key == 'identificacion') {

                my_item.title = 'Identificacion';

                my_item.render = function (data, type, row) {
                    return `<div>
                                ${row.identificacion} 
                            </div>`
                }
                my_columns.push(my_item);
            } else if (key == 'nombres') {

                my_item.title = 'Estudiante';

                my_item.render = function (data, type, row) {
                    return `<div>
                                ${row.nombres + " " + row.apellidos} 
                            </div>`
                }
                my_columns.push(my_item);
            } else if (key == 'edad') {

                my_item.title = 'Edad';

                my_item.render = function (data, type, row) {
                    return `<div>
                                ${row.edad} años
                            </div>`
                }
                my_columns.push(my_item);
            } else if (key == 'sexo') {

                my_item.title = 'Genero';

                my_item.render = function (data, type, row) {
                    return `<div>
                                ${row.sexo}
                            </div>`
                }
                my_columns.push(my_item);
            } else if (key == 'telefono') {

                my_item.title = 'Contacto';

                my_item.render = function (data, type, row) {
                    return `<div>
                                ${row.telefono}
                            </div>`
                }
                my_columns.push(my_item);
            } else if (key == 'correo') {

                my_item.title = 'Correo';

                my_item.render = function (data, type, row) {
                    return `<div>
                                ${row.correo} 
                            </div>`
                }
                my_columns.push(my_item);
            } else if (key == 'nombre_acudiente') {

                my_item.title = 'Acudiente';

                my_item.render = function (data, type, row) {
                    return `<div>
                                ${row.nombre_acudiente + " " + row.apellido_acudiente} 
                            </div>`
                }
                my_columns.push(my_item);
            } else if (key == 'grado') {

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
            "scrollX": my_columns.length >= 10 ? true : false,
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
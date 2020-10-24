var modal = $('#modal-user');
var AllRegister = []

var permisos = []


$(document).ready(function () {
    Reload()

    $('#add-user').on('click', function () {
        modal.modal('show')
        Modal()
        LoadRoles()

        $('#save').on('click', function () {
            var name = $('#name').val(),
                email = $('#email').val(),
                password = $('#password').val(),
                passwordC = $('#passwordC').val(),
                role_id = $('#role_id').val();

            if (name == '' | email == '' || password == '' || passwordC == '' || role_id == '') {
                toastr.warning("Complete todos los campos")
            } else {

                if (password != passwordC) {
                    toastr.warning("Las contraseñas deben ser iguales")
                } else {
                    $.ajax({
                        url: '/api/usuarios',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        type: 'POST',
                        data: {
                            name: name,
                            email: email,
                            password: password,
                            role_id: role_id,
                        }
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
            }
        })
    })

    $('#user-table').on('click', '[id^=Btn_rol_]', function () {
        var id = $(this).attr('data-id');

        const filtro = AllRegister.filter(f => f.id == id);

        if (filtro != 0) {
            modal.modal('show');
            ModalRol();
            LoadRoles();

            $("#save").text("Actualizar")
            $("#save").attr("id", 'update')

            $('#name').val(filtro[0].name);

            $("#update").on('click', function () {
                var role_id = $('#role_id').val();

                if (role_id == '') {
                    toastr.warning("Selecione una opcion")
                } else {
                    $.ajax({
                        url: '/api/usuarios/' + id,
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        type: 'PUT',
                        data: {
                            role_id: role_id,
                        }
                    })
                        .done(function () {
                            toastr.info("rol establecido correctamente");
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
        }

    })

    $('#user-table').on('click', '[id^=Btn_Edit_]', function () {
        var id = $(this).attr('data-id');

        const filtro = AllRegister.filter(f => f.id == id);

        if (filtro != 0) {
            modal.modal('show')
            Modal()

            $("#save").text("Actualizar")
            $("#save").attr("id", 'update')

            $('#campo-rol').hide();
            $('#name').val(filtro[0].name);
            $('#email').val(filtro[0].email);

            $("#update").on('click', function () {
                var name = $('#name').val(),
                    email = $('#email').val(),
                    password = $('#password').val(),
                    passwordC = $('#passwordC').val();
                // role_id = $('#role_id').val();


                if (name == '' | email == '' || password == '' || passwordC == '') {
                    toastr.warning("Complete todos los campos")
                } else {

                    if (password != passwordC) {
                        toastr.warning("Las contraseñas deben ser iguales")
                    } else {
                        $.ajax({
                            url: '/api/usuarios/' + id,
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            type: 'PUT',
                            data: {
                                name: name,
                                email: email,
                                password: password,
                                // role_id: role_id,
                            }
                        })
                            .done(function () {
                                toastr.info("usuario editado correctamente");
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
                }
            })
        }
    })

    $('#user-table').on('click', '[id^=Btn_delete_]', function () {
        var id = $(this).attr('data-id')

        swal({
            title: "¿Realmente deseas eliminar el usuario?",
            text: "Ten en cuenta que eliminaras toda su información del sistema",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Si, eliminar",
            closeOnConfirm: false
        },
            function () {
                $.ajax({
                    url: "/api/usuarios/" + id,
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

})

function ModalRol() {
    modal.find('.modal-content').empty().append(`
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Asignar Rol</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">

                <div class="form-group">
                    <label>Nombre de usuario: </label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" class="form-control" placeholder="Nombres" id="name" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label >Rol: </label>
                    <div class="input-group">
                        <select class="form-control" id="role_id" style="width: 100%;">

                        </select>
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
}

function Modal() {
    modal.find('.modal-content').empty().append(`
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Formulario de Usuarios</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">

                <div class="form-group">
                    <label>Nombre de usuario: </label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" class="form-control" placeholder="Nombres" id="name">
                    </div>
                </div>

                <div class="form-group">
                    <label>Email: </label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        <input type="text" class="form-control" placeholder="Email" id="email">
                    </div>
                </div>

                <div class="form-group">
                    <label>Contraseña: </label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        <input type="password" class="form-control" placeholder="Contraseña" id="password">
                    </div>
                </div>

                <div class="form-group">
                    <label>Confirmar Contraseña: </label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        <input type="password" class="form-control" placeholder="Confirmar contraseña" id="passwordC">
                    </div>
                </div>

                <div class="form-group" id="campo-rol">
                    <label >Rol: </label>
                    <div class="input-group">
                        <select class="form-control" id="role_id" style="width: 100%;">

                        </select>
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
}

function Reload() {
    $.ajax({
        url: "/getUsuarios",
        type: "GET",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        dataType: "JSON",
    })

        .done(function (response) {
            if (response.length != 0) {
                AllRegister = response.usuarios;
                permisos = response.permisos;
                DataTable(response.usuarios);
            } else {
                $('#user-table').dataTable().fnClearTable();
                $('#user-table').dataTable().fnDestroy();
                $('#user-table thead').empty()
            }
        })

        .fail(function () {
            console.log("error");
        });
}

function LoadRoles() {
    $("#role_id").select2({
        placeholder: 'Seleccione un rol',
        allowClear: true,
        dropdownParent: modal,
        width: 'resolve'
    });

    $.ajax({
        url: '/api/roles',
    })
        .done(function (response) {
            for (var i in response.data) {
                $("#role_id").append(`<option value='${response.data[i].id}'>${response.data[i].name}</option>`)
            }

        })
        .fail(function () {
            console.log("error");
        })
}

function convertUTCDateToLocalDate(date) {
    var newDate = new Date(date.getTime() + date.getTimezoneOffset() * 60 * 1000);

    var offset = date.getTimezoneOffset() / 60;
    var hours = date.getHours();

    newDate.setHours(hours - offset);

    return newDate;
}


function DataTable(response) {
    if ($.fn.DataTable.isDataTable('#user-table')) {
        $('#user-table').dataTable().fnClearTable();
        $('#user-table').dataTable().fnDestroy();
        $('#user-table thead').empty()
    }
    else {
        $('#user-table thead').empty()
    }

    if (response.length != 0) {
        let my_columns = []
        $.each(response[0], function (key, value) {
            var my_item = {};
            // my_item.class = "filter_C";
            my_item.data = key;

            if (key == 'roles') {

                my_item.title = 'Acción';

                my_item.render = function (data, type, row) {
                    var html = '';
                    for (let i = 0; i < permisos.length; i++) {
                        if (permisos[i] == "delete.user") {
                            html += `
                                    <a data-id=${row.id} id="Btn_delete_${row.id}" class='btn btn-circle btn-sm btn-danger'>
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a> `
                        } else if (permisos[i] == "edit.user") {
                            html += `
                                    <a data-id=${row.id} id="Btn_rol_${row.id}" class='btn btn-circle btn-sm btn-warning'>
                                        <i class="fa fa-key" aria-hidden="true"></i>
                                    </a>
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

            else if (key == 'name') {

                my_item.title = 'Nombre';

                my_item.render = function (data, type, row) {
                    return `  <div> 
                                ${row.name}
                            </div>`
                }
                my_columns.push(my_item);
            }

            else if (key == 'email') {

                my_item.title = 'Email';

                my_item.render = function (data, type, row) {
                    return `<div>
                                ${row.email} 
                            </div>`
                }
                my_columns.push(my_item);
            }

            else if (key == 'created_at') {

                my_item.title = 'Rol';

                my_item.render = function (data, type, row) {
                    if (row.roles.length != 0) {
                        return `<div>
                                ${row.roles[0].name} 
                            </div>`
                    } else {
                        return `NaN`;
                    }

                }
                my_columns.push(my_item);
            } else {
                my_item.title = 'created At';

                my_item.render = function (data, type, row) {
                    return `  <div> 
                                ${new Date(row.created_at)}
                            </div>`
                }
                my_columns.push(my_item);
            }


        })

        $('#user-table').DataTable({
            responsive: false,
            'scrollX': screen.width < 400 ? true : false,
            "destroy": true,
            data: response,
            "columns": my_columns,
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No hay datos registrados",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ usuarios",
                "infoEmpty": "No hay usuarios registrados",
                "infoFiltered": "(Filtrado de _MAX_  user)",
                "lengthMenu": "_MENU_ usuarios",
                "search": "Buscar:",
                "zeroRecords": "No se han encontrado registros"
            },
            //dom: 'Bfrtilp',
            buttons: [

            ],

            "order": [
                [0, 'asc']
            ],

            "columnDefs": [
                { "width": "20%", "targets": 1 },
                { "width": "20%", "targets": 2 },
                { "width": "15%", "targets": 5 },
            ],

            "lengthMenu": [
                [10, 15, 20, -1],
                [10, 15, 20, "Todos"]
            ]
        });

        $('thead > tr> th:nth-child(1)').css({ 'min-width': '30px', 'max-width': '30px' });
        $('thead > tr> th:nth-child(2)').css({ 'min-width': '100px', 'max-width': '100px' });
        $('thead > tr> th:nth-child(3)').css({ 'min-width': '160px', 'max-width': '160px' });
        $('thead > tr> th:nth-child(4)').css({ 'min-width': '80px', 'max-width': '80px' });
        $('thead > tr> th:nth-child(5)').css({ 'min-width': '120px', 'max-width': '120px' });
        $('thead > tr> th:nth-child(6)').css({ 'min-width': '120px', 'max-width': '120px' });


    }

}
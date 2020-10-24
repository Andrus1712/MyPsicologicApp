var modal = $('#modal-roles');
var AllRegister = []

var permisos = [];

$(document).ready(function () {
    Reload()

    $('#add-roles').on('click', function () {
        modal.modal('show');
        Modal();
        var ArrayPermisos = [];

        $('#ver_all').on('click', function () {
            var checked = this.checked;
            $('input[name="ver"]').each(function () {
                this.checked = checked;
            });
        });
        $('#editar_all').on('click', function () {
            var checked = this.checked;
            $('input[name="editar"]').each(function () {
                this.checked = checked;
            });
        });
        $('#sistema_all').on('click', function () {
            var checked = this.checked;
            $('input[name="sistema"]').each(function () {
                this.checked = checked;
            });
        });
        $('#especial_all').on('click', function () {
            var checked = this.checked;
            $('input[name="especial"]').each(function () {
                this.checked = checked;
            });
        });
        $('#crear_all').on('click', function () {
            var checked = this.checked;
            $('input[name="crear"]').each(function () {
                this.checked = checked;
            });
        });
        $('#eliminar_all').on('click', function () {
            var checked = this.checked;
            $('input[name="eliminar"]').each(function () {
                this.checked = checked;
            });
        });

        $('#save').on('click', function () {

            var name = $('#name').val(),
                descripcion = $('#descripcion').val();

            var substr = name.substr(0, 3);
            var slug = substr.concat("-user");

            $("input:checkbox:checked").each(
                function () {
                    if ($(this).val() != 'on') {
                        ArrayPermisos.push($(this).val());
                        // alert("El checkbox con valor " + $(this).val() + " está seleccionado");
                    }
                }
            );

            //console.table(ArrayPermisos);

            if (name == '') {
                toastr.warning("Complete todos los campos")
            } else {
                $.ajax({
                    url: '/api/roles',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    data: {
                        name: name,
                        slug: slug,
                        descripcion: descripcion,
                        permission: ArrayPermisos,
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
        })
    })

    $('#roles-table').on('click', '[id^=Btn_Edit_]', function () {
        var id = $(this).attr('data-id');
        const filtro = AllRegister.filter(f => f.id == id);

        if (filtro != 0) {
            modal.modal('show')
            Modal()

            var ArrayPermisos = [];

            $('#ver_all').on('click', function () {
                var checked = this.checked;
                $('input[name="ver"]').each(function () {
                    this.checked = checked;
                });
            });
            $('#editar_all').on('click', function () {
                var checked = this.checked;
                $('input[name="editar"]').each(function () {
                    this.checked = checked;
                });
            });
            $('#sistema_all').on('click', function () {
                var checked = this.checked;
                $('input[name="sistema"]').each(function () {
                    this.checked = checked;
                });
            });
            $('#especial_all').on('click', function () {
                var checked = this.checked;
                $('input[name="especial"]').each(function () {
                    this.checked = checked;
                });
            });
            $('#crear_all').on('click', function () {
                var checked = this.checked;
                $('input[name="crear"]').each(function () {
                    this.checked = checked;
                });
            });
            $('#eliminar_all').on('click', function () {
                var checked = this.checked;
                $('input[name="eliminar"]').each(function () {
                    this.checked = checked;
                });
            });

            $("#save").text("Actualizar")
            $("#save").attr("id", 'update')

            $('#name').val(filtro[0].name);
            $('#descripcion').val(filtro[0].descripcion);



            var datos = filtro[0].permissions;

            $.each(datos, function (i, value) {
                $("input[id=" + value.id + " ]").prop("checked", true);
            });
            // $("input:checkbox").each(
            //     function () {
            //         $("input[type=checkbox]").prop("checked", true);
            //     }
            // );


            $("#update").on('click', function () {
                var name = $('#name').val(),
                    descripcion = $('#descripcion').val();
                var substr = name.substr(0, 3);
                var slug = substr.concat("-user");

                $("input:checkbox:checked").each(
                    function () {
                        if ($(this).val() != 'on') {
                            ArrayPermisos.push($(this).val());
                            // mandamos el valor del slug
                        }
                    }
                );

                if (name == '') {
                    toastr.warning("Complete todos los campos")
                } else {
                    $.ajax({
                        url: '/api/roles/' + id,
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        type: 'PUT',
                        data: {
                            name: name,
                            slug: slug,
                            descripcion: descripcion,
                            permission: ArrayPermisos,
                        }
                    })
                        .done(function () {
                            toastr.info("Rol actualizado");
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

    $('#roles-table').on('click', '[id^=Btn_delete_]', function () {
        var id = $(this).attr('data-id')

        swal({
            title: "¿Realmente deseas eliminar el Rol?",
            text: "Ten en cuenta que eliminaras toda su información del sistema",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Si, eliminar",
            closeOnConfirm: false
        },
            function () {
                $.ajax({
                    url: "/api/roles/" + id,
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
/*
ver:                    codigo permiso
1 ver estudiantes           v1
2 ver docentes              v2
3 ver acudientes            v3
4 ver psicologos            v4
5 ver comportamientos       v5
6 ver actividades           v6
7 ver avances               v7
8 ver cursos                v8

editar
1 editar estudiantes        e1
2 editar docentes           e2
3 editar acudientes         e3
4 editar psicologos         e4
5 editar comportamientos    e5
6 editar actividades        e6
7 editar avances            e7
8 editar cursos             e8

eliminar
1 elimnar estudiantes       d1
2 eliminar docentes         d2
3 eliminar acudientes       d3
4 eliminar psicologos       d4
5 eliminar comportamientos  d5
6 eliminar actividades      d6
7 eliminar avances          d7
8 eliminar cursos           d8

crear
1 crear estudiantes         c1
2 crear docentes            c2
3 crear acudientes          c3
4 crear psicologos          c4
5 crear comportamientos     c5
6 crear actividades         c6
7 crear avances             c7
8 crear cursos              c8

seguimiento
1 generar reportes          x9
2 Modulo seguimientos       x10

sistema
1 crear usuarios            x1
2 editar usuarios           x2
3 eliminar usuarios         x3
4 ver usuarios              x4

1 crear roles               x5
2 editar roles              x6
3 eliminar roles            x7
4 ver roles                 x8

*/

function Modal() {
    modal.find('.modal-content').empty().append(`
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Formulario de Roles</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">

                <div class="form-group">
                    <label>Nombre de Rol: </label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-book"></i></span>
                        <input type="text" class="form-control" placeholder="Rol" id="name">
                    </div>
                </div>

                </div>
                <div class="col-md-6">

                <div class="form-group">
                    <label>Descripcion: </label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-book"></i></span>
                        <input type="text" class="form-control" placeholder="Descripcion" id="descripcion">
                    </div>
                </div>

            </div>
        </div>
        <label>Permisos: </label>
        <div class="row">

            <div class="col-md-6">

                <label style="margin-right: 15px;">Ver: </label> 
                <label><input id="ver_all" type="checkbox">Select all</input></label>
                <div class="form-group">

                    <div class="checkbox">
                        <label>
                            <input id="1" value="show.estudiantes" name="ver" type="checkbox">ver estudiantes
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="2" value="show.docentes" name="ver" type="checkbox">ver docentes
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="3" value="show.acudientes" name="ver"type="checkbox">ver acudientes
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="4" value="show.psicologos" name="ver" type="checkbox">ver psicoorentadores
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="5" value="show.comportamientos" name="ver" type="checkbox">ver comportamientos
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="6" value="show.actividades" name="ver" type="checkbox">ver actividades  
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="7" value="show.avances" name="ver" type="checkbox">ver avances  
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="8" value="show.cursos" name="ver" type="checkbox">ver cursos 
                        </label>
                    </div>
                    
                    
                    <label style="margin-right: 15px;">Editar: </label>
                    <label><input id="editar_all" type="checkbox">Select all</input></label>
                    <div class="checkbox">
                        <label>
                            <input id="9" value="edit.estudiantes" name="editar" type="checkbox">editar estudiantes
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="10" value="edit.docentes" name="editar" type="checkbox">editar docentes
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="11" value="edit.acudientes" name="editar" type="checkbox">edtar acudientes
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="12" value="edit.psicologos" name="editar" type="checkbox">editar psicoorentadores
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="13" value="edit.comportamientos" name="editar" type="checkbox">editar comportamientos
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="14" value="edit.actividades" name="editar" type="checkbox">editar actividades  
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="15" value="edit.avances" name="editar" type="checkbox">editar avances  
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="16" value="edit.cursos" name="editar" type="checkbox">editar cursos 
                        </label>
                    </div>

                    <label style="margin-right: 15px;">Sistema: </label>
                    <label><input id="sistema_all" type="checkbox">Select all</input></label>
                    <div class="checkbox">
                        <label>
                            <input id="35" value="create.user" name="sistema" type="checkbox">crear usuarios
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="36" value="edit.user" name="sistema" type="checkbox">editar usuarios
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="37" value="delete.user" name="sistema" type="checkbox">eliminar usuarios
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="38" value="show.user" name="sistema" type="checkbox">ver usuarios
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="39" value="create.roles" name="sistema" type="checkbox">crear roles
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="40" value="edit.roles" name="sistema" type="checkbox">editar roles  
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="41" value="delete.roles" name="sistema" type="checkbox">eliminar roles  
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="42" value="show.roles" name="sistema" type="checkbox">ver roles 
                        </label>
                    </div>

                </div>


            </div>
            <div class="col-md-6">
                <div class="form-group">

                    <label style="margin-right: 15px;">Crear: </label>
                    <label><input id="crear_all" type="checkbox">Select all</input></label>
                    <div class="checkbox">
                        <label>
                            <input id="25" value="create.estudiantes" name="crear" type="checkbox">crear estudiantes
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="26" value="create.docentes" name="crear" type="checkbox">crear docentes
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="27" value="create.acudientes" name="crear" type="checkbox">crear acudientes
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="28" value="create.psicologos" name="crear" type="checkbox">crear psicoorentadores
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="29" value="create.comportamientos" name="crear" type="checkbox">crear comportamientos
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="30" value="create.actividades" name="crear" type="checkbox">crear actividades  
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="31" value="create.avances" name="crear" type="checkbox">crear avances  
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="32" value="create.cursos" name="crear" type="checkbox">crear cursos 
                        </label>
                    </div>

                    <label style="margin-right: 15px;">Eliminar: </label>
                    <label><input id="eliminar_all" type="checkbox">Select all</input></label>
                    <div class="checkbox">
                        <label>
                            <input id="17" value="delete.estudiantes" name="eliminar" type="checkbox">eliminar estudiantes
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="18" value="delete.docentes" name="eliminar" type="checkbox">eliminar docentes
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="19" value="delete.acudientes" name="eliminar" type="checkbox">eliminar acudientes
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="20" value="delete.psicologos" name="eliminar" type="checkbox">eliminar psicoorentadores
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="21" value="delete.comportamientos" name="eliminar" type="checkbox">eliminar comportamientos
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="22" value="delete.actividades" name="eliminar" type="checkbox">eliminar actividades  
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="23" value="delete.avances" name="eliminar" type="checkbox">eliminar avances  
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="24" value="delete.cursos" name="eliminar" type="checkbox">eliminar cursos 
                        </label>
                    </div>
                

                    <label style="margin-right: 15px;">Especial: </label>
                    <label><input id="especial_all" type="checkbox">Select all</input></label>
                    <div class="checkbox">
                        <label>
                            <input id="33" value="make.reportes" name="especial" type="checkbox">generar reportes
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="34" value="modulo.seguimiento" name="especial" type="checkbox">modulo seguimiento
                        </label>
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
        url: "/getRoles",
        type: "GET",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        dataType: "JSON",
    })

        .done(function (response) {
            if (response.length != 0) {
                AllRegister = response.roles;
                permisos = response.permisos;
                DataTable(response.roles);
            } else {
                $('#roles-table').dataTable().fnClearTable();
                $('#roles-table').dataTable().fnDestroy();
                $('#roles-table thead').empty()
            }
        })

        .fail(function () {
            console.log("error");
        });
}

function multiple(valor, multiple) {
    var resto = valor % multiple;
    if (resto == 0)
        return true;
    else
        return false;
}

function DataTable(response) {
    if ($.fn.DataTable.isDataTable('#roles-table')) {
        $('#roles-table').dataTable().fnClearTable();
        $('#roles-table').dataTable().fnDestroy();
        $('#roles-table thead').empty()
    }
    else {
        $('#roles-table thead').empty()
    }

    if (response.length != 0) {
        let my_columns = []
        $.each(response[0], function (key, value) {
            var my_item = {};
            // my_item.class = "filter_C";
            my_item.data = key;
            if (key == 'permissions') {

                my_item.title = 'Acción';

                my_item.render = function (data, type, row) {
                    var html = '';
                    for (let i = 0; i < permisos.length; i++) {
                        if (permisos[i] == "delete.roles") {
                            html += `
                                    <a data-id=${row.id} id="Btn_delete_${row.id}" class='btn btn-circle btn-sm btn-danger'>
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a> `;
                        } else if (permisos[i] == "edit.roles") {
                            html += `
                                    <a data-id=${row.id} id="Btn_Edit_${row.id}" class='btn btn-circle btn-sm btn-primary'>
                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                    </a>`;
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

            else if (key == 'descripcion') {

                my_item.title = 'Descripcion';

                my_item.render = function (data, type, row) {
                    return `<div>
                                ${row.descripcion} 
                            </div>`
                }
                my_columns.push(my_item);
            }
            else if (key == 'created_at') {

                my_item.title = 'Permisos';

                my_item.render = function (data, type, row) {

                    var html = '';

                    if (row.permissions.length != 0) {
                        for (var i = 0; i < row.permissions.length; i++) {
                            html += `<span style="margin-right: 5px;" class="label label-default">
                                        ${row.permissions[i].name}
                                    </span>`

                            if (i > 2 && multiple(i, 4)) {
                                html += `<br>`
                            }
                        }
                        return `<div class="pull-right-container">
                                    ${html}
                                </div>`;
                    } else {
                        return `NaN`;
                    }

                }
                my_columns.push(my_item);
            }

        })

        $('#roles-table').DataTable({
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
                "infoFiltered": "(Filtrado de _MAX_  roles)",
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

            // "columnDefs": [
            //     { "width": "30%", "targets": 2 }
            // ],

            // "lengthMenu": [
            //     [10, 15, 20, -1],
            //     [10, 15, 20, "Todos"]
            // ]
        });


    }

}
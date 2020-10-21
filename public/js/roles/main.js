var modal = $('#modal-roles');
var AllRegister = []

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
                slug = $('#slug').val();

            $("input:checkbox:checked").each(
                function () {
                    if($(this).val() != 'on'){
                        ArrayPermisos.push($(this).val());
                        // alert("El checkbox con valor " + $(this).val() + " está seleccionado");
                    }
                }
            );

            console.table(ArrayPermisos);

            if (name == '' | slug == '') {
                toastr.warning("Complete todos los campos")
            } else {
                $.ajax({
                    url: '/api/roles',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    data: {
                        name: name,
                        slug: slug,
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

            $("#save").text("Actualizar")
            $("#save").attr("id", 'update')

            $('#name').val(filtro[0].name);
            $('#slug').val(filtro[0].slug);

            $("#update").on('click', function () {
                var name = $('#name').val(),
                    slug = $('#slug').val();

                if (name == '' | slug == '') {
                    toastr.warning("Complete todos los campos")
                } else {
                    $.ajax({
                        url: '/api/roles/' + id,
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        type: 'PUT',
                        data: {
                            name: name,
                            slug: slug,
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

especial
1 crear usuarios            x1
2 editar usuarios           x2
3 eliminar usuarios         x3
4 ver usuarios              x4

1 crear roles               x5
2 editar roles              x6
3 eliminar roles            x7
4 ver roles                 x8

1 generar reportes          x9
2 Modulo seguimientos       x10
*/

function Modal() {
    modal.find('.modal-content').empty().append(`
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Formulario de Roles</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">

                <div class="form-group">
                    <label>Nombre de Rol: </label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-book"></i></span>
                        <input type="text" class="form-control" placeholder="Rol" id="name">
                    </div>
                </div>

                <div class="form-group">
                    <label>Descripcion: </label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-book"></i></span>
                        <input type="text" class="form-control" placeholder="Descripcion" id="slug">
                    </div>
                </div>

            </div>
        </div>
        <label>Permisos: </label>
        <div class="row">

            <div class="col-md-6">

                <label>Ver: </label> 
                <label><input id="ver_all" type="checkbox">Select all</input></label>
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input value="v1" name="ver" type="checkbox">ver estudiantes
                        </label>
                    </div>

                    <div class="checkbox">
                        <label>
                            <input value="v2" name="ver" type="checkbox">ver docentes
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="v3" name="ver"type="checkbox">ver acudientes
                        </label>
                    </div>

                    <div class="checkbox">
                        <label>
                            <input value="v4" name="ver" type="checkbox">ver psicoorentadores
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="v5" name="ver" type="checkbox">ver comportamientos
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="v6" name="ver" type="checkbox">ver actividades  
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="v7" name="ver" type="checkbox">ver avances  
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="v8" name="ver" type="checkbox">ver cursos 
                        </label>
                    </div>
                    
                    
                    <label>Editar: </label>
                    <label><input id="editar_all" type="checkbox">Select all</input></label>
                    <div class="checkbox">
                        <label>
                            <input value="e1" name="editar" type="checkbox">editar estudiantes
                        </label>
                    </div>

                    <div class="checkbox">
                        <label>
                            <input value="e2" name="editar" type="checkbox">editar docentes
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="e3" name="editar" type="checkbox">edtar acudientes
                        </label>
                    </div>

                    <div class="checkbox">
                        <label>
                            <input value="e4" name="editar" type="checkbox">editar psicoorentadores
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="e5" name="editar" type="checkbox">editar comportamientos
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="e6" name="editar" type="checkbox">editar actividades  
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="e7" name="editar" type="checkbox">editar avances  
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="e8" name="editar" type="checkbox">editar cursos 
                        </label>
                    </div>

                

                    <label>Especiales: </label>
                    <label><input id="especial_all" type="checkbox">Select all</input></label>
                    <div class="checkbox">
                        <label>
                            <input value="x1" name="especial" type="checkbox">ver usuarios
                        </label>
                    </div>

                    <div class="checkbox">
                        <label>
                            <input value="x2" name="especial" type="checkbox">crear usuarios
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="x3" name="especial" type="checkbox">eliminar usuarios
                        </label>
                    </div>

                    <div class="checkbox">
                        <label>
                            <input value="x4" name="especial" type="checkbox">editar usuarios
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="x5" name="especial" type="checkbox">ver roles
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="x6" name="especial" type="checkbox">crear roles  
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="x7" name="especial" type="checkbox">eliminar roles  
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="x8" name="especial" type="checkbox">editar roles 
                        </label>
                    </div>

                    <div class="checkbox">
                        <label>
                            <input value="x9" name="especial" type="checkbox">modulo seguimeinto
                        </label>
                    </div>

                    <div class="checkbox">
                        <label>
                            <input value="x10" name="especial" type="checkbox">generar reportes
                        </label>
                    </div>
                </div>


            </div>
            <div class="col-md-6">
                <div class="form-group">
                <label>Crear: </label>
                <label><input id="crear_all" type="checkbox">Select all</input></label>
                    <div class="checkbox">
                        <label>
                            <input value="c1" name="crear" type="checkbox">crear estudiantes
                        </label>
                    </div>

                    <div class="checkbox">
                        <label>
                            <input value="c2" name="crear" type="checkbox">crear docentes
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="c3" name="crear" type="checkbox">crear acudientes
                        </label>
                    </div>

                    <div class="checkbox">
                        <label>
                            <input value="c4" name="crear" type="checkbox">crear psicoorentadores
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="c5" name="crear" type="checkbox">crear comportamientos
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="c6" name="crear" type="checkbox">crear actividades  
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="c7" name="crear" type="checkbox">crear avances  
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="c8" name="crear" type="checkbox">crear cursos 
                        </label>
                    </div>

                <label>Eliminar: </label>
                <label><input id="eliminar_all" type="checkbox">Select all</input></label>
                    <div class="checkbox">
                        <label>
                            <input value="d1" name="eliminar" type="checkbox">eliminar estudiantes
                        </label>
                    </div>

                    <div class="checkbox">
                        <label>
                            <input value="d2" name="eliminar" type="checkbox">eliminar docentes
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="d3" name="eliminar" type="checkbox">eliminar acudientes
                        </label>
                    </div>

                    <div class="checkbox">
                        <label>
                            <input value="d4" name="eliminar" type="checkbox">eliminar psicoorentadores
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="d5" name="eliminar" type="checkbox">eliminar comportamientos
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="d6" name="eliminar" type="checkbox">eliminar actividades  
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="d7" name="eliminar" type="checkbox">eliminar avances  
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input value="d8" name="eliminar" type="checkbox">eliminar cursos 
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
        url: "/api/roles",
        type: "GET",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        dataType: "JSON",
    })

        .done(function (response) {
            if (response.length != 0) {
                AllRegister = response.data;
                console.log(AllRegister);
                DataTable(response.data);
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
            else if (key == 'permissions') {

                my_item.title = 'Permisos';

                var html = '';
                my_item.render = function (data, type, row) {


                    if (row.permissions.length != 0) {
                        for (var i = 0; i < row.permissions.length; i++) {
                            html += `<span class="label bg-blue">
                                        ${row.permissions[i].name}
                                    </span>`

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
            //responsive: false,
            'scrollX': false,
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
var modal = $('#modal-roles');
var AllRegister = []

$(document).ready(function () {
    Reload()

    $('#add-roles').on('click', function () {
        modal.modal('show');
        Modal();

        $('#save').on('click', function () {

            var name = $('#name').val(),
                descripcion = $('#descripcion').val();

            if (name == '' | descripcion == '') {
                toastr.warning("Complete todos los campos")
            } else {
                $.ajax({
                    url: '/api/roles',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    data: {
                        name: name,
                        descripcion: descripcion,
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
            $('#descripcion').val(filtro[0].descripcion);

            $("#update").on('click', function () {
                var name = $('#name').val(),
                    descripcion = $('#descripcion').val();

                if (name == '' | descripcion == '') {
                    toastr.warning("Complete todos los campos")
                } else {
                    $.ajax({
                        url: '/api/roles/' + id,
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        type: 'PUT',
                        data: {
                            name: name,
                            descripcion: descripcion,
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
        function(){
            $.ajax({
                url: "/api/roles/" + id,
                type: "DELETE",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
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
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" class="form-control" placeholder="Rol" id="name">
                    </div>
                </div>

                <div class="form-group">
                    <label>Descripcion: </label>
                    <textarea id="descripcion" class="form-control" style="resize: vertical;" rows="3" placeholder="Descripcion ..."></textarea>
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
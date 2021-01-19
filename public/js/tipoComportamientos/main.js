var modal = $('#modal-tipo_c')
var filtro = []


$(document).ready(function() {
    Reload()

    $("#tipoComportamientos-table").on('click', '[id^=Btn_Edit_]', function() {
        var id = $(this).attr('data-id')
        var filtro = AllRegister.filter(f => f.id == id);

        if (filtro.length != 0) {
            modal.modal('show')
            Modal()

            $("#save").text("Actualizar")
            $("#save").attr('id', 'update')


            $("#titulo").val(filtro[0].titulo)
            $("#descripcion").val(filtro[0].descripcion)

            $('#update').on('click', function() {
                var titulo = $("#titulo").val(),
                    descripcion = $("#descripcion").val();

                if (titulo == '' || descripcion == '') {
                    toastr.warning("Complete todos los campos")
                } else {
                    $.ajax({
                            url: '/api/tipo_comportamientos/' + id,
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            type: 'PUT',
                            data: {
                                titulo: titulo,
                                descripcion: descripcion
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
            })


        }
    })

    $('#tipoComportamientos-table').on('click', '[id^=Btn_delete_]', function() {
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
                        url: "/api/tipo_comportamientos/" + id,
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

    $('#add-tipo_c').on('click', function() {
        modal.modal('show');
        Modal()

        $('#save').on('click', function() {
            var titulo = $("#titulo").val(),
                descripcion = $("#descripcion").val();

            if (titulo == '' || descripcion == '') {
                toastr.warning("Complete todos los campos")
            } else {
                $('#loading-spinner').show();
                $.ajax({
                        url: '/api/tipo_comportamientos',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        type: 'POST',
                        data: {
                            titulo: titulo,
                            descripcion: descripcion
                        },
                    })
                    .done(function() {
                        setTimeout(function() {
                            $('#loading-spinner').hide();
                            modal.modal("hide")
                        }, 600);
                        Reload()
                    })
                    .fail(function() {
                        $('#loading-spinner').hide();
                        toastr.error("Ha ocurrido un error");
                    })
                    .always(function() {
                        $("#save").addClass("disabled");
                    });
            }
        })
    })
});

function Modal() {
    modal.find('.modal-content').empty().append(`
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Formulario de Acudiente</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Conducta: </label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control" placeholder="Conducta" id="titulo">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Descripcion: </label>
                        <textarea id="descripcion" class="form-control" rows="3" placeholder="Descripcion ..."></textarea>
                    </div>

                </div>

            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="save">Guardar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
    `)
}

function Reload() {
    $.ajax({
        url: "/api/tipo_comportamientos",
        type: "GET",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        dataType: "JSON",
    })

    .done(function(response) {
        if (response.length != 0) {
            AllRegister = response.data;

            DataTable(response.data);
        } else {
            $('#tipoComportamientos-table').dataTable().fnClearTable();
            $('#tipoComportamientos-table').dataTable().fnDestroy();
            $('#tipoComportamientos-table thead').empty()
        }
    })

    .fail(function() {
        console.log("error");
    });
}

function DataTable(response) {

    console.log(response)
    if ($.fn.DataTable.isDataTable('#tipoComportamientos-table')) {
        $('#tipoComportamientos-table').dataTable().fnClearTable();
        $('#tipoComportamientos-table').dataTable().fnDestroy();
        $('#tipoComportamientos-table thead').empty()
    } else {
        $('#tipoComportamientos-table thead').empty()
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

            } else if (key == 'id') {

                my_item.title = '#';

                my_item.render = function(data, type, row) {
                    return `  <div'> 
                                ${row.id}
                            </div>`
                }
                my_columns.push(my_item);
            } else if (key == 'titulo') {

                my_item.title = 'Conducta';

                my_item.render = function(data, type, row) {
                    return `<div>
                                ${row.titulo} 
                            </div>`
                }
                my_columns.push(my_item);
            } else if (key == 'descripcion') {

                my_item.title = 'Descripcion';

                my_item.render = function(data, type, row) {
                    return `<div>
                                ${row.descripcion} 
                            </div>`
                }
                my_columns.push(my_item);
            }

        })

        $('#tipoComportamientos-table').DataTable({
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
                "info": "Mostrando _START_ a _END_ de _TOTAL_ tipoComportamientos",
                "infoEmpty": "No hay tipoComportamientos registrados",
                "infoFiltered": "(Filtrado de _MAX_  tipoComportamientos)",
                "lengthMenu": "_MENU_ tipoComportamientos",
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
                { "width": "20%", "targets": 3 }
            ],

            "lengthMenu": [
                [10, 15, 20, -1],
                [10, 15, 20, "Todos"]
            ]
        });
    }
}
var modal = $("#modal-grupos")
var AllRegister = []


$(document).ready(function () {
    Reload()

    $("#grupos-table").on('click', '[id^=Btn_Edit_]', function () {

        var id = $(this).attr('data-id')
        var filtro = AllRegister.filter(f => f.id == id);

        if (filtro.length != 0) {
            modal.modal('show')
            Modal()
            LoadDocente()

            $("#save").text("Actualizar")
            $("#save").attr('id', 'update')


            $("#grado").val(filtro[0].grado)
            $("#curso").val(filtro[0].curso)
            $("#docente_id").val(filtro[0].docente_id)

            $('#update').on('click', function () {
                var grado = $("#grado").val(),
                    curso = $("#curso").val(),
                    docente_id = $("#docente_id").val();

                if (grado == '' || curso == '' || docente_id == '') {
                    toastr.warning("Complete todos los campos")
                } else {
                    $.ajax({
                        url: '/api/grupos/' + id,
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        type: 'PUT',
                        data: {
                            grado: grado,
                            curso: curso,
                            docente_id: docente_id
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

    $('#grupos-table').on('click', '[id^=Btn_delete_]', function () {
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
                    url: "/api/grupos/" + id,
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

    $('#add-grupo').on('click', function () {
        modal.modal('show')
        Modal()
        LoadDocente()

        $('#save').on('click', function () {
            var grado = $("#grado").val(),
                curso = $("#curso").val(),
                docente_id = $("#docente_id").val();

            if (grado == '' || curso == '' || docente_id == '') {
                toastr.warning("Complete todos los campos")
            } else {
                $.ajax({
                    url: '/api/grupos',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    data: {
                        grado: grado,
                        curso: curso,
                        docente_id: docente_id
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

function Modal() {
    modal.find('.modal-content').empty().append(`
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Formulario de Grupos</h4>
    </div>

    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Grado: </label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-graduation-cap"></i></span>
                        <input id="grado" placeholder="Digite grado" class="form-control" type="text" maxlength="2">
                    </div>
                </div>

                <div class="form-group">
                    <label >Docente encargado: </label>
                    <select class="form-control" id="docente_id" style="width: 100%;">

                    </select>
                </div>

            </div>

            <div class="col-md-6">

                <div class="form-group">
                    <label>Grupo: </label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-graduation-cap"></i></span>
                        <input id="curso" placeholder="Digite curso" class="form-control" type="text" maxlength="1">
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
}

function LoadDocente() {
    $("#docente_id").select2({
        placeholder: 'Seleccione el director de grupo',
        allowClear: true,
        dropdownParent: modal,
        width: 'resolve'
    });

    $.ajax({
        url: '/api/docentes',
    })
        .done(function (response) {
            for (var i in response.data) {
                $("#docente_id").append(`<option value='${response.data[i].id}'>${response.data[i].nombres} ${response.data[i].apellidos}</option>`)
            }

        })
        .fail(function () {
            console.log("error");
        })
}

function Reload() {
    $.ajax({
        url: "/api/grupos",
        type: "GET",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        dataType: "JSON",
    })

        .done(function (response) {
            if (response.length != 0) {
                AllRegister = response.data;

                DataTable(response.data);
            } else {
                $('#grupos-table').dataTable().fnClearTable();
                $('#grupos-table').dataTable().fnDestroy();
                $('#grupos-table thead').empty()
            }
        })

        .fail(function () {
            console.log("error");
        });
}

function DataTable(response) {

    console.log(response)
    if ($.fn.DataTable.isDataTable('#grupos-table')) {
        $('#grupos-table').dataTable().fnClearTable();
        $('#grupos-table').dataTable().fnDestroy();
        $('#grupos-table thead').empty()
    }
    else {
        $('#grupos-table thead').empty()
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

            else if (key == 'grado') {

                my_item.title = 'grado';

                my_item.render = function (data, type, row) {
                    return `  <div'> 
                                ${row.grado + "-" + row.curso}
                            </div>`
                }
                my_columns.push(my_item);
            }

            else if (key == 'docente') {

                my_item.title = 'Director de curso';

                my_item.render = function (data, type, row) {
                    return `  <div'> 
                                ${row.docente}
                            </div>`
                }
                my_columns.push(my_item);
            }
        })

        $('#grupos-table').DataTable({
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
                "info": "Mostrando _START_ a _END_ de _TOTAL_ grupos",
                "infoEmpty": "No hay grupos registrados",
                "infoFiltered": "(Filtrado de _MAX_  grupos)",
                "lengthMenu": "_MENU_ grupos",
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
                { "width": "40%", "targets": 2 },
                { "width": "10%", "targets": 3 }
            ],

            "lengthMenu": [
                [10, 15, 20, -1],
                [10, 15, 20, "Todos"]
            ]
        });
    }
}

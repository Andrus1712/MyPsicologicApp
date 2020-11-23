var modal = $('#modal-comportamientos')
var AllRegister = [];

var getAct;

var permisos = [];

var element = [];


$(document).ready(function () {
    getActividades();
    Reload()


    $('#comportamientos-table').on('click', '[id^=Btn_act_]', function () {
        var id = $(this).attr('data-id');
        modal.modal('show');
        ModalActividades()
        $('#input_actividad').hide()
        LoadComportamientos(id)
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

    // $('#comportamientos-table').on('click', '[id^=Btn_search_]', function () {
    //     alert("info acudiente")
    // })


    $('#comportamientos-table').on('click', '[id^=Btn_Edit_]', function () {
        var id = $(this).attr('data-id');

        const filtro = AllRegister.filter(f => f.id == id);

        if (filtro.length != 0) {
            modal.modal("show");
            Modal()
            LoadEstudiantes()


            $("#save").text("Actualizar")
            $("#save").attr("id", 'update')

            // $('#rutaFile').removeClass('hide')
            // $("#rutaFile").attr('href', filtro[0].multimedia)
            // $('#rutaFile').attr('target', '_blank')
            // $("#rutaFile").text('Ver documento')

            $("#cod_comportamiento").val(filtro[0].cod_comportamiento)
            $("#cod_comportamiento").attr("disabled", true)
            $("#titulo").val(filtro[0].titulo)
            $("#estudiante_id").val(filtro[0].estudiante_id)
            $("#descripcion").val(filtro[0].descripcion)
            $("#fecha").val(filtro[0].fecha)
            // $("#emisor").val(filtro[0].emisor)

            $("#update").on('click', function () {

                var estudiante_id = $("#estudiante_id").val(),
                    titulo = $("#titulo").val(),
                    descripcion = $("#descripcion").val(),
                    fecha = $("#fecha").val()

                if (estudiante_id == '' || titulo == '' || descripcion == '' || fecha == '') {
                    toastr.warning("Complete todos los campos")
                }
                else {

                    var form = new FormData();

                    var archivos = 0;
                    form.append('tempMultimedia', filtro[0].multimedia)

                    jQuery.each(jQuery('#multimedia')[0].files, function (i, file) {
                        form.append('file' + i, file);
                        archivos++;
                    });
                    form.append('archivos', archivos);


                    form.append('estudiante_id', estudiante_id)
                    form.append('titulo', titulo)
                    form.append('descripcion', descripcion)
                    form.append('fecha', fecha)
                    form.append('cod_comportamiento', 2342)
                    // form.append('emisor', "x")
                    // form.append('multimedia', multimedia)
                    form.append('method', 'update')
                    form.append('id', id)


                    $.ajax({
                        url: '/add_comportamientos',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        data: form,
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
                modal.find('.modal-content').empty()
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
                // emisor = "X",
                multimedia = $("#multimedia")[0].files;

            if (cod_comportamiento == '' || estudiante_id == '' || titulo == '' || descripcion == '' || fecha == '') {
                toastr.warning("Complete todos los campos")
            }
            else {
                var form = new FormData();
                var archivos = 0;
                jQuery.each(jQuery('#multimedia')[0].files, function (i, file) {
                    form.append('file' + i, file);
                    archivos++;
                });
                form.append('archivos', archivos);


                form.append('estudiante_id', estudiante_id)
                form.append('titulo', titulo)
                form.append('descripcion', descripcion)
                form.append('fecha', fecha)
                // form.append('emisor', emisor)
                form.append('cod_comportamiento', cod_comportamiento)
                // form.append('multimedia', multimedia)

                $.ajax({
                    url: '/add_comportamientos',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: form,
                    processData: false,
                    contentType: false,
                })
                    .done(function () {
                        toastr.success("Comportamiento registrado");
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


    $('#comportamientos-table').on('click', '[id^=Btn_file_]', function () {
        modal.modal('show')
        var id = $(this).attr('data-id');

        const filtro = AllRegister.filter(f => f.id == id);

        if (filtro.length != 0) {
            var json = filtro[0].multimedia.split('PSIAPP');
            var html = ''
            var a = 0;
            for (var i = 0; i < json.length; i++) {
                if (json[i] != '') {
                    var icon = 'fa fa-file';

                    var extension = json[i].split('.')[2];
                    console.log(extension)

                    switch (extension) {
                        case 'doc':
                            icon = 'fa-file-word-o';
                            break;
                        case 'docx':
                            icon = 'fa-file-word-o';
                            break;
                        case 'xlsx':
                            icon = 'fa-file-excel-o bg-success bg-green';
                            break;
                        case 'pdf':
                            icon = 'fa-file-pdf bg-danger bg-red';
                            break;
                        case 'txt':
                            icon = 'fa-file-text';
                            break;
                        case 'jpeg':
                            icon = 'fa-file-image-o';
                            break;
                        case 'png':
                            icon = 'fa-file-image-o';
                            break;
                        case 'jpg':
                            icon = 'fa-file-image-o';
                            break;
                        case 'mp3':
                            icon = 'fa-file-audio-o bg-secondary';
                            break;
                        case 'mp4':
                            icon = 'fa-file-movie-o bg-secondary';
                            break;
                    }
                    html += `
                    <div class="col-md-3">
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <i class="fa fa-book"></i>
                                <h3 class="box-title">Archivo ${a + 1}</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group" align="center">
                                    <a target="_blank" href="${json[i]}" type="button" style="font-size: 2em;" class="btn-link">
                                        <i class="fa ${icon}"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                    </div>`

                    a++;
                }

            }





            modal.find('.modal-content').empty().append(`
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Archivos cargados</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        ${html}
                    </div>
                    
                </div>
            `)
        }

    });

    $('#make-reporte').on('click', function () {
        modal.modal("show");
        ModalReporte();

        LoadTiposComportamientos();
        var start = moment().subtract(29, 'days');
        var end = moment();

        var fi;
        var ff;
        function cb(start, end) {
            $('#report-range span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            fi = start.format('YYYY-MM-DD');
            ff = end.format('YYYY-MM-DD');
        }
        $('#report-range').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);

        $('#tc_all').on('click', function () {
            var checked = this.checked;
            $('input[name="tc"]').each(function () {
                this.checked = checked;
            });
        });

        $('#visualizar').on('click', function () {
            // alert("inicio: " + fi + " fin: " + ff)
            var form = new FormData();
            form.append("fecha_i", fi);
            form.append("fecha_f", ff);

            $.ajax({
                url: '/generarReporte',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: form,
                processData: false,
                contentType: false,
            })
                .done(function (response) {
                    console.log("info response "+response);
                    // if (response.length != 0) {
                    //     // DataTableReport(response);
                        
                    // } else {
                    //     $('#reportes-table').dataTable().fnClearTable();
                    //     $('#reportes-table').dataTable().fnDestroy();
                    //     $('#reportes-table thead').empty();
                    //     console.log("sin datos");
                    // }
                })
                .fail(function () {
                    toastr.error("Ha ocurrido un error");
                })

        });
        // window.open("/comportamientosPdf", "_blank");
    });
});

function LoadEstudiantes() {
    $("#estudiante_id").select2({
        placeholder: 'Seleccione el estudiante',
        allowClear: true,
        dropdownParent: modal,
        width: 'resolve'
    });

    $.ajax({
        url: '/getEstudiantes',
        type: "GET",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        dataType: "JSON",
    })
        .done(function (response) {
            if (response.estudiantes.length != 0) {
                for (var i = 0; i < response.estudiantes.length; i++) {
                    $("#estudiante_id").append(`<option value='${response.estudiantes[i].id}'>${response.estudiantes[i].nombres} ${response.estudiantes[i].apellidos} </option>`)
                }
            } else {

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
    // $("#tipo_comportamiento_id").select2({
    //     placeholder: 'Seleccione el tipo comportamiento',
    //     allowClear: true,
    //     dropdownParent: modal,
    //     width: 'resolve',
    //     // theme: 'bootstrap4',
    // });

    $.ajax({
        url: '/api/tipo_comportamientos',
    })
        .done(function (response) {
            $("#tipos_comportamientos").append(`
                <div class="checkbox">
                    <label style="font-weight: bold;">
                        <input id="tc_all" type="checkbox">Select all</input>
                    </label>
                </div>
            `);
            for (var i in response.data) {
                $("#tipos_comportamientos").append(`
                    <div class="checkbox">
                        <label>
                            <input id="tc_${i}" value="${response.data[i].id}" name="tc" type="checkbox">${response.data[i].titulo}
                        </label>
                    </div>
                `)
            }

        })
        .fail(function () {
            console.log("error");
        })
}

function LoadComportamientos(id) {
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
                if (response.data[i].id == id) {
                    $("#comportamiento_id").append(`<option value='${response.data[i].id}'>${response.data[i].titulo} | ${response.data[i].nombres}  ${response.data[i].apellidos} | CMP${response.data[i].id} </option>`)
                }
            }

        })
        .fail(function () {
            console.log("error");
        })
}

function getActividades() {
    $.ajax({
        url: "/getActividades",
        type: "GET",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        dataType: "JSON",
    })

        .done(function (response) {
            if (response.length != 0) {
                getAct = []

                getAct = response['actividades'];
                for (let index = 0; index < getAct.length; index++) {
                    element.push(getAct[index].id_comportamiento);

                }
                // console.log(element);
            } else {
                console.log('sin datos');
            }
        })

        .fail(function () {
            console.log("error");
        });
}

function Reload() {
    $.ajax({
        url: "/getComportamientos",
        type: "GET",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        dataType: "JSON",
    })

        .done(function (response) {
            if (response.length != 0) {
                AllRegister = response.comportamientos;
                permisos = response.permisos;
                // console.log(response.comportamientos);
                DataTable(response.comportamientos);
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

function ModalReporte() {
    modal.find('.modal-content').empty().append(`
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Reporte</h4>
        </div>
        <div class="modal-body">

            <div class="row">
                
                <div class="col-md-6">
                    
                    <div class="form-group">
                        <label>Fecha del registro: </label>
                        <div id="report-range"
                            style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                            <i class="fa fa-calendar"></i>&nbsp;
                            <span></span> <i class="fa fa-caret-down"></i>
                        </div>
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <div class="input-group">
                            <label>Tipo de comportamiento: </label>
                            <div id="tipos_comportamientos">
                                
                            </div>
                            
                        </div>

                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <label>Variables: </label>
                            <div id="variables">
                            <div class="checkbox">
                                <label>
                                    <input id="1" value="show.comportamientos" name="ver" type="checkbox">Actividades
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input id="2" value="show.comportamientos" name="ver" type="checkbox">Estudiantes
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input id="3" value="show.comportamientos" name="ver" type="checkbox">Estado actividades
                                </label>
                            </div>
                            </div>
                            
                        </div>

                    </div>
                </div>
                
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="button" class="btn btn-primary" id="visualizar">Pre-visualizar</button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="table">
                        <table class="table table-bordered table-hover" id="reportes-table">
                            
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="save">Enviar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    `);

}

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
                            <select class="form-control" id="estudiante_id" style="width: 100%; heigh: 100px;">

                            </select>
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
                        <a class="btn btn-secondary hide" id="rutaFile"></a>
                            <br>
                        <label>Multimedia: </label>
                        <input type="file" name="files[]" id="multimedia" multiple>
                        
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

function DataTableReport(response) {

    if ($.fn.DataTable.isDataTable('#reportes-table')) {
        $('#reportes-table').dataTable().fnClearTable();
        $('#reportes-table').dataTable().fnDestroy();
        $('#reportes-table thead').empty()
    }
    else {
        $('#reportes-table thead').empty()
    }

    // console.log("info tabla " + response);

    if (response.length != 0) {
        let my_columns = []
        $.each(response[0], function (key, value) {
            var my_item = {};
            // my_item.class = "filter_C";
            my_item.data = key;
            if (key == "fecha_f") {

                my_item.title = 'Fecha';

                my_item.render = function (data, type, row) {
                    return `  <div> 
                                ${row.fecha_f}
                            </div>`
                }
                my_columns.push(my_item);

            }
            else if (key == "fecha_i") {

                my_item.title = 'Fecha';

                my_item.render = function (data, type, row) {
                    return `  <div> 
                                ${row.fecha_i}
                            </div>`
                }
                my_columns.push(my_item);

            }
        });
        $('#reportes-table').DataTable({
            // 'scrollX': my_columns.length >= 6 ? true : false,
            "destroy": true,
            data: response,
            "columns": my_columns,
            dom: 'Bfrtip',
            responsive: true,
            paging: true,
        });
    }

}

function DataTable(response) {


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
                    var html = '';
                    for (let i = 0; i < permisos.length; i++) {
                        if (permisos[i] == "delete.comportamientos") {
                            html += `
                                    <a data-id=${row.id} id="Btn_delete_${row.id}" class='btn btn-circle btn-sm btn-danger'>
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a> `
                        } else if (permisos[i] == "edit.comportamientos") {
                            html += `
                                    <a data-id=${row.id} id="Btn_Edit_${row.id}" class='btn btn-circle btn-sm btn-primary'>
                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                    </a>
                                    `
                        } else if (permisos[i] == "create.actividades") {
                            html += `
                                    <a data-id=${row.id} id="Btn_act_${row.id}" class='btn btn-circle btn-sm btn-success'>
                                        <i class="fa fa-calendar-plus-o" aria-hidden="true"></i>
                                    </a> `
                        }
                    }
                    return `<div align="center">
                                <div class="btn-group btn-group-circle btn-group-solid" align="center">
                                    ${html}
                                </div>
                            </div>`;

                }
                if (permisos.length != 0) {
                    my_columns.push(my_item);
                }

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

            else if (key == 'fecha') {

                my_item.title = 'Fecha de reporte';

                my_item.render = function (data, type, row) {
                    return `  <div'> 
                                ${row.fecha}
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
                                <a class="btn btn-default ${row.multimedia == 'undefined' || row.multimedia == null ? 'disabled' : ''}" id="Btn_file_${row.id}" data-id=${row.id} >
                                    <i class="fa fa-file"></i>
                                </a>
                            </div>`
                }
                my_columns.push(my_item);
            }

            else if (key == 'emisor') {

                my_item.title = 'Emisor';

                my_item.render = function (data, type, row) {
                    return `<div>
                                ${JSON.parse(row.emisor).email}
                            </div>`
                }
                my_columns.push(my_item);
            }
        })

        $('#comportamientos-table').DataTable({
            //'responsive': true,
            'scrollX': my_columns.length >= 6 ? true : false,
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
                [2, 'asc']
            ],
            "lengthMenu": [
                [10, 15, 20, -1],
                [10, 15, 20, "Todos"]
            ],
            "createdRow": function (row, data, dataIndex) {
                if (!element.includes(data.id, 0)) {
                    $(row).css('background-color', '#ffedd9');
                }
            }
        });

        $('thead > tr> th:nth-child(1)').css({ 'min-width': '30px', 'max-width': '30px' });
        $('thead > tr> th:nth-child(2)').css({ 'min-width': '100px', 'max-width': '100px' });
        $('thead > tr> th:nth-child(3)').css({ 'min-width': '160px', 'max-width': '160px' });
        $('thead > tr> th:nth-child(4)').css({ 'min-width': '80px', 'max-width': '80px' });
        $('thead > tr> th:nth-child(5)').css({ 'min-width': '120px', 'max-width': '120px' });
        $('thead > tr> th:nth-child(6)').css({ 'min-width': '120px', 'max-width': '120px' });
        $('thead > tr> th:nth-child(10)').css({ 'min-width': '120px', 'max-width': '120px' })


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
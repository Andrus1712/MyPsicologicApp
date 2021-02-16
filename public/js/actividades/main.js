var modal = $('#modal-actividades');
var AllRegister = [];
var AllAvances = [];
var permisos = [];
var AvancesElement = [];

$(document).ready(function () {
    Reload();
    ReloadCalendario();


    $('#act-table').on('click', '[id^=Btn_Edit_]', function () {
        var id = $(this).attr('data-id')
        console.log(id);
        var filtro = AllRegister.filter(f => f.id == id);

        if (filtro.length != 0) {
            modal.modal('show');
            Modal()
            $('#input_actividad').show()
            LoadTiposComportamientos()
            LoadComportamientos()

            $("#save").text("Actualizar")
            $("#save").attr("id", 'update')

            $("#comportamiento_id").val(filtro[0].comportamiento_id)
            $("#comportamiento_id").attr("readonly", true)

            $("#titulo").val(filtro[0].titulo)
            $("#descripcion").val(filtro[0].descripcion)
            $("#fecha").val(filtro[0].fecha)
            $('#estado').val(filtro[0].estado)
            $("#tipo_comportamiento_id").val(filtro[0].tipo_comportamiento_id)

            $('#update').on('click', function () {
                var comportamiento_id = $("#comportamiento_id").val(),
                    titulo = $("#titulo").val(),
                    descripcion = $("#descripcion").val(),
                    fecha = $("#fecha").val(),
                    estado = $('#estado').val(),
                    tipo_comportamiento_id = $("#tipo_comportamiento_id").val();

                if (comportamiento_id == '' || titulo == '' || descripcion == '' || fecha == '' || estado == '' || tipo_comportamiento_id == '') {
                    toastr.warning("Complete todos los campos")
                } else {
                    $('#loading-spinner').show();
                    $.ajax({
                        url: '/api/actividades/' + id,
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        type: 'PUT',
                        data: {
                            comportamiento_id: comportamiento_id,
                            titulo: titulo,
                            descripcion: descripcion,
                            fecha: fecha,
                            estado: estado,

                        },
                    })
                        .done(function () {
                            setTimeout(function () {
                                $('#loading-spinner').hide();
                                modal.modal("hide")
                            }, 600);
                            toastr.info("información actualizada");
                            Reload()
                            ReloadCalendario()
                        })
                        .fail(function () {
                            $('#loading-spinner').hide();
                            toastr.error("Ha ocurrido un error");
                        })
                        .always(function () {
                            $("#update").addClass("disabled");
                        });
                }
            })


        }
    })

    $('#act-table').on('click', '[id^=Btn_delete_]', function () {
        var id = $(this).attr('data-id')

        swal({
            title: "¿Realmente deseas eliminar la actividad?",
            text: "Ten en cuenta que eliminaras toda su información del sistema",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Si, eliminar",
            closeOnConfirm: false
        },
            function () {
                $.ajax({
                    url: "/api/actividades/" + id,
                    type: "DELETE",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                })
                    .done(function () {
                        swal("Eliminado!", "Se ha eliminado la actividad", "success");
                        Reload();
                    })
                    .fail(function () {
                        swal("Error!", "Ha ocurrido un error", "error");
                    });

            });


    })

    $('#add-actividades').on('click', function () {
        modal.modal('show');
        Modal()
        $('#input_actividad').hide()
        LoadComportamientos()
        LoadTiposComportamientos()

        $('#save').on('click', function () {
            var comportamiento_id = $("#comportamiento_id").val(),
                titulo = $("#titulo").val(),
                descripcion = $("#descripcion").val(),
                fecha = $("#fecha").val(),
                tipo_comportamiento_id = $("#tipo_comportamiento_id").val(),
                estado = 3 //estado por defecto de las actividades

            if (comportamiento_id == '' || titulo == '' || descripcion == '' || fecha == '' || tipo_comportamiento_id == '') {
                toastr.warning("Complete todos los campos")
            } else {
                $('#loading-spinner').show();
                $.ajax({
                    url: '/add_actividades',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    data: {
                        comportamiento_id: comportamiento_id,
                        titulo: titulo,
                        descripcion: descripcion,
                        fecha: fecha,
                        estado: estado,
                        tipo_comportamiento_id: tipo_comportamiento_id,
                    },
                })
                    .done(function () {
                        setTimeout(function () {
                            $('#loading-spinner').hide();
                            modal.modal("hide")
                        }, 600);
                        toastr.success("Actividad creada");
                        Reload()
                        ReloadCalendario()
                    })
                    .fail(function () {
                        $('#loading-spinner').hide();
                        toastr.error("Ha ocurrido un error");
                    })
                    .always(function () {
                        $("#save").addClass("disabled");
                    });
            }

        })
    });

    $('#reprogramar').on('click', function () {
        modal.modal('show');
        ModalReprogramar();
        LoadActividades();

        $('#save').on('click', function () {
            fecha = $("#fecha").val()
            var id = $("#actividad_id").val();
            var fechaReprogramar = $('#fechaReprogramar').val();
            var descripcion_historial = $('#descripcion_historial').val();
            $('#loading-spinner').show();
            $.ajax({
                url: '/api/actividades/' + id,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'PUT',
                data: {
                    fecha: fechaReprogramar,
                    descripcion_historial: descripcion_historial,
                    method: "reprogramar",
                },
            })
                .done(function () {
                    setTimeout(function () {
                        $('#loading-spinner').hide();
                        modal.modal('hide')
                    }, 600);
                    toastr.info("Actividad reprogramada");
                    Reload()
                    ReloadCalendario()
                })
                .fail(function () {
                    $('#loading-spinner').hide();
                    toastr.error("Ha ocurrido un error");
                })
                .always(function () {
                    $('#save').addClass("disabled");
                });
        });
    });

    // Check estatus
    $('#act-table').on('click', '[id^=btn_cumplido_]', function () {
        var id = $(this).attr('data-id')
        $.ajax({
            url: '/api/actividades/' + id,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            type: 'PUT',
            data: {
                estado: 1
            },
        })
            .done(function () {
                toastr.success("Actividad marcada como cumplida");
                Reload()
                ReloadCalendario()
            })
            .fail(function () {
                toastr.error("Ha ocurrido un error");
            })
            .always(function () {
                $('#btn_cumplido_' + id).addClass("disabled");
            });
    });

    $('#act-table').on('click', '[id^=btn_incumplido_]', function () {
        var id = $(this).attr('data-id')
        $.ajax({
            url: '/api/actividades/' + id,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            type: 'PUT',
            data: {
                estado: 2
            },
        })
            .done(function () {
                toastr.error("Actividad marcada como icumplida");
                Reload()
                ReloadCalendario()
            })
            .fail(function () {
                toastr.error("Ha ocurrido un error");
            })
            .always(function () {
                $('#btn_incumplido_' + id).addClass("disabled");
            });
    });

    $('#act-table').on('click', '[id^=Btn_info_]', function () {
        modal.modal('show')
        var id = $(this).attr('data-id')
        var filtro = AllRegister.filter(f => f.id == id);
        modal.find('.modal-content').empty().append(`
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Informacion de la conducta</h4>
            </div>
            <div class="modal-body">
                <h3>${filtro[0].titulo_tipo_comportamiento}</h3>
                <p>${filtro[0].descripcion_tipo_comportamiento}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
            `)
    })

    $('#act-table').on('click', '[id^=Btn_show_]', function () {
        var id = $(this).attr('data-id');

        const filtro = AllRegister.filter(f => f.id == id);


        if (filtro.length != 0) {
            if (filtro[0].id_comportamiento == null) {
                modal.modal('show');
                ModalShowEst(filtro);
                $('#avances').on('click', function () {
                    modal.modal('hide');
                    $('#modal-avances').modal('show');
                    ModalCrearAvances();
                    LoadActividad(filtro[0].id);
                    establecer_fecha();
                    $('#save').on('click', function () {
                        var actividad_id = $('#actividad_id').val(),
                            descripcion = $('#descripcion').val(),
                            fecha = $('#fecha').val(),
                            evidencias = $('#evidencias')[0].files;

                        if (actividad_id == '' || descripcion == '' || fecha == '') {
                            toastr.warning("Complete todos los campos")
                        } else {
                            var form = new FormData();
                            var archivos = 0;
                            jQuery.each(jQuery('#evidencias')[0].files, function (i, file) {
                                form.append('file' + i, file);
                                archivos++;
                            });
                            form.append('archivos', archivos);

                            form.append('actividad_id', actividad_id)
                            form.append('descripcion', descripcion)
                            form.append('fecha_avance', fecha)
                            // form.append('evidencias', evidencias)               
                            $('#loading-spinner').show();
                            $.ajax({
                                url: '/api/avances',
                                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                type: 'POST',
                                processData: false,
                                contentType: false,
                                data: form,
                            })
                                .done(function () {
                                    toastr.success("Avance registrado");
                                    setTimeout(function () {
                                        $('#loading-spinner').hide();
                                        $('#modal-avances').modal("hide");
                                    }, 600);
                                    Reload();
                                })
                                .fail(function () {
                                    $('#loading-spinner').hide();
                                    toastr.error("Ha ocurrido un error");
                                })
                                .always(function () {
                                    $("#save").addClass("disabled");
                                });
                        }
                    });
                });
            } else {
                modal.modal('show');
                ModalShow(filtro);
                $('#avances').on('click', function () {
                    modal.modal('hide');
                    $('#modal-avances').modal('show');
                    ModalCrearAvances();
                    LoadActividad(filtro[0].id);
                    establecer_fecha();
                    $('#save').on('click', function () {
                        var actividad_id = $('#actividad_id').val(),
                            descripcion = $('#descripcion').val(),
                            fecha = $('#fecha').val(),
                            evidencias = $('#evidencias')[0].files;

                        if (actividad_id == '' || descripcion == '' || fecha == '') {
                            toastr.warning("Complete todos los campos")
                        } else {
                            var form = new FormData();
                            var archivos = 0;
                            jQuery.each(jQuery('#evidencias')[0].files, function (i, file) {
                                form.append('file' + i, file);
                                archivos++;
                            });
                            form.append('archivos', archivos);

                            form.append('actividad_id', actividad_id)
                            form.append('descripcion', descripcion)
                            form.append('fecha_avance', fecha)
                            // form.append('evidencias', evidencias)               
                            $('#loading-spinner').show();
                            $.ajax({
                                url: '/api/avances',
                                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                type: 'POST',
                                processData: false,
                                contentType: false,
                                data: form,
                            })
                                .done(function () {
                                    toastr.success("Avance registrado");
                                    setTimeout(function () {
                                        $('#loading-spinner').hide();
                                        $('#modal-avances').modal("hide");
                                    }, 600);
                                    Reload();
                                })
                                .fail(function () {
                                    $('#loading-spinner').hide();
                                    toastr.error("Ha ocurrido un error");
                                })
                                .always(function () {
                                    $("#save").addClass("disabled");
                                });
                        }
                    });
                });
            }
        }
    });

    $('#act-table').on('click', '[id^=Btn_historial_]', function () {
        var id = $(this).attr('data-id');
        console.log(id);
        $.ajax({
            url: "/get_historial/" + id,
            type: "GET",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "JSON",
        })
            .done(function (response) {
                if (response != 0) {
                    historial = response;
                    modal.modal('show');
                    ModalHistorial(historial);
                } else {
                    toastr.warning('No existe historial actualmente')
                }
            })
            .fail(function () {
                console.log("error");
            });
    });

    $('#act-table').on('click', '[id^=ver-avances]', function () {
        var id = $(this).attr('data-id');

        var filtro = AllAvances.filter(f => f.id_actividad == id);


        modal.modal('show');
        ModalAvances(filtro[0].titulo_actividad);

        var fecha_anterior = '';
        for (let i = 0; i < filtro.length; i++) {
            var fecha_actual = filtro[i].fecha_avance;
            var fecha = new Date(fecha_actual);
            var options = { year: 'numeric', month: 'long', day: 'numeric' };

            if (fecha_anterior != fecha_actual) {
                $('#timeline_avances').append(`
                    <li class="time-label">
                        <span class="bg-purple">
                            ${fecha.toLocaleDateString("es-ES", options)}
                        </span>
                    </li>
                `);
                fecha_anterior = fecha_actual;
            }

            var html = '';
            if (filtro[i].evidencias != null) {
                var json = filtro[i].evidencias.split('PSIAPP');
                var a = 0;
                console.log(json);
                for (var i2 = 0; i2 < json.length; i2++) {
                    if (json[i2] != '') {
                        var icon = 'fa fa-file';

                        var extension = json[i2].split('.')[2];

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

                        html += `<a target="_blank" href="${json[i2]}" type="button" style="font-size: 3em;" class="btn-link margin">
                                        <i class="fa ${icon}"></i>
                                    </a>`
                        a++;
                    }
                }
            } else {
                html = null;
            }
            $('#timeline_avances').append(`
                <li>
                    <i class="fa fa-exclamation bg-blue"></i>
                    <div class="timeline-item">
                        <span class="time"><i class="fa fa-clock-o"></i>${moment(filtro[i].created_at).fromNow()}</span>

                        <h3 class="timeline-header"><a href="#">Seguimeinto ${filtro[i].id}</a></h3>

                        <div class="timeline-body">
                            ${filtro[i].avance}
                        </div>
                        <div class="timeline-footer">
                            ${html != null ? html : ''}
                        </div>
                    </div>
                </li>
            `);
        }

        $('#check_status').on('click', function () {
            modal.modal('hide');
            $('#modal-avances').modal('show');
            ModalConfirmacion(filtro[0].titulo_actividad);

            $('#cumplido').on('click', function () {
                $('#loading-spinner').show();
                $.ajax({
                    url: '/api/actividades/' + filtro[0].id_actividad,
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'PUT',
                    data: {
                        estado: 1
                    },
                })
                    .done(function () {
                        setTimeout(function () {
                            $('#loading-spinner').hide();
                            $('#modal-avances').modal("hide");
                        }, 600);

                        $('#modal_avances_1').removeClass('modal-md');
                        $('#modal_avances_1').addClass('modal-lg');

                        toastr.warning("Actividad marcada como cumplida");
                        Reload();
                        ReloadCalendario();
                    })
                    .fail(function () {
                        setTimeout(function () {
                            $('#loading-spinner').hide();
                            $('#modal-avances').modal("hide");
                        }, 600);
                        $('#modal_avances_1').removeClass('modal-md');
                        $('#modal_avances_1').addClass('modal-lg');
                        toastr.error("Ha ocurrido un error");
                    });
            });

            $('#incumplido').on('click', function () {
                $('#loading-spinner').show();
                $.ajax({
                    url: '/api/actividades/' + filtro[0].id_actividad,
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'PUT',
                    data: {
                        estado: 2
                    },
                })
                    .done(function () {
                        setTimeout(function () {
                            $('#loading-spinner').hide();
                            $('#modal-avances').modal("hide");
                        }, 600);
                        $('#modal_avances_1').removeClass('modal-md');
                        $('#modal_avances_1').addClass('modal-lg');
                        toastr.warning("Actividad marcada como incumplida");
                        Reload();
                        ReloadCalendario();
                    })
                    .fail(function () {
                        setTimeout(function () {
                            $('#loading-spinner').hide();
                            $('#modal-avances').modal("hide");
                        }, 600);

                        $('#modal_avances_1').removeClass('modal-md');
                        $('#modal_avances_1').addClass('modal-lg');

                        toastr.error("Ha ocurrido un error");
                    });
            });
        });
    });
});

function LoadActividades() {
    $("#actividad_id").select2({
        placeholder: 'Seleccione la actividad',
        allowClear: true,
        dropdownParent: modal,
        width: 'resolve'
    });

    $.ajax({
        url: '/api/actividades',
    })
        .done(function (response) {
            for (var i in response.data) {

                $("#actividad_id").append(`<option name="${response.data[i].fecha}" value='${response.data[i].id}'>ATC-${response.data[i].id} | ${response.data[i].titulo} | ${response.data[i].nombre_estudiante} ${response.data[i].apellido_estudiante} | ${response.data[i].fecha}</option>`)
            }
            // $('#fecha').val(response.data[i].fecha);

        })
        .fail(function () {
            console.log("error");
        })
}

function validarFechaMenorActual(date) {
    var x = new Date();
    var fecha = date.split("/");
    x.setFullYear(fecha[2], fecha[1] - 1, fecha[0]);
    var today = new Date();

    if (x >= today)
        return false;
    else
        return true;
}

function LoadTiposComportamientos() {
    $("#tipo_comportamiento_id").select2({
        placeholder: 'Seleccione el tipo comportamiento',
        allowClear: true,
        dropdownParent: modal,
        width: 'resolve'
    });

    $.ajax({
        url: '/api/tipo_comportamientos',
    })
        .done(function (response) {
            for (var i in response.data) {
                $("#tipo_comportamiento_id").append(`<option value='${response.data[i].id}'>${response.data[i].titulo}</option>`)
            }

        })
        .fail(function () {
            console.log("error");
        })
}

function LoadComportamientos() {
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
                $("#comportamiento_id").append(`<option value='${response.data[i].id}'>${response.data[i].titulo} | ${response.data[i].nombres}  ${response.data[i].apellidos} | CMP${response.data[i].id} </option>`)
            }

        })
        .fail(function () {
            console.log("error");
        })
}

function ModalConfirmacion(titulo) {
    $('#modal_avances_1').removeClass('modal-lg');
    $('#modal_avances_1').addClass('modal-md');

    $('#modal-avances').find('.modal-content').empty().append(`
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">¿Se cumplió con la actividad?</h4>
        </div>
        <div class="modal-body">
            <p>La atividad: <strong>${titulo}</strong> se completo correctamente?</p> 
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success" id="cumplido">Si <i class="fa fa-thumbs-up" aria-hidden="true"></i></button>
            <button type="button" class="btn btn-danger" id="incumplido">No <i class="fa fa-thumbs-down" aria-hidden="true"></i></button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
    `);
}

function ModalAvances(titulo) {
    modal.find('.modal-content').empty().append(`
    <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Segumientos de la actividad | ${titulo}</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <ul class="timeline" id="timeline_avances">
                    
                    </ul>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success" id="check_status">Definir estado</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
    `);
}

function ModalCrearAvances() {
    $('#modal-avances').find('.modal-content').empty().append(`
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Registar Avances de Actividades</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">

                    <div class="form-group">
                        <label>Actividad: </label>
                        <select class="form-control" id="actividad_id" style="width: 100%;">

                        </select>
                    </div>

                    <div class="form-group">
                        <label>Descripcion del avance: </label>
                        <textarea id="descripcion" class="form-control" style="resize: vertical;" rows="3" placeholder="Escriba aqui la descripcion del avance ..."></textarea>
                    </div>

                </div>
                <div class="col-md-6">

                    <div class="form-group">
                        <label>Fecha del Avance: </label>
                        <div class="input-group date" id="timepicker">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" id="fecha" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <a class="btn btn-secondary hide" id="rutaFile"></a>
                        <br>
                        <label>Evidencias: </label>
                        <input type="file" name="files[]" id="evidencias" multiple>
                        
                        <p class="help-block">Suba archivo que evdencie el avance.</p>
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
}

function ModalInfo() {
    modal.find('.modal-content').empty().append(`
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Informacion de la conducta</h4>
            </div>
            <div class="modal-body">
                <p>${AllRegister}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
            `)
}

function ModalHistorial(historial) {

    var html = '';
    for (let i = 0; i < historial.length; i++) {
        html += `<tr>
                    <td>${historial[i].fecha_historial}</td>
                    <td>${historial[i].descripcion_historial}</td>
                    <td>${historial[i].estado_actividad == 1 ? `<i class="fa fa-check-circle" style="color: green;"></i> Cumplida` :
                historial[i].estado_actividad == 2 ? `<i class="fa fa-exclamation-circle" style="color: red;"></i> Incumplida` :
                    `<i class="fa  fa-exclamation-triangle" style="color: orange;" ></i> En espera`}</td>
                </tr>`;

    }

    modal.find('.modal-content').empty().append(`
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Historial de Actividades</h4>
    </div>
    <div class="modal-body">
        
        <table class="table">
        <thead>
        <tr>
            <th scope="col" colspan="3"><h4 style="text-align=center;">${historial[0].titulo} | ATC-${historial[0].id} | ${historial[0].fecha}</h4></th>
        </tr>
        <tr>
            <th scope="col" colspan="3" align="center"><p>La actividad se ha pospuesto ${historial.length} veces</p></th>
        </tr>
        <tr>
            <th scope="col">Fecha anterior</th>
            <th scope="col">Razon por la que se pospuso</th>
            <th scope="col">Estado</th>
        </tr>
        </thead>
        <tbody>
            ${html}
        </tbody>
    </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    </div>
    `);
}

function Modal() {
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
                            <option value="3"> en espera </option>
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
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
    `)
    $("#fecha").datetimepicker({
        format: "YYYY-MM-DD"
    });
}

function ModalReprogramar() {
    modal.find('.modal-content').empty().append(`
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Formulario de Actividades</h4>
        </div>
        <div class="modal-body">

            <div class="row">

                <div class="col-md-12">

                    <div class="form-group">
                        <label >Actividad: </label>
                        <div class="input-group">
                            <select class="form-control" id="actividad_id" style="width: 100%;">

                            </select>
                        </div>
                    </div>   

                </div>

            </div>

            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Informacion de porque se pospone: </label>
                        <textarea id="descripcion_historial" class="form-control" style="resize: vertical;" rows="3" placeholder="Escriba aqui la razon de posponer la actividad ..."></textarea>
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label>Reprogramar Para: </label>
                        <div class="input-group date" id="timepicker">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" id="fechaReprogramar" >
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="save">Guardar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
    `);
    $("#fechaReprogramar").datetimepicker({
        format: "YYYY-MM-DD"
    });
}

function ReloadCalendario() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        timeZone: 'America/Bogota',
        height: 650,
        locale: 'es',
        themeSystem: 'bootstrap4',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
        },
        weekNumbers: true,
        dayMaxEvents: true, // allow "more" link when too many events
        events: [{}],
        eventClick: function (info) {
            if (permisos.includes('show.actividades')) {

                var actividadFilter = JSON.parse(info.event.groupId);

                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                const event = new Date(actividadFilter.fecha.replace('-', '/'));

                if (actividadFilter.id_comportamiento == null) {
                    modal.modal('show')
                    ModalEst(actividadFilter, event, options);
                    $('#avances').on('click', function () {
                        modal.modal('hide');
                        $('#modal-avances').modal('show');
                        ModalCrearAvances();
                        LoadActividad(actividadFilter.id);
                        establecer_fecha();
                        $('#save').on('click', function () {
                            var actividad_id = $('#actividad_id').val(),
                                descripcion = $('#descripcion').val(),
                                fecha = $('#fecha').val(),
                                evidencias = $('#evidencias')[0].files;

                            if (actividad_id == '' || descripcion == '' || fecha == '') {
                                toastr.warning("Complete todos los campos")
                            } else {
                                var form = new FormData();
                                var archivos = 0;
                                jQuery.each(jQuery('#evidencias')[0].files, function (i, file) {
                                    form.append('file' + i, file);
                                    archivos++;
                                });
                                form.append('archivos', archivos);

                                form.append('actividad_id', actividad_id)
                                form.append('descripcion', descripcion)
                                form.append('fecha_avance', fecha)
                                // form.append('evidencias', evidencias)               
                                $('#loading-spinner').show();
                                $.ajax({
                                    url: '/api/avances',
                                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                    type: 'POST',
                                    processData: false,
                                    contentType: false,
                                    data: form,
                                })
                                    .done(function () {
                                        toastr.success("Avance registrado");
                                        setTimeout(function () {
                                            $('#loading-spinner').hide();
                                            $('#modal-avances').modal("hide");
                                        }, 600);
                                        Reload();
                                    })
                                    .fail(function () {
                                        $('#loading-spinner').hide();
                                        toastr.error("Ha ocurrido un error");
                                    })
                                    .always(function () {
                                        $("#save").addClass("disabled");
                                    });
                            }
                        });
                    });
                } else {
                    modal.modal('show')
                    ModalPsico(actividadFilter, event, options);
                    $('#avances').on('click', function () {
                        modal.modal('hide');
                        $('#modal-avances').modal('show');
                        ModalCrearAvances();
                        LoadActividad(actividadFilter.id);
                        establecer_fecha();
                        $('#save').on('click', function () {
                            var actividad_id = $('#actividad_id').val(),
                                descripcion = $('#descripcion').val(),
                                fecha = $('#fecha').val(),
                                evidencias = $('#evidencias')[0].files;

                            if (actividad_id == '' || descripcion == '' || fecha == '') {
                                toastr.warning("Complete todos los campos")
                            } else {
                                var form = new FormData();
                                var archivos = 0;
                                jQuery.each(jQuery('#evidencias')[0].files, function (i, file) {
                                    form.append('file' + i, file);
                                    archivos++;
                                });
                                form.append('archivos', archivos);

                                form.append('actividad_id', actividad_id)
                                form.append('descripcion', descripcion)
                                form.append('fecha_avance', fecha)
                                // form.append('evidencias', evidencias)               
                                $('#loading-spinner').show();
                                $.ajax({
                                    url: '/api/avances',
                                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                    type: 'POST',
                                    processData: false,
                                    contentType: false,
                                    data: form,
                                })
                                    .done(function () {
                                        toastr.success("Avance registrado");
                                        setTimeout(function () {
                                            $('#loading-spinner').hide();
                                            $('#modal-avances').modal("hide");
                                        }, 600);
                                        Reload();
                                    })
                                    .fail(function () {
                                        $('#loading-spinner').hide();
                                        toastr.error("Ha ocurrido un error");
                                    })
                                    .always(function () {
                                        $("#save").addClass("disabled");
                                    });
                            }
                        });
                    });
                }
            }

        }
    });
    calendar.render();

    $.ajax({
        url: "/getActividades",
        type: "GET",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        dataType: "JSON",
    })

        .done(function (response) {
            if (response.actividades.length != 0) {

                for (var i = 0; i < response.actividades.length; i++) {
                    calendar.addEvent({
                        id: response.actividades[i].id,
                        groupId: JSON.stringify(response.actividades[i]),
                        title: response.actividades[i].titulo + ' | ' + 'CMP' + response.actividades[i].id_comportamiento,
                        start: response.actividades[i].fecha,
                        backgroundColor: response.actividades[i].estado == 3 ? '#F4A460' : response.actividades[i].estado == 1 ? '#3CB371' : '#FF6347',
                        borderColor: "gray",
                    })
                }
            } else {
                console.log("Sin actividades")
            }
        })
        .fail(function () {
            console.log("error");
        });
}

function establecer_fecha() {
    var hoy = new Date();
    hoy.setMinutes(hoy.getMinutes() - hoy.getTimezoneOffset());
    hoy = hoy.toJSON().slice(0, 10);
    $("#fecha").val(hoy);
}

function ModalShow(filtro) {
    modal.find('.modal-content').empty().append(`
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Actividad: ${filtro[0].titulo}</h4>
            </div>
            <div class="modal-body">

                <div class="row">

                    <div class="col-md-6">

                        <div class="box box-widget">
                            <div class="box-header">
                                <h3 class="box-title">Informacion de la actividad</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Estado</label>
                                    <p>${filtro[0].estado == 3 ? `<i class="fa  fa-exclamation-triangle" style="color: orange;" ></i> En espera` : filtro[0].estado == 1 ? `<i class="fa fa-check-circle" style="color: green;"></i> Cumplida` : `<i class="fa fa-exclamation-circle" style="color: red;"></i> Incumplida`} </p>
                                </div>
                                <div class="form-group">
                                    <label>Fecha</label>
                                    <p>${filtro[0].fecha}</p>
                                </div>
                                <div class="form-group">
                                    <label>Descripción</label>
                                    <p>${filtro[0].descripcion}</p>
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>

                    <div class="col-md-6">
                        <div class="box box-widget">
                            <div class="box-header with-border">
                                <h3 class="box-title">Datos del Comportamiento</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Titulo de comportamiento</label>
                                    <p>CMP${filtro[0].id_comportamiento} | ${filtro[0].titulo_comportamiento}</p>
                                </div>
                                <div class="form-group">
                                    <label>Descripcion del comportamiento</label>
                                    <p>${filtro[0].descripcion_comportamiento}</p>
                                </div>
                                <div class="form-group">
                                    <label>Conducta</label>
                                    <p>${filtro[0].titulo_tipo_comportamiento}</p>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="box box-widget">
                            <div class="box-header with-border">
                                <h3 class="box-title">Datos del Estudiante</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Estudiante</label>
                                    <p>${filtro[0].nombre_estudiante} ${filtro[0].apellido_estudiante}</p>
                                </div>
                                <div class="form-group">
                                    <label>teléfono</label>
                                    <p>${filtro[0].telefono_estudiante}</p>
                                </div>
                                <div class="form-group">
                                    <label>Correo</label>
                                    <p>${filtro[0].correo_estudiante}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box box-widget">
                            <div class="box-header with-border">
                                <h3 class="box-title">Datos del Acudiente</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Acudiente</label>
                                    <p>${filtro[0].nombre_acudiente} ${filtro[0].apellido_acudiente}</p>
                                </div>
                                <div class="form-group">
                                    <label>teléfono</label>
                                    <p>${filtro[0].telefono_acudiente}</p>
                                </div>
                                <div class="form-group">
                                    <label>Correo</label>
                                    <p>${filtro[0].correo_acudiente}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>

            <div class="modal-footer">
                ${permisos.includes('create.avances') ? `<button type="button" id="avances" class="btn btn-primary">Registrar segumiento</button>` : ``}
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
            `)
}

function ModalShowEst(filtro) {
    modal.find('.modal-content').empty().append(`
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Actividad: ${filtro[0].titulo}</h4>
            </div>
            <div class="modal-body">

                <div class="row">

                    <div class="col-md-12">

                        <div class="box box-widget">
                            <div class="box-header">
                                <h3 class="box-title">Informacion de la actividad</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Estado</label>
                                    <p>${filtro[0].estado == 3 ? `<i class="fa  fa-exclamation-triangle" style="color: orange;" ></i> En espera` : filtro[0].estado == 1 ? `<i class="fa fa-check-circle" style="color: green;"></i> Cumplida` : `<i class="fa fa-exclamation-circle" style="color: red;"></i> Incumplida`} </p>
                                </div>
                                <div class="form-group">
                                    <label>Fecha</label>
                                    <p>${filtro[0].fecha}</p>
                                </div>
                                <div class="form-group">
                                    <label>Descripción</label>
                                    <p>${filtro[0].descripcion}</p>
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>

                </div>
                
            </div>

            <div class="modal-footer">
                ${permisos.includes('create.avances') ? `<button type="button" id="avances" class="btn btn-primary">Registrar seguimeintos</button>` : ``}
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
            `)
}

function ModalEst(actividadFilter, event, options) {
    modal.find('.modal-content').empty().append(`
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Actividad: ${actividadFilter.titulo}</h4>
            </div>
            <div class="modal-body">

                <div class="row">

                    <div class="col-md-12">

                        <div class="box box-widget">
                            <div class="box-header">
                                <h3 class="box-title">Informacion de la actividad</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Estado</label>
                                    <p>${actividadFilter.estado == 3 ? `<i class="fa  fa-exclamation-triangle" style="color: orange;" ></i> En espera` : actividadFilter.estado == 1 ? `<i class="fa fa-check-circle" style="color: green;"></i> Cumplida` : `<i class="fa fa-exclamation-circle" style="color: red;"></i> Incumplida`} </p>
                                </div>
                                <div class="form-group">
                                    <label>Fecha</label>
                                    <p>${actividadFilter.fecha}</p>
                                </div>
                                <div class="form-group">
                                    <label>Descripción</label>
                                    <p>${actividadFilter.descripcion}</p>
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>
                </div>
                
            </div>

            <div class="modal-footer">
                ${permisos.includes('create.avances') ? `<button type="button" id="avances" class="btn btn-primary">Registrar seguimeinto</button>` : ``}
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
            `)
}

function ModalPsico(actividadFilter, event, options) {

    modal.find('.modal-content').empty().append(`
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Actividad: ${actividadFilter.titulo}</h4>
            </div>
            <div class="modal-body">

                <div class="row">

                    <div class="col-md-6">

                        <div class="box box-widget">
                            <div class="box-header">
                                <h3 class="box-title">Informacion de la actividad</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Estado</label>
                                    <p>${actividadFilter.estado == 3 ? `<i class="fa  fa-exclamation-triangle" style="color: orange;" ></i> En espera` : actividadFilter.estado == 1 ? `<i class="fa fa-check-circle" style="color: green;"></i> Cumplida` : `<i class="fa fa-exclamation-circle" style="color: red;"></i> Incumplida`} </p>
                                </div>
                                <div class="form-group">
                                    <label>Fecha</label>
                                    <p>${event.toLocaleDateString('es-CO', options)}</p>
                                </div>
                                <div class="form-group">
                                    <label>Descripción</label>
                                    <p>${actividadFilter.descripcion}</p>
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>

                    <div class="col-md-6">
                        <div class="box box-widget">
                            <div class="box-header with-border">
                                <h3 class="box-title">Datos del Comportamiento</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Titulo de comportamiento</label>
                                    <p>CMP${actividadFilter.id_comportamiento} | ${actividadFilter.titulo_comportamiento}</p>
                                </div>
                                <div class="form-group">
                                    <label>Titulo de comportamiento</label>
                                    <p>${actividadFilter.descripcion_comportamiento}</p>
                                </div>
                                <div class="form-group">
                                    <label>Tipo de comportamiento</label>
                                    <p>${actividadFilter.titulo_tipo_comportamiento}</p>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="box box-widget">
                            <div class="box-header with-border">
                                <h3 class="box-title">Datos del Estudiante</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Estudiante</label>
                                    <p>${actividadFilter.nombre_estudiante} ${actividadFilter.apellido_estudiante}</p>
                                </div>
                                <div class="form-group">
                                    <label>teléfono</label>
                                    <p>${actividadFilter.telefono_estudiante}</p>
                                </div>
                                <div class="form-group">
                                    <label>Correo</label>
                                    <p>${actividadFilter.correo_estudiante}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box box-widget">
                            <div class="box-header with-border">
                                <h3 class="box-title">Datos del Acudiente</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Acudiente</label>
                                    <p>${actividadFilter.nombre_acudiente} ${actividadFilter.apellido_acudiente}</p>
                                </div>
                                <div class="form-group">
                                    <label>teléfono</label>
                                    <p>${actividadFilter.telefono_acudiente}</p>
                                </div>
                                <div class="form-group">
                                    <label>Correo</label>
                                    <p>${actividadFilter.correo_acudiente}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>

            <div class="modal-footer">
                ${permisos.includes('create.avances') ? `<button type="button" id="avances" class="btn btn-primary">Registrar seguimientos</button>` : ``}
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
            `)
}

function Reload() {
    $.ajax({
        url: "/getActividades",
        type: "GET",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        dataType: "JSON",
    })

        .done(function (response) {
            if (response.length != 0) {
                AllRegister = response.actividades;
                response.avances.forEach(element => {
                    AvancesElement.push(element.id_actividad);
                });
                console.log(AvancesElement);
                AllAvances = response.avances;
                permisos = response.permisos;
                DataTable(response.actividades);

            } else {
                $('#actividades-table').dataTable().fnClearTable();
                $('#actividades-table').dataTable().fnDestroy();
                $('#actividades-table thead').empty()
            }
        })

        .fail(function () {
            console.log("error");
        });
}

function LoadActividad(id) {
    $("#actividad_id").select2({
        placeholder: 'Seleccionela actividad',
        allowClear: false,
        dropdownParent: $('#modal-avances'),
        width: 'resolve'
    });

    $.ajax({
        url: '/api/actividades',
    })
        .done(function (response) {
            for (var i in response.data) {
                if (response.data[i].id == id) {
                    $("#actividad_id").append(`<option value='${response.data[i].id}'>${response.data[i].titulo} | ${response.data[i].titulo_comportamiento} | ${response.data[i].nombre_estudiante} ${response.data[i].apellido_estudiante}</option>`)
                }
            }

        })
        .fail(function () {
            console.log("error");
        })
}

function DataTable(response) {

    // console.log("datatable", response)
    if ($.fn.DataTable.isDataTable('#act-table')) {
        $('#act-table').dataTable().fnClearTable();
        $('#act-table').dataTable().fnDestroy();
        $('#act-table thead').empty()
    }
    else {
        $('#act-table thead').empty()
    }


    if (response.length != 0) {
        let my_columns = []
        $.each(response[0], function (key, value) {
            var my_item = {};
            // my_item.class = "filter_C";
            my_item.data = key;


            if (key == 'created_at') {

                my_item.title = 'Seguimiento';

                my_item.render = function (data, type, row) {
                    var html2 = '';
                    // for (let i = 0; i < permisos.length; i++) {


                    if (permisos.includes("show.avances")) {
                        html2 += `<button data-id=${row.id} id="ver-avances">Ver seguimeintos</button>`;
                    }

                    // }
                    return `<div id="campo_avace_${row.id}" align="center">
                                        ${html2}
                                </div>`;
                }

                if (permisos.length != 0 && permisos.includes('show.avances')) {
                    my_columns.push(my_item);
                }
            }

            if (key == 'deleted_at') {

                my_item.title = 'Opcion';

                my_item.render = function (data, type, row) {
                    var html = '';
                    for (let i = 0; i < permisos.length; i++) {
                        if (permisos[i] == "delete.actividades") {
                            html += `
                                    <a data-id=${row.id} id="Btn_delete_${row.id}" class='btn btn-circle btn-sm btn-danger'>
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a> `;
                        } else if (permisos[i] == "edit.actividades") {
                            html += `
                                    <a data-id=${row.id} id="Btn_Edit_${row.id}" class='btn btn-circle btn-sm btn-primary'>
                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                    </a>`;
                        } else if (permisos[i] == "show.actividades") {
                            html += `
                                    <a data-id=${row.id} id="Btn_show_${row.id}" class='btn btn-sm btn-info'>
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a> `;
                        }
                    }
                    return `<div align="center">
                                <div class="btn-group btn-group-circle btn-group-solid" align="center">
                                    ${html}
                                </div>
                            </div>`;

                }
                if (permisos.length != 0 && permisos.includes('show.actividades', 'edit.actividades', 'delete.actividades')) {
                    my_columns.push(my_item);
                }

            }

            else if (key == 'id') {

                my_item.title = '#';

                my_item.render = function (data, type, row) {
                    return `  <div align="center"> 
                                ACT-${row.id}
                            </div>`
                }
                my_columns.push(my_item);

            }
            else if (key == 'titulo') {

                my_item.title = 'Titulo Actividad';

                my_item.render = function (data, type, row) {
                    return `  <div'> 
                                ${row.titulo} <a data-id=${row.id} id="Btn_historial_${row.id}" class='btn btn-circle btn-xs btn-default'>
                                        <i class="fa fa-clock" aria-hidden="true"></i>
                                    </a>
                            </div>`
                }
                my_columns.push(my_item);

            }

            else if (key == 'fecha') {

                my_item.title = 'Fecha';

                my_item.render = function (data, type, row) {
                    return `<div>
                                ${row.fecha} 
                            </div>`
                }
                my_columns.push(my_item);
            }

            else if (key == 'descripcion') {

                my_item.title = 'Descripcion de la actividad';

                my_item.render = function (data, type, row) {
                    return `<div>
                                ${row.descripcion} 
                            </div>`
                }
                my_columns.push(my_item);
            }

            else if (key == 'titulo_comportamiento') {

                my_item.title = 'Comportamiento';

                my_item.render = function (data, type, row) {
                    return `  <div'> 
                                ${row.titulo_comportamiento}
                            </div>`
                }
                my_columns.push(my_item);
            }

            else if (key == 'descripcion_comportamiento') {

                my_item.title = 'Descripcion comportamiento';

                my_item.render = function (data, type, row) {
                    return `  <div'> 
                                ${row.descripcion_comportamiento}
                            </div>`
                }
                my_columns.push(my_item);
            }

            else if (key == 'estado') {

                my_item.title = 'Estado Actividad';

                my_item.render = function (data, type, row) {

                    return `${row.estado == 1 ? `<i class="fa fa-check-circle" style="color: green;"></i> Cumplida` :
                        row.estado == 2 ? `<i class="fa fa-exclamation-circle" style="color: red;"></i> Incumplida` :
                            `<i class="fa  fa-exclamation-triangle" style="color: orange;" ></i> En espera`}`;

                    // return `<i class="fa fa-circle-o text-success">Incumplida</i>`;
                    // if (row.estado == 2) { return `Cumplida` }
                    // else if (row.estado == 1) { return `Incumplida` }
                    // else if (row.estado == 0) { return `En espera` }

                }
                my_columns.push(my_item);
            }

            else if (key == 'nombre_estudiante') {

                my_item.title = 'Estudiante';

                my_item.render = function (data, type, row) {
                    return `<div>
                                ${row.nombre_estudiante + " " + row.apellido_estudiante} 
                            </div>`
                }
                my_columns.push(my_item);
            }

            else if (key == 'titulo_tipo_comportamiento') {

                my_item.title = 'Tipo de comportamiento';

                my_item.render = function (data, type, row) {
                    if(row.titulo_tipo_comportamiento == null){
                        return `Sin asignar`;
                    } else {
                        return `<div>
                                ${row.titulo_tipo_comportamiento} <a data-id=${row.id} id="Btn_info_${row.id}" class='btn btn-circle btn-xs btn-default'>
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                </a>
                            </div>`;
                    }
                }
                my_columns.push(my_item);
            }


        })


        var table = $('#act-table').DataTable({
            "scrollX": my_columns.length >= 5 ? true : false,
            "destroy": false,
            responsive: true,
            "destroy": true,
            data: response,
            "columns": my_columns,
            bProcessing: true,
            bAutoWidth: false,
            data: response,
            "columns": my_columns,
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No hay datos actividades",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ actividades",
                "infoEmpty": "No hay comportamientos registrados",
                "infoFiltered": "(Filtrado de _MAX_  actividades)",
                "lengthMenu": "_MENU_ actividades",
                "search": "Buscar:",
                "zeroRecords": "No se han encontrado registros"
            },
            "order": [
                [2, 'asc']
            ],
        });
        $('thead > tr> th:nth-child(1)').css({ 'min-width': '30px', 'max-width': '30px' });
        $('thead > tr> th:nth-child(2)').css({ 'min-width': '110px', 'max-width': '110px' });
        $('thead > tr> th:nth-child(3)').css({ 'min-width': '90px', 'max-width': '90px' });
        $('thead > tr> th:nth-child(4)').css({ 'min-width': '140px', 'max-width': '140px' });
        $('thead > tr> th:nth-child(7)').css({ 'min-width': '140px', 'max-width': '140px' });
        $('thead > tr> th:nth-child(8)').css({ 'min-width': '140px', 'max-width': '140px' });
        $('thead > tr> th:nth-child(9)').css({ 'min-width': '110px', 'max-width': '110px' });
        $('thead > tr> th:nth-child(11)').css({ 'min-width': '110px', 'max-width': '110px' });
        // $('thead > tr> th:nth-child(2)').css({ 'min-width': '160px', 'max-width': '140px' });
        // $('thead > tr> th:nth-child(3)').css({ 'min-width': '80px', 'max-width': '80px' });
        // $('thead > tr> th:nth-child(4)').css({ 'min-width': '140px', 'max-width': '140px' });
        // $('thead > tr> th:nth-child(7)').css({ 'min-width': '140px', 'max-width': '140px' });
        // $('thead > tr> th:nth-child(8)').css({ 'min-width': '140px', 'max-width': '140px' });
        // $('thead > tr> th:nth-child(10)').css({ 'min-width': '140px', 'max-width': '140px' });
        // $('thead > tr> th:nth-child(10)').css({ 'min-width': '140px', 'max-width': '140px' });

        var rows = table.rows().data();
        var ide;

        for (let index = 0; index < rows.length; index++) {
            ide = rows[index].id;
            console.log(ide);
            if (!AvancesElement.includes(ide)) {
                $('#campo_avace_' + ide + '').empty();
                $('#campo_avace_' + ide + '').append(`<p>Sin seguimeintos registrados</p>`);
            }
        }
    }
}
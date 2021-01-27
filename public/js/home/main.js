var modal = $('#modal-home');
var AllRegister = [];
var permisos = [];

$(document).ready(function () {
    Reload();
    ReloadCalendario();
})



function ReloadCalendario() {
    var calendarEl = document.getElementById('calendar_home');
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

            var actividadFilter = JSON.parse(info.event.groupId);

            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const event = new Date(actividadFilter.fecha.replace('-', '/'));

            if (actividadFilter.titulo_tipo_comportamiento == null) {
                modal.modal('show');
                ModalEst(actividadFilter, event, options);
                $('#avances').on('click', function () {
                    modal.modal('hide');
                    $('#modal-avances').modal('show');
                    ModalAvances();
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
                                    ReloadCalendario();
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
                    ModalAvances();
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
                                    ReloadCalendario();
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

function ModalEst(actividadFilter, event, options) {
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
                        <h3 class="box-title">Información de la Actividad</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Estado</label>
                            <p>${actividadFilter.estado == 3 ? "En espera" : actividadFilter.estado == 1 ? "Cumplida" : "Inclumplida"}</p>
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

            <div class="col-md-6">
                <div class="box box-widget">
                    <div class="box-header with-border">
                        <h3 class="box-title">Datos del Comportamiento</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Titulo de Comportamiento</label>
                            <p>${actividadFilter.titulo_comportamiento}</p>
                        </div>
                        <div class="form-group">
                            <label>Descripción de comportamiento</label>
                            <p>${actividadFilter.descripcion_comportamiento}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>



        </div>



    </div>

    <div class="modal-footer">
    ${permisos.includes('create.avances') ? `<button type="button" id="avances" class="btn btn-primary">Subir avances</button>` : ``}
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
                                <h3 class="box-title">Informacion de la Actividad</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Estado</label>
                                    <p>${actividadFilter.estado == 3 ? "En Espera" : actividadFilter.estado == 1 ? "Cumplida" : "Inclumplida"} </p>
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
                                    <label>Título de Comportamiento</label>
                                    <p>CMP${actividadFilter.id_comportamiento} | ${actividadFilter.titulo_comportamiento}</p>
                                </div>
                                <div class="form-group">
                                    <label>Descripción de Comportamiento</label>
                                    <p>${actividadFilter.descripcion_comportamiento}</p>
                                </div>
                                <div class="form-group">
                                    <label>Coducta</label>
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
            ${permisos.includes('create.avances') ? `<button type="button" id="avances" class="btn btn-primary">Subir avances</button>` : ``}
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
            `)
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

function ModalAvances() {
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

function Reload() {
    $.ajax({
        url: "/getActividades",
        type: "GET",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        dataType: "JSON",
    })

        .done(function (response) {
            if (response.actividades.length != 0) {
                var contC = 0;
                var contI = 0;
                var contE = 0;
                AllRegister = response.actividades;
                permisos = response.permisos;

                for (var i = 0; i < response.actividades.length; i++) {
                    if (response.actividades[i].estado == 3) {
                        contE++;
                    } else if (response.actividades[i].estado == 1) {
                        contC++;
                    } else {
                        contI++;
                    }
                }

                $('#act-total').html("" + response.actividades.length);
                $('#act-cumplidas').html("" + contC);
                $('#act-espera').html("" + contE);
                $('#act-incumplidas').html("" + contI);

            } else {
                $('#act-total').html("" + 0);
                $('#act-cumplidas').html("" + 0);
                $('#act-espera').html("" + 0);
                $('#act-incumplidas').html("" + 0);

            }
        })

        .fail(function () {
            console.log("error");
        });
}
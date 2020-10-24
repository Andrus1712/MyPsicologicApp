var modal = $('#modal-home');
var AllRegister = []

$(document).ready(function () {
    ReloadCalendario()
    Reload()
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
                modal.modal('show')
                ModalEst(actividadFilter, event, options);
            } else {
                modal.modal('show')
                ModalPsico(actividadFilter, event, options);
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
            if (response.length != 0) {

                for (var i = 0; i < response.length; i++) {
                    calendar.addEvent({
                        id: response[i].id,
                        groupId: JSON.stringify(response[i]),
                        title: response[i].titulo,
                        start: response[i].fecha,
                        backgroundColor: response[i].estado == 0 ? '#F4A460' : response[i].estado == 1 ? '#3CB371' : '#FF6347',
                        borderColor: "gray",
                    })
                }
            } else {
                alert("Sin actividades")
            }
        })
        .fail(function () {
            console.log("error");
        });
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
                        <h3 class="box-title">Informacion de la actividad</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Estado</label>
                            <p>${actividadFilter.estado == 0 ? "En espera" : actividadFilter.estado == 1 ? "Cumplida" : "Inclumplida"}</p>
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
                            <label>Titulo de comportamiento</label>
                            <p>${actividadFilter.titulo_comportamiento}</p>
                        </div>
                        <div class="form-group">
                            <label>Titulo de comportamiento</label>
                            <p>${actividadFilter.descripcion_comportamiento}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>



        </div>



    </div>

    <div class="modal-footer">
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
                                    <p>${actividadFilter.estado == 0 ? "En espera" : actividadFilter.estado == 1 ? "Cumplida" : "Inclumplida"} </p>
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
                                    <p>${actividadFilter.titulo_comportamiento}</p>
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
                var contC = 0;
                var contI = 0;
                var contE = 0;
                AllRegister = response;

                for (var i = 0; i < response.actividades.length; i++) {
                    if (response[i].actividades.estado == 0) {
                        contE++;
                    } else if (response[i].actividades.estado == 1) {
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
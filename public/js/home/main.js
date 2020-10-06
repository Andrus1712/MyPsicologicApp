var modal = $('#modal-home');

$(document).ready(function(){
    ReloadCalendario()
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
        eventClick: function(info) {
            var actividadFilter = JSON.parse(info.event.groupId);
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const event = new Date(actividadFilter.fecha.replace('-', '/'));
            // console.log(actividadFilter)
            modal.modal('show')
            modal.find('.modal-content').empty().append(`
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Actividad ${actividadFilter.titulo}</h4>
            </div>
            <div class="modal-body">

                <div class="row">

                    <div class="col-md-6">
                        <div class="clearfix"></div>

                        <div class="box box-widget">
                            <div class="box-header">
                                <h3 class="box-title">Informacion de la actividad</h3>
                            </div>
                            <div class="box-body with-border">
                                <div class="form-group">
                                    <label>Estado</label>
                                    <input type="text" class="form-control" value="${actividadFilter.estado==0? "En espera" : actividadFilter.estado==1 ? "Cumplida" : "Inclumplida"}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Fecha</label>
                                    <input type="text" class="form-control" value="${event.toLocaleDateString('es-CO', options)}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Descripción</label>
                                    <textarea class="form-control" readonly>${actividadFilter.descripcion }</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        
                    </div>

                    <div class="col-md-6">
                        <div class="clearfix"></div>
                        <div class="box box-widget">
                            <div class="box-header with-border">
                                <h3 class="box-title">Datos del estudiante</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Estudiante</label>
                                    <input type="text" class="form-control" value="${actividadFilter.nombre_estudiante} ${actividadFilter.apellido_estudiante}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="box box-widget">
                            <div class="box-header with-border">
                                <h3 class="box-title">Datos del Comportamiento</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Titulo de comportamiento</label>
                                    <input type="text" class="form-control" value="${actividadFilter.titulo_comportamiento}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Tipo de comportamiento</label>
                                    <input type="text" class="form-control" value="${actividadFilter.titulo_tipo_comportamiento}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>

                <div>

                
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
            `)
            
        }
    });
    calendar.render();

    $.ajax({
        url: "/api/actividades",
        type: "GET",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        dataType: "JSON",
    })

        .done(function (response) {
            if (response.length != 0) {

                for (var i = 0; i < response.data.length; i++) {
                    calendar.addEvent({
                        id: response.data[i].id,
                        groupId: JSON.stringify(response.data[i]),
                        title: response.data[i].titulo,
                        start: response.data[i].fecha,
                        backgroundColor: response.data[i].estado == 0 ? '#F4A460' : response.data[i].estado == 1 ? '#3CB371' : '#FF6347',
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
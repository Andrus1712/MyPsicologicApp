$(document).ready(function(){
    LoadCalendario()
})

function LoadCalendario() {
    var calendarEl = document.getElementById('calendar_home');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        timeZone: 'America/Bogota',
        locale: 'es',
        themeSystem: 'bootstrap',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
        },
        weekNumbers: true,
        dayMaxEvents: true, // allow "more" link when too many events
        events: 'https://fullcalendar.io/demo-events.json'
    });

    calendar.render();
}
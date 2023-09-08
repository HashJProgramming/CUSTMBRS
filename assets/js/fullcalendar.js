document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
  
    var calendar = new FullCalendar.Calendar(calendarEl, {
      themeSystem: 'bootstrap5',
      initialView: 'dayGridMonth',
      initialDate: '2023-09-07',
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
      },
      events: [
        {
          title: '<cottage> | <customer>',
          start: '2023-09-08T09:30:00',
          end: '2023-09-08T11:00:00'
        },{
            title: '<cottage> | <customer>',
            start: '2023-09-09T09:30:00',
            end: '2023-09-09T11:00:00'
        },{
            title: '<cottage> | <customer>',
            start: '2023-09-10T09:30:00',
            end: '2023-09-010T11:00:00'
        },{
            title: '<cottage> | <customer>',
            start: '2023-09-11T09:30:00',
            end: '2023-09-11T11:00:00'
        },{
            title: '<cottage> | <customer>',
            start: '2023-09-15T09:30:00',
            end: '2023-09-15T11:00:00'
        },
      ]
    });
  
    calendar.render();
  });
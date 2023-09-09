document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');

  var calendar = new FullCalendar.Calendar(calendarEl, {
      themeSystem: 'bootstrap5',
      initialView: 'dayGridMonth',
      initialDate: new Date(),
      headerToolbar: {
          left: 'prev,next',
          right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
      },
      events: {
          url: 'functions/data/get-calendar.php',
          method: 'GET',
          extraParams: {
              action: 'get_calendar'
          },
          failure: function() {
              alert('There was an error while fetching calendar data.');
          }
      }
  });

  calendar.render();
});

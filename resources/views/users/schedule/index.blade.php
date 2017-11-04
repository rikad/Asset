@extends('layouts.app')

@section('content')
<div class="main" style="margin-top: 1em">
  <div class="main-inner">
    <div class="container">

      <div class="row">
        <div class="span12">

          <div class="widget">

            <div class="widget-content">


                  <div class="shortcuts">

                  <a href="{{ route('home') }}" class="shortcut"><i class="shortcut-icon icon-list-alt"></i><span class="shortcut-label">Greenhouse Status</span> </a>

                  <a href="{{ route('utilities.index') }}" class="shortcut"><i class="shortcut-icon icon-bookmark"></i><span class="shortcut-label">Utilities</span> </a>

                  <a href="{{ route('schedule.index') }}" class="shortcut shortcut-active"><i class="shortcut-icon icon-calendar"></i> <span class="shortcut-label">Planting Schedule</span> </a>

                  <a href="{{ route('plant.index') }}" class="shortcut"> <i class="shortcut-icon icon-globe"></i><span class="shortcut-label">Plant</span> </a>

                  </div>
                  <!-- /shortcuts --> 


                  </div>
                  <!-- /widget-content --> 
            </div>
            <!-- /widget -->

          </div>
        </div>

        <div class="row">
          <div class="span12">

          <div class="widget">

            <!-- /widget-header -->
            <div class="widget-content"  style="padding-top: 4em">
              <div id='calendar'>
              </div>
            </div>
            <!-- /widget-content --> 
          </div>
          <!-- /widget -->


          </div>
        </div>

      </div>
    </div>
  </div>

  @endsection

  @section('js')
  <script type="text/javascript" src="js/full-calendar/fullcalendar.min.js"></script>

  <script>     
        $(document).ready(function() {
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        var calendar = $('#calendar').fullCalendar({
          header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
          },
          selectable: true,
          selectHelper: true,
          select: function(start, end, allDay) {
            var title = prompt('Event Title:');
            if (title) {
              calendar.fullCalendar('renderEvent',
                {
                  title: title,
                  start: start,
                  end: end,
                  allDay: allDay
                },
                true // make the event "stick"
              );
            }
            calendar.fullCalendar('unselect');
          },
          editable: true,
          events: [
            {
              title: 'All Day Event',
              start: new Date(y, m, 1)
            },
            {
              title: 'Long Event',
              start: new Date(y, m, d+5),
              end: new Date(y, m, d+7)
            },
            {
              id: 999,
              title: 'Repeating Event',
              start: new Date(y, m, d-3, 16, 0),
              allDay: false
            },
            {
              id: 999,
              title: 'Repeating Event',
              start: new Date(y, m, d+4, 16, 0),
              allDay: false
            },
            {
              title: 'Meeting',
              start: new Date(y, m, d, 10, 30),
              allDay: false
            },
            {
              title: 'Lunch',
              start: new Date(y, m, d, 12, 0),
              end: new Date(y, m, d, 14, 0),
              allDay: false
            },
            {
              title: 'Birthday Party',
              start: new Date(y, m, d+1, 19, 0),
              end: new Date(y, m, d+1, 22, 30),
              allDay: false
            },
            {
              title: 'EGrappler.com',
              start: new Date(y, m, 28),
              end: new Date(y, m, 29),
              url: 'http://EGrappler.com/'
            }
          ]
        });
      });

  </script>
  @endsection

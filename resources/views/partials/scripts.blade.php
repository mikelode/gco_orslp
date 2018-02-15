<!-- REQUIRED JS SCRIPTS -->
<script src="{{ asset('/plugins/jquery-mask/dist/jquery.mask.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/jsnumeral/min/numeral.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/jexcel/dist/js/excel-formula.js') }}" type="text/javascript"></script>

<script src="{{ asset('/js/excanvas.min.js') }}" type="text/javascript"></script> 
<script src="{{ asset('/js/chart.min.js') }}" type="text/javascript"></script> 
<script src="{{ asset('/js/popper.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/bootstrap4/dist/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
<script language="javascript" type="text/javascript" src="{{ asset('/js/full-calendar/fullcalendar.min.js') }}"></script>

<script src="{{ asset('/js/base.js') }}" type="text/javascript"></script>

<script src="{{ asset('/plugins/select2/select2.full.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('/plugins/jexcel/dist/js/jquery.csv.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/jexcel/dist/js/jquery.jexcel.js') }}" type="text/javascript"></script>

<script src="{{ asset('/plugins/jqueryui-editable/js/jqueryui-editable.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/SlickGrid2/lib/jquery.event.drag-2.3.0.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/SlickGrid2/slick.core.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/SlickGrid2/plugins/slick.cellrangedecorator.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/SlickGrid2/plugins/slick.cellrangeselector.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/SlickGrid2/plugins/slick.cellselectionmodel.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/SlickGrid2/slick.formatters.js')}}" type="text/javascript"></script>
<script src="{{ asset('/plugins/SlickGrid2/slick.editors.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/SlickGrid2/slick.grid.js') }}" type="text/javascript"></script>

<script type="text/javascript" src="{{ asset('/js/symva.js') }}"></script>
<script>     

        var lineChartData = {
            labels: ["January", "February", "March", "April", "May", "June", "July"],
            datasets: [
        {
            fillColor: "rgba(220,220,220,0.5)",
            strokeColor: "rgba(220,220,220,1)",
            pointColor: "rgba(220,220,220,1)",
            pointStrokeColor: "#fff",
            data: [65, 59, 90, 81, 56, 55, 40]
        },
        {
            fillColor: "rgba(151,187,205,0.5)",
            strokeColor: "rgba(151,187,205,1)",
            pointColor: "rgba(151,187,205,1)",
            pointStrokeColor: "#fff",
            data: [28, 48, 40, 19, 96, 27, 100]
        }
      ]

        }

        //var myLine = new Chart(document.getElementById("area-chart").getContext("2d")).Line(lineChartData);


        var barChartData = {
            labels: ["January", "February", "March", "April", "May", "June", "July"],
            datasets: [
        {
            fillColor: "rgba(220,220,220,0.5)",
            strokeColor: "rgba(220,220,220,1)",
            data: [65, 59, 90, 81, 56, 55, 40]
        },
        {
            fillColor: "rgba(151,187,205,0.5)",
            strokeColor: "rgba(151,187,205,1)",
            data: [28, 48, 40, 19, 96, 27, 100]
        }
      ]

        }    

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
</script><!-- /Calendar -->
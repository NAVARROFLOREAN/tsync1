<!doctype html>
<html lang="en">
<head>
<title>T-Sync</title>
  <link href='https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css' rel='stylesheet'>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.5.1/fullcalendar.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.5.1/fullcalendar.min.js"></script>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ekko Lightbox -->
  <link rel="stylesheet" href="../plugins/ekko-lightbox/ekko-lightbox.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">

  <x-app-layout>
</head>
<body>
   
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
               Calendar
        </div>
        <div class="panel-body" >
            <div id='calendar'></div>
        </div>
    </div>
</div><footer id="footer" class="footer" style="background:#9c9a9a;" style=" position: absolute;
left: 10px;
bottom: 10px;
width: 100%;
text-align: center;">

    <div class="footer-legal">
    <div class="container">

    <div class="row justify-content-between">
    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
    <footer class="container">
    <p style="color: #3e556f;">&copy; 2024 T-Sync. &middot; <a href="#" style="color: #3e556f;">Privacy</a> &middot; <a href="#" style="color: #3e556f;">Terms</a></p>
    </footer>

    <div class="credits">
    <!-- All the links in the footer should remain intact. -->
    <!-- You can delete the links only if you purchased the pro version. -->
    <!-- Licensing information: https://bootstrapmade.com/license/ -->
    <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/herobiz-bootstrap-business-template/ -->
    </div>

    </div>

    <div class="col-md-6">
    <div class="social-links mb-3 mb-lg-0 text-center text-md-end">
    <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
    <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
    <a href="#" class="github"><i class="bi bi-github"></i></a>
    </div>

</body>
<script>
    $(document).ready(function () {
        var calendar = $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,basicWeek,basicDay'
            },
            navLinks: true,
            editable: true,
            events: "getevent",           
            displayEventTime: false,
            eventRender: function (event, element, view) {
                if (event.allDay === 'true') {
                    event.allDay = true;
                } else {
                    event.allDay = false;
                }
            },
        selectable: true,
        selectHelper: true,
        select: function (start, end, allDay) {
            var title = prompt('Event Title:');
            if (title) {
                var start = moment(start, 'DD.MM.YYYY').format('YYYY-MM-DD'); 
                var end = moment(end, 'DD.MM.YYYY').format('YYYY-MM-DD'); 
                $.ajax({ 
                    url: "{{ URL::to('createevent') }}",
                    data: 'title=' + title + '&start=' + start + '&end=' + end +'&_token=' +"{{ csrf_token() }}",
                    type: "POST",
                    success: function (data) {
                        alert("Added Successfully");
                        $('#calendar').fullCalendar('refetchEvents');
                    }
                });
            }
        },
        eventClick: function (event) {
            var deleteMsg = confirm("Do you really want to delete?");
            if (deleteMsg) { 
               $.ajax({
                    type: "POST",
                    url: "{{ URL::to('deleteevent') }}",
                    data: "&id=" + event.id+'&_token=' +"{{ csrf_token() }}",
                    success: function (response) {
                        if(parseInt(response) > 0) {
                            $('#calendar').fullCalendar('removeEvents', event.id);
                            alert("Deleted Successfully");
                        }
                    }
                });
            }
        }
        });
    });
</script>
</html>
</x-app-layout>

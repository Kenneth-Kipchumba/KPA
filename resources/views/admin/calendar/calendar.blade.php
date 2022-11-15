@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('global.systemCalendar') }}
    </div>

    <div class="card-body">
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />

        <div id='calendar'></div>
    </div>
</div>



@endsection

@section('scripts')
@parent
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
<script>
    $(document).ready(function () {
            // page is now ready, initialize the calendar...
            events={!! json_encode($events) !!};
            $('#calendar').fullCalendar({
                    // put your options and callbacks here
                    events: events,
                    
                    defaultView: 'month',

                    header: { 
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                    },
                    views: {
                    month: { // name of view
                        titleFormat: 'YYYY, MM, DD'
                        // other view-specific options here
                    }
                }


            })
        });
</script>
@stop
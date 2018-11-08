<div class="container">
    <div class="row">
        <div id="calendar"></div>
    </div>
</div>

<script>

    $(document).ready(function() {
        
        $('#calendar').fullCalendar({
            defaultView: 'agendaWeek',
            themeSystem: 'bootstrap4',
            locale: 'fr',
            header: {
                //left: 'prev,next today',
                //center: 'title',
                right: 'agendaWeek,listWeek'//basicWeek
            },
            duration: { days: 4 , hours:23, minutes:59 }, // an object
            minTime:'10:00:00',
            maxTime:'24:00:05',
            //hauteur générale
            // height: 100,
            // hauteur du contenu
            // contentHeight: auto,
            defaultDate: '2018-10-24',
            formatRange : 'LTS',
            nowIndicator : true,
            navLinks: true, // can click day/week names to navigate views
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            events: [
                {
                title: 'PUBG',
                start: '2018-10-24T14:00:00',
                end: '2018-10-24T16:30:00'
                },
                {
                title: 'SCUM',
                start: '2018-10-26T10:00:00',
                end: '2018-10-26T13:00:00'
                },
                {
                title: 'Worlds League of Legends',
                start: '2018-10-28T08:30:00',
                end: '2018-10-28T14:00:00'
                },
                {
                title: 'Click for Google',
                url: 'http://google.com/',
                start: '2018-03-28'
                }
            ]
        });
            
            /*
            $('#calendar').fullCalendar({
                defaultView: 'basicWeek',
                header: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'basicDay,basicWeek'
                },
                events: 'https://fullcalendar.io/demo-events.json'
            });
            */
    });


</script>
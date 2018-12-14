<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?php echo $sidebar->showSidebar(); ?>
        </div>
        <div class="col-md-8">
            <div id="calendar"></div>
        </div>
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
            minTime: "<?php echo $data['firstHour']; ?>",
            maxTime: "<?php echo $data['lastHour']; ?>",
            //hauteur générale
            height: 600,
            // hauteur du contenu
            // contentHeight: auto,
            //defaultDate: '2018-10-24',
            formatRange : 'LTS',
            nowIndicator : true,
            navLinks: true, // can click day/week names to navigate views
            //editable: true,
            eventLimit: true, // allow "more" link when too many events
            events: [
                <?php foreach ($data['events'] as $key => $event) {
                    echo '{';
                    echo '"title": "'.$event['title'].'",';
                    echo '"start": "'.$event['start'].'",';
                    echo '"end": "'.$event['end'].'"';
                    echo '},';
                } ?>            
            ]
        });
    });


</script>
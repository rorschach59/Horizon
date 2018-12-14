<br/>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?php //echo $sidebar->showSidebar(); ?>
        </div>
        <div class="col-md-7 col-sm-7 col-xs-7">
            <div id="calendar"></div>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-2">
            <div id='wrap'>
                <div id='external-events'>
                    <h4>Jeux possibles</h4>
                    <?php foreach ($games as $game) {
                        
                        echo '<div class="fc-event">'.$game['title'].'</div>';
                    
                     }?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <form id="addGame" action="" method="POST">
                <input type="hidden" name="addGame" value="addGame">
                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <label for="game_title">Nom du jeu</label>
                            <input type="text" class="form-control" id="game_title" name="game_title" placeholder="GTA V RP" data-validation="length" data-validation-length="min3">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Ajouter le jeu</button>
            </form>
        </div>
    </div>
</div>

<script>

    $(document).ready(function() {

        // initialize the external events
        $('#external-events .fc-event').each(function() {

            // store data so the calendar knows to render an event upon drop
            $(this).data('event', {
                title: $.trim($(this).text()), // use the element's text as the event title
                stick: true // maintain when user navigates (see docs on the renderEvent method)
            });

            // make the event draggable using jQuery UI
            $(this).draggable({
                zIndex: 999,
                revert: true,      // will cause the event to go back to its
                revertDuration: 0  //  original position after the drag
            });

        });

        // initialize the calendar
        $('#calendar').fullCalendar({
            defaultView: 'agendaWeek',
            themeSystem: 'bootstrap4',
            locale: 'fr',
            header: {
                right: 'agendaWeek,listWeek'//basicWeek
            },
            editable: true,
            droppable: true, // this allows things to be dropped onto the calendar
            eventRender: function(event, element) {
                element.append('<span class="removebtn" style="z-index: 999;">X</span>');
                element.find('.removebtn').on('click',function() {
                    $('#calendar').fullCalendar('removeEvents',event._id);
                    $.ajax({
                        url : '/ajoutPlanning/',
                        type : 'POST',
                        data: {
                            'title': event.title,
                            'uid': event.source.uid,
                            'event_id': event._id,
                            'deleteProg': 'deleteProg'
                        },
                        success : function(resultat, data, statut, response){}
                    });
                });
            },
            drop: function(element) {},
            eventDrop: function(event, element) {},
            eventReceive : function(event) {},
            eventResize : function(event) {
                $.ajax({
                    url : '/ajoutPlanning/',
                    type : 'POST',
                    data: {
                        'title': event.title,
                        'start': moment(event.start._d).format('DD-MM-YYYY hh:mm:ss'),
                        'end': moment(event.end._d).format('DD-MM-YYYY hh:mm:ss'),
                        'uid': event.source.uid,
                        'event_id': event._id,
                        'addProg': 'addProg'
                    },
                    success : function(resultat, data, statut, response){}
                });
            }
        });


    function checkInput(_selector, _selectorError) {

        // regex format date DD/MM/AAAA hh:mm:ss
        var regex = /^(((0[1-9]|[12]\d|3[01])[\/\.-](0[13578]|1[02])[\/\.-]((19|[2-9]\d)\d{2})\s(0[0-9]|1[0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9]))|((0[1-9]|[12]\d|30)[\/\.-](0[13456789]|1[012])[\/\.-]((19|[2-9]\d)\d{2})\s(0[0-9]|1[0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9]))|((0[1-9]|1\d|2[0-8])[\/\.-](02)[\/\.-]((19|[2-9]\d)\d{2})\s(0[0-9]|1[0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9]))|((29)[\/\.-](02)[\/\.-]((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))\s(0[0-9]|1[0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])))$/g;

        if( !regex.test(_selector.val()) ) {
            if(!_selector.hasClass('error')) {
                _selector.addClass('error');
                _selector.css('border-color', 'rgb(185, 74, 72)');
            }
            if(!_selector.parent().hasClass('has-error')) {
                _selector.parent().addClass('has-error');
            }
            if(_selectorError.hasClass('d-none')) {
                _selectorError.removeClass('d-none');
            }
            
        } else {
            if(_selector.hasClass('error')) {
                _selector.removeClass('error');
                _selector.css('border-color', 'black');
            }
            if(_selector.parent().hasClass('has-error')) {
                _selector.parent().removeClass('has-error');
            }
            if(!_selectorError.hasClass('d-none')) {
                _selectorError.addClass('d-none');
            }
        }
    }

    $('#stream_beginning').on('blur', function() {         
        checkInput($('#stream_beginning') , $('.stream_beginning_error'));
    });

    $('#stream_finishing').on('blur', function() {         
        checkInput($('#stream_finishing') , $('.stream_finishing_error'));
    });
    
});

</script>
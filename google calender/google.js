var CalendarGoogle = function() {

    return {
        //main function to initiate the module
        init: function() {

            $('#m_calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,listYear'
                },

                displayEventTime: false, // don't show the time column in list view

                // THIS KEY WON'T WORK IN PRODUCTION!!!
                // To make your own Google API key, follow the directions here:
                // http://fullcalendar.io/docs/google_calendar/
                googleCalendarApiKey: 'AIzaSyDcnW6WejpTOCffshGDDb4neIrXVUA1EAE',
            
                // US Holidays
                events: [
						{
							title: 'Birthday Party',   
							start: '2018-02-26T07:00:00',
							className: "m-fc-event--primary m-fc-event-kapitan",
							description: 'Lorem ipsum dolor sit amet, scing'
						}
					],
                
                eventClick: function(event) {
                    // opens events in a popup window
                    // window.open(event.url, 'gcalevent', 'width=700,height=600');
					if (event.url) {
						return false;
					}
                },
                
                loading: function(bool) {
                    return;

                    /*
                    mApp.block(portlet.getSelf(), {
                        type: 'loader',
                        state: 'success',
                        message: 'Please wait...'  
                    });
                    */
                },                

                eventRender: function(event, element) {
                    if (!event.description) {
                        return;
                    }
                    element.on('click', function (e) {
						console.log(element);
						if(element.hasClass('m-fc-event-kapitan'))
						{
							alert("window.location = will redirect cetain place");
						}
						// if (element.closest('.fc-day-grid-event').length > 0) {
							// e.preventDefault();
						// }
					});
					
                    if (element.hasClass('fc-day-grid-event')) {
                        element.data('content', event.description);
                        element.data('placement', 'top');
                        mApp.initPopover(element); 
                    } else if (element.hasClass('fc-time-grid-event')) {
                        element.find('.fc-title').append('<div class="fc-description">' + event.description + '</div>'); 
                    } else if (element.find('.fc-list-item-title').lenght !== 0) {
                        element.find('.fc-list-item-title').append('<div class="fc-description">' + event.description + '</div>'); 
                    }
                }
            });
        }
    };
}();

jQuery(document).ready(function() {
    CalendarGoogle.init();
	$('#m_calendar').fullCalendar('addEventSource', 'en.malaysia#holiday@group.v.calendar.google.com');	 
});
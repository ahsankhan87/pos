var Calendar = function () {

    return {
        //main function to initiate the module
        init: function () {
            Calendar.initCalendar();
        },

        initCalendar: function () {

            if (!jQuery().fullCalendar) {
                return;
            }

            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();

            var h = {};

            if (App.isRTL()) {
                 if ($('#calendar').parents(".portlet").width() <= 720) {
                    $('#calendar').addClass("mobile");
                    h = {
                        right: 'title, prev, next',
                        center: '',
                        right: 'agendaDay, agendaWeek, month, today'
                    };
                } else {
                    $('#calendar').removeClass("mobile");
                    h = {
                        right: 'title',
                        center: '',
                        left: 'agendaDay, agendaWeek, month, today, prev,next'
                    };
                }                
            } else {
                 if ($('#calendar').parents(".portlet").width() <= 720) {
                    $('#calendar').addClass("mobile");
                    h = {
                        left: 'title, prev, next',
                        center: '',
                        right: 'today,month,agendaWeek,agendaDay'
                    };
                } else {
                    $('#calendar').removeClass("mobile");
                    h = {
                        left: 'title',
                        center: '',
                        right: 'prev,next,today,month,agendaWeek,agendaDay'
                    };
                }
            }
           

            var initDrag = function (el) {
                // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                // it doesn't need to have a start or end
                var eventObject = {
                    title: $.trim(el.text()) // use the element's text as the event title
                };
                // store the Event Object in the DOM element so we can get to it later
                el.data('eventObject', eventObject);
                // make the event draggable using jQuery UI
                el.draggable({
                    zIndex: 999,
                    revert: true, // will cause the event to go back to its
                    revertDuration: 0 //  original position after the drag
                });
            }

            var addEvent = function (title) {
                title = title.length == 0 ? "Untitled Event" : title;
                var html = $('<div class="external-event label label-default">' + title + '</div>');
                jQuery('#event_box').append(html);
                initDrag(html);
            }

            $('#external-events div.external-event').each(function () {
                initDrag($(this))
            });

            $('#event_add').unbind('click').click(function () {
                var title = $('#event_title').val();
                addEvent(title);
            });

            //predefined events
            $('#event_box').html("");
            addEvent("My Event 1");
            addEvent("My Event 2");
            addEvent("My Event 3");
            addEvent("My Event 4");
            addEvent("My Event 5");
            addEvent("My Event 6");
            
            $('#calendar').fullCalendar('destroy'); // destroy the calendar
            $('#calendar').fullCalendar({ //re-initialize the calendar
                header: h,
                slotMinutes: 15,
                editable: true,
                //isRTL:true,
                events: site_url+'/pos/C_eventCalendar/eventCalendarJSON',
                droppable: true, // this allows things to be dropped onto the calendar !!!
                drop: function (date, allDay) { // this function is called when something is dropped

                    // retrieve the dropped element's stored Event Object
                    var originalEventObject = $(this).data('eventObject');
                    // we need to copy it, so that multiple events don't have a reference to the same object
                    var copiedEventObject = $.extend({}, originalEventObject);

                    // assign it the date that was reported
                    copiedEventObject.start = date;
                    copiedEventObject.allDay = allDay;
                    copiedEventObject.className = $(this).attr("data-class");
                    
                    // render the event on the calendar
                    // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                    $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

                    // is the "remove after drop" checkbox checked?
                    if ($('#drop-remove').is(':checked')) {
                        // if so, remove the element from the "Draggable Events" list
                        $(this).remove();
                    }
                },
                selectable: true,
				selectHelper: true,
				/*
					when user select timeslot this option code will execute.
					It has three arguments. Start,end and allDay.
					Start means starting time of event.
					End means ending time of event.
					allDay means if events is for entire day or not.
				*/
				select: function(start, end, allDay)
				{
					var title = prompt('Event Title:');
					if (title)
					{
					        var start1 = moment(start).format('YYYY-MM-DD hh:mm:ss'); 
                            var end1 = moment(end).format('YYYY-MM-DD hh:mm:ss');
                            
                            $.ajax({
                                url: site_url+'/pos/C_eventCalendar/saveEventCalendar',
                                data: 'title=' + title + '&start=' + start1 + '&end=' + end1,
                                type: "POST",
                                success: function (json) {
                                    alert('Added Successfully');
                                }
                            });

						$('#calendar').fullCalendar('renderEvent',
							{
								title: title,
								start: start,
								end: end,
                                //allDay: allDay
							},
							true // make the event "stick"
						);
					}
					$('#calendar').fullCalendar('unselect');
				},
                /*Drop & Edit event */
                eventDrop: function(event,delta){
                    var start1 = moment(event.start).format('YYYY-MM-DD hh:mm:ss'); 
                    var end1 = moment(event.end).format('YYYY-MM-DD hh:mm:ss');
                            
                    $.ajax({
                    	   url: site_url+'/pos/C_eventCalendar/updateEventCalendar',
                    	   data: 'title=' + event.title + '&start=' + start1 + '&end=' + end1 + '&id='+ event.id ,
                    	   type: "POST",
                    	   success: function(json) {
                    	    alert("Updated Successfully");
                    	   }
                       });  
                },
                /*Resize event */
                resizable: true,
                eventResize: function(event, delta, revertFunc){
                    var start1 = moment(event.start).format('YYYY-MM-DD hh:mm:ss'); 
                    var end1 = moment(event.end).format('YYYY-MM-DD hh:mm:ss');
                            
                    $.ajax({
                    	   url: site_url+'/pos/C_eventCalendar/updateEventCalendar',
                    	   data: 'title=' + event.title + '&start=' + start1 + '&end=' + end1 + '&id='+ event.id ,
                    	   type: "POST",
                    	   success: function(json) {
                    	    alert("Updated Successfully");
                    	   }
                       });  
                },
                /*DELETE EVENT */
                eventClick: function(event) {
                	var decision = confirm("Do you really want to delete?"); 
                	if (decision) {
                        	$.ajax({
                        		type: "POST",
                        		url: site_url+'/pos/C_eventCalendar/deleteEventCalendar',
                        		data: "&id=" + event.id,
                        		success: function(json) {
                        			 $('#calendar').fullCalendar('removeEvents', event.id);
                                     //console.log(event);
                        			 alert("Deleted Successfully");}
                        	});
                	}
               	},
                
              /*  events: [{
                        "title": 'All Day Event',                        
                        "start": new Date(y, m, 1),
                        backgroundColor: App.getLayoutColorCode('yellow')
                    }, {
                        "title": 'Long Event',
                        "start": new Date(y, m, d - 5),
                        "end": new Date(y, m, d - 2),
                        backgroundColor: App.getLayoutColorCode('green')
                    }, {
                        title: 'Repeating Event',
                        start: new Date(y, m, d - 3, 16, 0),
                        allDay: false,
                        backgroundColor: App.getLayoutColorCode('red')
                    }, {
                        title: 'Repeating Event',
                        start: new Date(y, m, d + 4, 16, 0),
                        allDay: false,
                        backgroundColor: App.getLayoutColorCode('green')
                    }, {
                        title: 'Meeting',
                        start: new Date(y, m, d, 10, 30),
                        allDay: false,
                    }, {
                        title: 'Lunch',
                        start: new Date(y, m, d, 12, 0),
                        end: new Date(y, m, d, 14, 0),
                        backgroundColor: App.getLayoutColorCode('grey'),
                        allDay: false,
                    }, {
                        title: 'Birthday Party',
                        start: new Date(y, m, d + 1, 19, 0),
                        end: new Date(y, m, d + 1, 22, 30),
                        backgroundColor: App.getLayoutColorCode('purple'),
                        allDay: false,
                    }, {
                        title: 'Click for Google',
                        start: new Date(y, m, 28),
                        end: new Date(y, m, 29),
                        backgroundColor: App.getLayoutColorCode('yellow'),
                        url: 'http://google.com/',
                    }
                ]*/
            });

        }

    };

}();
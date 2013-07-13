jQuery.fn.myne_api = function(options) {	
	options["jsonrpc"] = "2.0";
	options["id"] = "1";
	
	var response = $.ajax({
		url: "/api/request",
		type: "POST",
		data: JSON.stringify(options),
		contentType: 'application/json',
		dataType: "json",
		async: false,
		success: function(data) {
			return data;
		},
		fail: function(data) { 
			alert(data); 
		} 
	});
	
	return response;
	
};
jQuery.fn.myne_notify = function(options) {
	$('#myne_notify').removeClass('notify-info').addClass('notify-'+options.class).clearQueue().stop(true,false).text(options.text).fadeIn('fast', 'linear', function() {
		$(this).delay(2500).fadeOut('400');
	});
};
jQuery.fn.simpleClock = function () {

  // Define weekdays and months
  var weekdays = ["Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag"]
  var months = ["Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"];

  // getTime - Where the magic happens ...
  function getTime() {
    var date = new Date(),
    hour = date.getHours();
    return {
      day: weekdays[date.getDay()],
      date: date.getDate(),
      month: months[date.getMonth()],
      hour: appendZero(hour),
      minute: appendZero(date.getMinutes()),
      second: appendZero(date.getSeconds())
    };
  }

  // appendZero - If the number is less than 10, add a leading zero. 
  function appendZero(num) {
    if (num < 10) {
      return "0" + num;
    }
    return num;
  }

  // refreshTime - Build the clock.
  function refreshTime() {
    var now = getTime();
    $('#date').html(now.day + ', ' + now.date + '. ' + now.month);
    $('#time').html("<i class='icon-time icon-white'></i> <span class='hour'>" + now.hour + "</span>" + ":" + "<span class='minute'>" + now.minute + "</span>" + ":" + "<span class='second'>" + now.second + "</span>");
  }

  // Tick tock - Run the clock.
  refreshTime();
  setInterval(refreshTime, 1000);

};

// @author Rich Adams <rich@richadams.me>
// https://github.com/richadams/jquery-taphold

// Implements a tap and hold functionality. If you click/tap and release, it will trigger a normal
// click event. But if you click/tap and hold for 1s (default), it will trigger a taphold event instead.

;(function($){
  // Default options
  var defaults = {
      duration: 1000, // ms
      clickHandler: null
  }

  // When start of a taphold event is triggered.
  function startHandler(event)
  {
      var $elem = jQuery(this);

      // Merge the defaults and any user defined settings.
      settings = jQuery.extend({}, defaults, event.data);

      // If object also has click handler, store it and unbind. Taphold will trigger the
      // click itself, rather than normal propagation.
      if (typeof $elem.data("events") != "undefined"
          && typeof $elem.data("events").click != "undefined")
      {
          // Find the one without a namespace defined.
          for (var c in $elem.data("events").click)
          {
              if ($elem.data("events").click[c].namespace == "")
              {
                  var handler = $elem.data("events").click[c].handler
                  $elem.data("taphold_click_handler", handler);
                  $elem.unbind("click", handler);
                  break;
              }
          }
      }
      // Otherwise, if a custom click handler was explicitly defined, then store it instead.
      else if (typeof settings.clickHandler == "function")
      {
          $elem.data("taphold_click_handler", settings.clickHandler);
      }

      // Reset the flags
      $elem.data("taphold_triggered", false); // If a hold was triggered
      $elem.data("taphold_clicked",   false); // If a click was triggered
      $elem.data("taphold_cancelled", false); // If event has been cancelled.

      // Set the timer for the hold event.
      $elem.data("taphold_timer",
          setTimeout(function()
          {
              // If event hasn't been cancelled/clicked already, then go ahead and trigger the hold.
              if (!$elem.data("taphold_cancelled")
                  && !$elem.data("taphold_clicked"))
              {
                  // Trigger the hold event, and set the flag to say it's been triggered.
                  $elem.trigger(jQuery.extend(event, jQuery.Event("taphold")));
                  $elem.data("taphold_triggered", true);
              }
          }, settings.duration));
  }

  // When user ends a tap or click, decide what we should do.
  function stopHandler(event)
  {
      var $elem = jQuery(this);

      // If taphold has been cancelled, then we're done.
      if ($elem.data("taphold_cancelled")) { return; }

      // Clear the hold timer. If it hasn't already triggered, then it's too late anyway.
      clearTimeout($elem.data("taphold_timer"));

      // If hold wasn't triggered and not already clicked, then was a click event.
      if (!$elem.data("taphold_triggered")
          && !$elem.data("taphold_clicked"))
      {
          // If click handler, trigger it.
          if (typeof $elem.data("taphold_click_handler") == "function")
          {
              
              $elem.data("taphold_click_handler")(jQuery.extend(event, $elem, jQuery.Event("click")));
          }

          // Set flag to say we've triggered the click event.
          $elem.data("taphold_clicked", true);
      }
  }

  // If a user prematurely leaves the boundary of the object we're working on.
  function leaveHandler(event)
  {
      // Cancel the event.
      $(this).data("taphold_cancelled", true);
  }

  // Determine if touch events are supported.
  var touchSupported = ("ontouchstart" in window) // Most browsers
                       || ("onmsgesturechange" in window); // Mircosoft

  var taphold = $.event.special.taphold =
  {
      setup: function(data)
      {
          $(this).bind((touchSupported ? "touchstart" : "mousedown"),  data, startHandler)
                 .bind((touchSupported ? "touchend"   : "mouseup"),    stopHandler)
                 .bind((touchSupported ? "touchmove"  : "mouseleave"), leaveHandler);
      },
      teardown: function(namespaces)
      {
          $(this).unbind((touchSupported ? "touchstart" : "mousedown"),  startHandler)
                 .unbind((touchSupported ? "touchend"   : "mouseup"),    stopHandler)
                 .unbind((touchSupported ? "touchmove"  : "mouseleave"), leaveHandler);
      }
  };
})(jQuery);


$(document).ready(function (){
	$("#task-list tr").mouseenter(function() {
    	$(this).find('.control_wrapper').show();
  	}).mouseleave(function() {
  		$(this).find('.control_wrapper').hide();
  });

  // Edti task overlay
  $('.edit_task').on('click', function() {
  	var id = $(this).data('id');

  	$('#edit_task').load("/tasks/edit/"+id).modal('show');
  	$('#edit_task').modal('show');
  });
});

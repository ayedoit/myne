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
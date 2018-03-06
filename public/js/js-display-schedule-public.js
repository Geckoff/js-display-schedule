'use strict';
(function( $ ) {
	$(document).ready(function(){
		var jsdBlocks = document.getElementsByClassName('jsd'),
			jsdSchedulesIds = false;

		
		if (jsdSchedules !== 'undefined' ) {
			jsdSchedulesIds = Object.keys(jsdSchedules);
			if (jsdSchedulesIds.length === 0) 
				jsdSchedulesIds = false;				
		}
		
		if (jsdBlocks.length > 0 && jsdSchedulesIds) {
			for (var i = 0; i < jsdBlocks.length; i++) {
				var jsdBlockClasses = jsdBlocks[i].getAttribute('class').split(' ');
				jsdBlockClasses.forEach(function(elem){
					if (jsdSchedulesIds.includes(elem)) {
						var show = false;
						var intervals = jsdSchedules[elem]["uneve_intervals"];
						intervals.forEach(function(interval){
							//var timestamp = Math.floor(Date.now() / 1000);
							var timestamp = 1536530640;
							if (timestamp > interval["us_time_start"] && timestamp < interval["us_time_end"]) {
								show = true;	
							}
						})
						if (show) {
							$(jsdBlocks[i]).css("display", jsdSchedules[elem]["css_display"]);
						}
					}
				});				
			}
		}
	});
	
})( jQuery );


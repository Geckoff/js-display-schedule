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
						console.log(jsdSchedules[elem]);
					}
				});
			}
		}
	});

	/**
	 * Schedule functionality class
	 *
	 * @param      object    scheduleConfig       schedule configuration for current id
	 */	
	function Schedule(scheduleConfig, elem) {
		this.id = scheduleConfig.id;
		this.css_display = scheduleConfig.css_display;
		this.sched_type = scheduleConfig.sched_type;
		this.uneve_intervals = scheduleConfig.uneve_intervals;
		this.recurring_schedule_day = scheduleConfig.recurring_schedule_day;
		this.recurring_time_interval_type = scheduleConfig.recurring_time_interval_type;
		this.recurring_schedule_start_date = scheduleConfig.recurring_schedule_start_date + " 00:00:00";
		if (scheduleConfig.recurring_schedule_end_date) {
			this.recurring_schedule_end_date = scheduleConfig.recurring_schedule_end_date  + " 23:59:59";
		} else {
			this.recurring_schedule_end_date = false;	
		}
		this.recurring_time_interval_start = scheduleConfig.recurring_time_interval_start;
		this.recurring_time_interval_end = scheduleConfig.recurring_time_interval_end;
		this.elem = elem;
		this.currentTimeStamp = getSecondsTimestamp(Date.now());
		this.init();

		this.init = function(){
			var show = false;
			if (this.sched_type === 'jsd_rs_sched') {
				if (recurring_time_interval_type === 'whole_day') {

				} else if (recurring_time_interval_type === 'custom_hours') {

				}

			} else if (this.sched_type === 'jsd_us_sched') {

			}
			return show;
		}

		this.reccuringSchedule = function(startTime, endTime, frequency) {
			var show = false;
		}

		/**
		 * determine if current time matches "every other day" condition
		 *
		 * @param    string    startDate      date when showing starts - yyyy-mm-ddd hh:mm:ss format
		 */
		this.isDayToShowEODay = function(startDate) {
			return this.isDayToShowEOInterval(startDate, 86400);
		}

		/**
		 * determine if current time matches "every other week" condition
		 *
		 * @param    string    startDate      date when showing starts - yyyy-mm-ddd hh:mm:ss format
		 */
		this.isDayToShowEOWeek = function(startDate) {
			return this.isDayToShowEOInterval(startDate, 604800);
		}

		/**
		 * determine if current time matches "every other *period of time*" condition
		 *
		 * @param    string    startDate      date when showing starts - yyyy-mm-ddd hh:mm:ss format
		 * @param    int    periodOfTime      number of seconds in the calculating interval 
		 */
		this.isDayToShowEOInterval = function(startDate, periodOfTime) {
			var show = false,
				startDateTimestamp = this.getTimeStampFromDateTime(startDate),
				timeDiff = currentTimeStamp - startDateTimestamp;
				
			if (timeDiff > 0) {
				show = isEven(timeDiff, periodOfTime);
			}	
			return show;
		}	

		/**
		 * determine if current time is whithin specified time interval of date and time
		 *
		 * @param    string    startDateTime    interval start time - yyyy-mm-ddd hh:mm:ss format
		 * @param    string    endDateTime      interval end time - yyyy-mm-ddd hh:mm:ss format
		 */
		this.isYMDHMStoShow = function(startDateTime, endDateTime) {
			var show = false,
				startDateTimestamp = this.getTimeStampFromDateTime(startDateTime);
			if (endDateTime) {
				var endDateTimestamp = this.getTimeStampFromDateTime(endDateTime);
			} else {
				var endDateTimestamp = false;	
			}
			if (endDateTimestamp) {
				if (this.currentTimeStamp >= startDateTimestamp && this.currentTimeStamp <= endDateTimestamp) {
					show = true	
				}
			} else {
				if (this.currentTimeStamp >= startDateTimestamp) {
					show = true		
				}
			}
			
			return show;
		}

		/**
		 * determine if current time is whithin specified time interval in the current day
		 *
		 * @param    int    startTime    interval start time - quantity of seconds from the beggining of the day
		 * @param    int    endTime      interval end time - quantity of seconds from the beggining of the day
		 */
		this.isHMSToShow = function(startTime, endTime) {
			var dayStart = this.getDayStartTimestamp(),
				startShowTimestamp = dayStart + startTime,
				endShowTimestamp = dayStart + endTime + 60;
			if (this.currentTimeStamp >= startShowTimestamp && this.currentTimeStamp <= endShowTimestamp)
				return true;
			return false;
		}

		/**
		 * get timestamp of the beggining of the current day
		 *
		 */
		this.getCurrentDayStartTimestamp = function() {
			var now = new Date(),
				startOfDay = new Date(now.getFullYear(), now.getMonth(), now.getDate());
			return this.getSecondsTimestamp(startOfDay.getTime());
		}

		/**
		 * get timestamp from date and time
		 *
		 * @param    string    dateTime    date and time in format yyyy-mm-dd hh-mm-ss
		 */
		this.getTimeStampFromDateTime = function(dateTime) {
			var dateString = dateTime,
				dateTimeParts = dateString.split(' '),
				timeParts = dateTimeParts[1].split(':'),
				dateParts = dateTimeParts[0].split('-'),
				date;
			
			date = new Date(dateParts[0], parseInt(dateParts[1], 10) - 1, dateParts[2], timeParts[0], timeParts[1], timeParts[2]);
			return this.getSecondsTimestamp(date.getTime());			 
		}

		/**
		 * Convert ms timestamp to second timestamp
		 *
		 * @param    int    msTimestamp    miliseconds timestamp
		 */	
		this.getSecondsTimestamp = function(msTimestamp) {
			return Math.floor(msTimestamp / 1000);
		}	

		/**
		 * Determin if current timestamp is whithin even or odd specified interval
		 *
		 * @param    int    timeDiff    entire period of time
		 * @param    int    seconds     length of the interval which even or odd calculated for
		 */	
		this.isEven = function(timeDiff, seconds) {
			var divInt = Math.floor(timeDiff / seconds)
			return divInt % 2;
		}
	}
})( jQuery );


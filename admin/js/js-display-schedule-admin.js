'use strict';

(function( $ ) {	
	var ElementFunctions = function() {
		this.toggleBlocksDisplay = function(elemToTrackOne, elemToTrackTwo, toggleElemOne, toggleElemTwo) {
			if (elemToTrackOne.prop('checked')) {
				toggleElemOne.show();
				if (toggleElemTwo) 
					toggleElemTwo.hide();
			}
			else if (elemToTrackTwo.prop('checked')) {
				toggleElemOne.hide();
				if (toggleElemTwo) {
					toggleElemTwo.show();
				}
			}
		}

		this.populateEmptyField = function(field, populateWith) {
			if (!field.val()) {
				field.val(populateWith);	
				field.attr('value', populateWith);
			}
		}
	}

	var JsDisplay = function() {	
		
		this.elementFunctions = new ElementFunctions();

		this.init = function() {
			this.toggleScheduleTypes();
			this.populateReccuringSchedHours();
			this.toggleReccuringScheduleHours();
			this.saveReccuringScheduleTime();
			this.populateReccuringSchedStartDate();
			this.eventHandlers();	
		}

		// toggle display for Display Schedule types
		this.toggleScheduleTypes = function() {
			this.elementFunctions.toggleBlocksDisplay(
				$('#carbon_fields_container_display_schedule_type input[value=jsd_rs_sched]'),
				$('#carbon_fields_container_display_schedule_type input[value=jsd_us_sched]'),
				$('#carbon_fields_container_recurring_display_schedule'),
				$('#carbon_fields_container_uneven_display_schedule')	
			)	
		}

		// remove uneven interval if at least one of the fields is empty
		this.removeUnevenDisplayIntervals = function() {
			if ($('#carbon_fields_container_uneven_display_schedule div').is('.carbon-group-row')) {
				$('#carbon_fields_container_uneven_display_schedule .carbon-group-row').each(function(i, elem){
					$(elem).find('input[type=text]').each(function(index, input){
						if (!$(input).val()) {
							elem.querySelector('.carbon-btn-remove').click();	
						}
					});	
				});	
			}
		} 

		// populate Reccuring Schedule type Start and End Time fields	
		this.populateReccuringSchedHours = function(){
			this.elementFunctions.populateEmptyField($('input[name=_jsd_rs_hours_start]'), '12:00 AM');	
			this.elementFunctions.populateEmptyField($('input[name=_jsd_rs_hours_finish]'), '11:59 PM')	
		}

		this.populateReccuringSchedStartDate = function(){
			var date = this.getCurrentDate();
			this.elementFunctions.populateEmptyField($('input[name=_jsd_reccuring_start_date]'), date);
		}

		// toggle display for Reccuring Schedule type time intervals
		this.toggleReccuringScheduleHours = function(){
			this.elementFunctions.toggleBlocksDisplay(
				$('#carbon_fields_container_recurring_display_schedule input[value=custom_hours]'),
				$('#carbon_fields_container_recurring_display_schedule input[value=whole_day]'),				
				$('#carbon_fields_container_recurring_display_schedule .carbon-time'),
				false	
			)	
		}

		this.saveReccuringScheduleTime = function() {
			$('#carbon_fields_container_recurring_display_schedule .carbon-time button').click();	
			$('#carbon_fields_container_recurring_display_schedule .carbon-time button').click();	
			$('#carbon_fields_container_recurring_display_schedule .carbon-date button').click();
			$('#carbon_fields_container_recurring_display_schedule .carbon-date button').click();
			//$('#carbon_fields_container_recurring_display_schedule .carbon-date button').click();
			//$('#carbon_fields_container_recurring_display_schedule .carbon-date').click();
		}

		this.eventHandlers = function(){
			// events when switching between Display Schedule types
			var that = this;
			$('input[name=_jsd_type').on('change', function(){
				that.toggleScheduleTypes();
				that.removeUnevenDisplayIntervals();
				that.populateReccuringSchedHours();
			});	

			// events when switching between Start and End hour fir Reccurring Schedule type
			$('input[name=_jsd_rs_type').on('change', function(){
				that.toggleReccuringScheduleHours();
				that.populateReccuringSchedHours();
			});	
		}

		this.getCurrentDate = function() {
			var today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth()+1; //January is 0!
			var yyyy = today.getFullYear();
			if (dd < 10) {
				dd = '0'+dd
			} 
			if ( mm < 10) {
				mm = '0'+mm
			} 

			return yyyy + '-' + mm + '-' + dd;
		}
	}

	$(document).ready(function(){
		if ($('div').is("#carbon_fields_container_display_schedule_type")) {
			new JsDisplay().init();		
		}
	});

})( jQuery );

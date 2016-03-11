
/**
 * @desc : initialized components
 */
  $(document).ready(function() {
      
	  $('#date').change(function(){
    	  
    	  var date = $(this).get(0);
    	  var time = $('#time').get(0);
    	  var service = $('#service').get(0);
    	  updateEmployee(date, time, service);
      });
      
      $('#time').change(function(){
    	  
    	  var time = $(this).get(0);
    	  var date = $('#date').get(0);
    	  var service = $('#service').get(0);
    	  updateEmployee(date, time, service);
      });
      
      $('#service').change(function(){
    	  
    	  var service = $(this).get(0);
    	  var date = $('#date').get(0);
    	  var time = $('#time').get(0);
    	  updateEmployee(date, time, service);
      });
  });

/**
 * @desc : updates the employees based on the times and dates.
 */
function updateEmployee(date, time, service){
	
	var selectedDate = date.options[date.selectedIndex].value;
	var selectedTime = time.options[time.selectedIndex].value;
	var selectedService = service.options[service.selectedIndex].value;
	
	// makes an ajax call to the employees method to get the employees and the filters to filter them
	$.post(getLocation('Account/employees'),{'date':selectedDate, 'time':selectedTime, 'service':selectedService}, function (data){
		
		var employees = data['employees'];
		var serviceFilters = data['serviceFilters'];
		var scheduleFilters = data['scheduleFilters'];
		var time = data['time'];
		
		var html = '<option value="-1" >--select staff--</option>';

		serviceFilters.forEach(function(serviceFilter){
			scheduleFilters.forEach(function(scheduleFilter){
				employees.forEach(function(employee){
					// checks if the employee does the service
					if(selectedService === serviceFilter.serviceid &&
						employee.id === serviceFilter.employeeid && 
						// checks if the employee starts working at the especified time
						scheduleFilter.employeeid === employee.id && 
						time >= scheduleFilter.starttime &&
						time <= scheduleFilter.endtime){
							
						html += '<option value="'+employee.id +'">' +
									employee.firstname+' '+employee.lastname +
								'</option><br />';
					}
				});// end foreach employee
			});// end foreach schedule filter
		});// end foreach service filter
			
		$('.employee').html(html);
		
		
	},"json");
}


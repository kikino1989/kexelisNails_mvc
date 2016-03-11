<?php
class AdminAccount extends EmployeeAccount {
	
	function __construct() {
		parent::__construct();
	}
	
	/**
	 * |----------------------|
	 * |      Controllers     |
	 * |----------------------|
	 */
	/*--------------------employees---------------------------*/
	/**
	 * @desc : redirect user if not user exist
	 * @return multitype:unknown
	 */
	public function index(){
		
		$user = (isset($_SESSION['user']))?$_SESSION['user']:null;
		if($user === null){
			
			$this->redirect('AdminAccount/login');
		}
		return array('user' => $user);
	}
	
	/**
	 * @desc : register new employeesif post request
	 * @throws Exception
	 */
	public function employees($args){
		
		$page_number = $args[0]; // the page number for pagination
		$items_per_page = $args[1];// how many entries for page
		$start = $items_per_page * ($page_number - 1);// the start for the limit
		
		// register employees
		if (isset ( $_POST ['firstname'] )) {
			if ($_POST ['password'] === $_POST ['password2']) {
				
				$user = $this->createUser();
				$userDBContext = new DBContext($this->dataBase, $user);
				try {
					if(!$userDBContext->exist("WHERE email = '$user->email'")){
						$userDBContext->create();
					} else{
						throw new Exception("User already exist");
					}
				} catch( Exception $err ) {
					$this->redirect ('Error/index/' . urlencode($err->getMessage ()));
				}
			} else
				$this->redirect ( 'Error/index/'.urlencode('password does not match'));
		}
		
		$employeesManagerDBContext = new DBContext($this->dataBase, 'User');
		return array(
				'employees' => $employeesManagerDBContext->readMany("WHERE role = 'employee' OR role = 'admin' ORDER BY firstname ASC LIMIT $start, $items_per_page"),
				// parameters for paginations
				'number_of_pages' => $this->get_number_of_pages($items_per_page, $this->getEntriesNumber('user', "role = 'employee' OR role = 'admin'")),
				'page_number' => $page_number,
				'items_per_page' => $items_per_page
		);
	}
	
	/**
	 * @desc : updates the services for the especified employee
	 * @param array $args
	 * @return multitype:object Ambigous <array(object, multitype:>
	 */
	public function employeeServices($args){
		$employee_id  = $args[0];
		
		// get all services
		$servicesManagerDBContext = new DBContext($this->dataBase, 'Service');
		$services = $servicesManagerDBContext->readMany();
		
		// deletes all services for the employee
		$emploeeServicesManagerDBContext = new DBContext($this->dataBase);
		// checks if there is a post
		if(isset($_POST['post'])){
		 
			$emploeeServicesManagerDBContext->querybuilder
											->delete('employee_services')
											->where("employeeid = $employee_id")
											->options()
											->exe();
			
			// saves all the selected services
			foreach ($_POST as $service_id){
				if($service_id === "post") continue;
				else{
					$emploeeServicesManagerDBContext->querybuilder
													->insert('employee_services')
													->selectedFields('employeeid, serviceid')
													->vals("'$employee_id','$service_id'")
													->exe();
				}
			}
		}
		
		// get employee serivces
		$employee_services = $emploeeServicesManagerDBContext->querybuilder
															 ->select('*')
															 ->from('employee_services')
															 ->where("employeeid = $employee_id")
															 ->options()
															 ->execute(true, PDO::FETCH_OBJ);
		
		
		// get an array with the value for the checked property for every service
		$checked = array();
		foreach($services as $service){
			$checked[] = $this->isServiceChecked($service, $employee_services);
		}
		
		// get the employee
		$employeeManagerDBContext = new DBContext($this->dataBase, 'User');
		$employee = $employeeManagerDBContext->read("WHERE id = $employee_id");
		
		return array(
				'services' => $services,
				'checks' => $checked,
				'employee' => $employee
		);
	}
	/**
	 * @desc : deletes the selected employee base on the id passed
	 * @param unknown $args
	 */
	public function delete($args){
		$employee_id = $args[0];
		$employeesManagerDBContext = new DBContext($this->dataBase);
		$employeesManagerDBContext->querybuilder->delete('user')->where("id = $employee_id")->options()->exe();
		
		$this->redirect('AdminAccount/employees');
	}
	
	/**
	 * @desc : deletes the selected employees posted
	 */
	public function deleteMany(){
		
		$employeesManagerDBContext = new DBContext($this->dataBase, 'User');
		foreach ($employeesManagerDBContext->readMany("WHERE role = 'employee' OR role = 'admin'") as $employee) {
			if(isset($_POST["$employee->id"])){
				$employeesManagerDBContext->querybuilder->delete('user')->where('id = '.$_POST["$employee->id"])->options()->exe();
			}	
		}
		$this->redirect('AdminAccount/employees');
	}
	
	/*----------------------schedules---------------------------*/
	/**
	 * @desc : deletes the selected schedule base on the id passed
	 * @param unknown $args
	 */
	public function deleteSchedules($args){
		$employee_id = $args[0];
		$employeesManagerDBContext = new DBContext($this->dataBase);
		$employeesManagerDBContext->querybuilder->delete('employee_schedule')
												->where("employeeid = $employee_id")
												->options()
												->exe();
	
		$this->redirect('AdminAccount/schedules');
	}
	
	/**
	 * @desc : inserts the schedules entries into the data base 
	 * @throws Exception
	 * @return multitype:Ambigous <multitype:number, multitype:number > multitype:Ambigous <StdClass, NULL>  Ambigous <array(object, multitype:>
	 */
	public function schedules($args){
		
		$page_number = $args[0]; // the page number for pagination
		$items_per_page = $args[1];// how many entries for page
		$start = $items_per_page * ($page_number - 1);// the start for the limit
		
		// check if posted data
		if(isset($_POST['Sunday_start'])){
			$employee_id = $_POST['employee'];
			
			try{
				// days of the week
				$days = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
				for($i = 0; $i < count($days); $i++){
					
					// get the schedule object
					$schedule = $this->createScheduleFromDay($days[$i], $i + 1, $employee_id);
					
					// insert the schedule into data base
					$this->insertDailySchedule($schedule);
				}
			}catch (Exception $err){
				$this->redirect('Error/index/'. urlencode($err->getMessage()));
			}
		}
		
		// get all the employees
		$employeesManagerDBContext = new DBContext($this->dataBase, 'User');
		$employees = $employeesManagerDBContext->readMany("WHERE role = 'employee' OR role = 'admin' ORDER BY firstname LIMIT $start, $items_per_page");
		
		// gets the schedules for each employee
		$weeklySchedules = array();
		foreach ($employees as $employee){
			
			$schedule_object = $this->createWeekSchedule($employee);
			if($schedule_object !== null){ // check for empty schedule objects
				
				$weeklySchedules[] = $schedule_object;
				unset($schedule_object);
			}
		}
		return array(
				'schedules' => $weeklySchedules,
				'employees' => $employees,
				'times' => $this->getTimes(),
				// parameters for paginations
				'number_of_pages' => $this->get_number_of_pages($items_per_page, $this->getEntriesNumber('user', "role = 'employee' OR role = 'admin'")),
				'page_number' => $page_number,
				'items_per_page' => $items_per_page
		);
	}
	
	/**
	 * @desc : processes the employees schedules.
	 * @param array $args
	 * @return multitype:Ambigous <multitype:number, multitype:number > Ambigous <StdClass, NULL> Ambigous <object, mixed>
	 */
	public function editSchedule($args){
		
		$employee_id = $args[0];
		
		if(isset($_POST['Sunday_start'])){
			try{
				// days of the week
				$days = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
				for($i = 0; $i < count($days); $i++){
						
					// get the schedule object
					$schedule = $this->createScheduleFromDay($days[$i], $i + 1, $employee_id);
						
					// update the schedule for the employees
					$scheduleManangerDBContext = new DBContext($this->dataBase);
					$set = ($schedule->starttime === null || $schedule->endtime === null)?
								"starttime = null, endtime = null":
								"starttime = '$schedule->starttime', endtime = '$schedule->endtime'";
					
					$scheduleManangerDBContext->querybuilder->update('employee_schedule')->set($set)
																						 ->where("employeeid = $schedule->employeeid and day = '$schedule->day'")
																						 ->options()
																						 ->exe();
					// clean resources
					unset($schedule);
					unset($scheduleManangerDBContext);
				}
			}catch (Exception $err){
				$this->redirect('Error/index/'. urlencode($err->getMessage()));
			}
		}
		
		$employee_id = $args[0];
		$employeeDBContext = new DBContext($this->dataBase, 'User');
		$employee = $employeeDBContext->read("WHERE id = $employee_id");
		
		$scheduleManangerDBContext = new DBContext($this->dataBase, 'Employee_schedule');
		$dailySchedules = $scheduleManangerDBContext->readMany("WHERE employeeid = $employee_id");
		
		return array(
				'employee' => $employee, 
				'schedule' => $this->createWeekSchedule($employee),
				'dailySchedules' => $dailySchedules,
				'times' => $this->getTimes()
		);
	}
	
	/**
	 * @desc : gets all the clients
	 * @return multitype:Ambigous <array(object, multitype:>
	 */
	public function allClients($args){
		
		$page_number = $args[0]; // the page number for pagination
		$items_per_page = $args[1];// how many entries for page
		$start = $items_per_page * ($page_number - 1);// the start for the limit
		
		$clientsManagerDBContext = new DBContext($this->dataBase, 'User');
		$clients = $clientsManagerDBContext->readMany("WHERE role = 'user'");
		
		return array(
				'clients' => $clients,
				// parameters for paginations
				'number_of_pages' => $this->get_number_of_pages($items_per_page, $this->getEntriesNumber('user', "role = 'employee' OR role = 'admin' LIMIT $start, $items_per_page")),
				'page_number' => $page_number,
				'items_per_page' => $items_per_page
		);
	}
	
	/*-----------------------services------------------------*/
	/**
	 * @desc : adds services to the database
	 * @throws Exception
	 * @return multitype:Ambigous <array(object, multitype:>
	 */
	public function services(){
		
		if(isset($_POST['name'])){
			
			$service = new Service(
					$this->sanitize($_POST['name']),
					$this->sanitize($_POST['duration']),
					$this->sanitize($_POST['price']),
					$this->sanitize($_POST['description'])
			);
			
			$serviceDBContext = new DBContext($this->dataBase, $service);
			
			try{
				if(!$serviceDBContext->exist("WHERE name = '$service->name'")){
					$serviceDBContext->create();
				}else
					throw new Exception("Service already exists");
			}catch(Exception $err){
				$this->redirect("Error/index/".urlencode($err->getMessage()));
			}
			
		}
		
		$servicesManagerDBContext = new DBContext($this->dataBase, "Service");
		$services = $servicesManagerDBContext->readMany();
		
		return array('services' => $services);
	}
	
	/**
	 * @desc : deletes the especified service
	 * @param array $args
	 */
	public function deleteService($args){
		$service_id = $args[0];
		
		$serviceManagerDBContext = new DBContext($this->dataBase);
		$serviceManagerDBContext->querybuilder
								->delete("service")
								->where("id = $service_id")
								->options()
								->exe();
		
		$this->redirect("AdminAccount/Services");
	}
	
	/**
	 * @desc : edit the especified service
	 * @return multitype:unknown
	 */
	public function editService($args){
		$service_id = $args[0];
		
		if(isset($_POST['name'])){
	
			$service = new Service(
					$this->sanitize($_POST['name']),
					$this->sanitize($_POST['duration']),
					$this->sanitize($_POST['price']),
					$this->sanitize($_POST['description'])
			);
			
			$serviceDBContext = new DBContext($this->dataBase, $service);
			$serviceDBContext->update("WHERE id = $service_id");
	
			$this->redirect("AdminAccount/services");
		}
		
		$serviceManagerDBContext = new DBContext($this->dataBase, "Service");
		return array('service' => $serviceManagerDBContext->read("WHERE id = $service_id"));
	}
	/**
	 * |----------------------|
	 * |       Utilities      |
	 * |----------------------|
	 */
	
	/**
	 * @desc : returns a object with all the the days of the week and the employee id
	 * @param user $employee
	 * @return StdClass
	 */
	private function createWeekSchedule($employee){
		
		$schedulesManagerDBContext = new DBContext($this->dataBase, 'Employee_schedule');
		$schedules = $schedulesManagerDBContext->readMany("WHERE employeeid = $employee->id ORDER BY day_number ASC");
		
		if(count($schedules) === 0) // checks if the is a schedule for the employee id
			return null;
		else{
			// creates schedule object
			$object = array('employeeid' => $employee->id);
			foreach ($schedules as $schedule){
				$object[$schedule->day] = ($schedule->starttime === null)?
											  "OFF":'from '.date("h:i a",strtotime($schedule->starttime)).'<br />to '.date("h:i a",strtotime($schedule->endtime));
			}
			return (object)$object; // casting to object
		}
	}
	
	/**
	 * @desc : inserts the schedule into the data base
	 * @param Employee_schedule $schedule
	 * @throws Exception
	 */
	private function insertDailySchedule($schedule){
		try {
			// checks where the entry exists and insert it into the database if not
			$scheduleDBContext = new DBContext($this->dataBase, $schedule);
			if(!$scheduleDBContext->exist("WHERE employeeid = $schedule->employeeid AND day = '$schedule->day'")){
				
				$scheduleDBContext->create();// save to data base
			}else
				throw new Exception("employee already has a schedule");
		}catch (Exception $err){
			$this->redirect('Error/index/'. urlencode($err->getMessage()));
		}
		
		// clean resources
		unset($schedule);
		unset($scheduleDBContext);
	}
	
	/**
	 * @desc : creates objects of type employee_schedule 
	 * @param string $day
	 * @param int $day_number
	 * @throws Exception
	 * @return Employee_schedule
	 */
	private function createScheduleFromDay($day, $day_number, $employee_id){
					
		// checks if the employee is off for the day
		if($_POST[$day.'_start'] === "null" ||
			$_POST[$day.'_end'] === "null"){
						
			// create entry
			return new Employee_schedule($employee_id, null, null, $day, $day_number);
		}else{
			if($_POST[$day.'_start'] < $_POST[$day.'_end']){
							
				// create entry
				return new Employee_schedule($employee_id, date("H:i:s",$_POST[$day.'_start']),
											 date("H:i:s",$_POST[$day.'_end']), $day, $day_number);
			}else 
				throw new Exception("start time has to be greater than end time for ".$day );
		}
	}
	
	/**
	 * @desc : gets the checked property for each element in the services array
	 * @param Service $service
	 * @param array(Employee_service) $employee_services
	 * @return string
	 */
	private function isServiceChecked($service, $employee_services){
		
		$checked = "";
		foreach ($employee_services as $employee_service){
			$checked = "";
			if($employee_service->serviceid == $service->id){
				$checked = 'checked';
				break;
			}
		}
		return $checked;
	}
}
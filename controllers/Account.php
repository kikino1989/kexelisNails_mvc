<?php
class Account extends Controller {
	
	function __construct() {
		parent::__construct();
	}
	
	/**
	 * |----------------------|
	 * |      Controllers     |
	 * |----------------------|
	 */
	
	/*---------------------user controllers----------------------*/
	/**
	 * @desc : redirect user if not user exist
	 * @return multitype:unknown
	 */
	public function index(){
		
		$user = (isset($_SESSION['user']))?$_SESSION['user']:null;
		
		// checks if the user is logged in
		if(  $user === null){
			$this->redirect('Account/login');
			
		}else {	
			// checks what type of user is logged in
			if( $user !== null){
				if($user->role === 'employee'){// checks employee account
					$this->redirect('EmployeeAccount/index');
				}elseif($user->role === 'admin'){// checks for admin account
					$this->redirect('AdminAccount/index');
				}
			}
		}
		return array('user' => $user);
	}
	
	/**
	 * @desc : register User
	 * @throws Exception
	 */
	public function register() {
		if (isset ( $_POST ['firstname'] )) {
			if ($_POST ['password'] === $_POST ['password2']) {
	
				$user = $this->createUser();
				$userDBContext = new DBContext($this->dataBase, $user);
				try {
					if(!$userDBContext->exist("WHERE email = '$user->email'")) {
	
						$userDBContext->create();
						$_SESSION['user'] = $userDBContext->read("WHERE email = '$user->email'");
	
						$this->redirect ('Account/index');
					} else{
						throw new Exception("User already exist");
					}
				} catch( Exception $err ) {
					$this->redirect ('Error/index/' . urlencode($err->getMessage ()));
				}
			} else
				$this->redirect ( 'Error/index/'.urlencode('password does not match') );
		}
	}
	
	/**
	 * @desc : log user in if user exist
	 * @throws Exception
	 */
	public function login(){
		
		$email = (isset($_POST['email']))?$_POST['email']:null;
		if($email !== null){
			
			$user = new User();
			$userDBContext = new DBContext($this->dataBase, $user);
			try{
				if($userDBContext->exist("WHERE email = '$email'")){
					
					$user = $userDBContext->read("WHERE email = '$email'");
					if($user->password == $user->hashPassword($_POST['password'])){
						
						$_SESSION['user'] = $user;
						$this->redirect('Account/index');
					}else{
						throw new Exception('Password does not match our database');
					}
				}else 
					throw new Exception("User does not exist");
					
			}catch (PDOException $e){
				$this->redirect('Error/index/'.urlencode($e->getMessage()));
			}
			catch (Exception $e){
				$this->redirect('Error/index/'.urlencode($e->getMessage()));
			}
		}
	}
	
	/**
	 * : destroy all session variable
	 */
	public function logout() {
		session_destroy ();
		$this->redirect ( 'Account/index' );
	}
	
	/**
	 * @desc : edit user profile
	 * @return multitype:unknown
	 */
	public function editProfile(){
	
		$user = $_SESSION['user'];
		if(isset($_POST['firstname'])){
				
			$user->firstname = $this->sanitize($_POST['firstname']);
			$user->lastname = $this->sanitize($_POST['lastname']);
			$user->email = $this->sanitize($_POST['email']);
			$user->phone = $this->sanitize($_POST['phone']);
			$user->password = ($this->sanitize($_POST['password'] === 'your password'))?$user->password:$user->hashPassword($this->sanitize($_POST['password']));
			$user->img = ($this->upload() === 'upload/')?$user->img:$this->upload();
			$user->description = (isset($_POST['description']))?$_POST['description']:"";
			
			$userDBContext = new DBContext($this->dataBase, $user);
			$userDBContext->update();
	
			if($user->role === "employee")
				$this->redirect('EmployeeAccount/profile');
			elseif($user->role === "Admin")
				$this->redirect('AdminAccount/profile');
			else 
				$this->redirect('Account/profile');
		}
		return array('user' =>$user);
	}
	
	/**
	 * @desc : return user profile
	 * @return multitype:unknown
	 */
	public function profile(){
		return array('user' =>$_SESSION['user']);
	}
	
	/*-------------------appointments controllers----------------------------*/
	/**
	 * @desc : shedule appointments for users
	 * @return multitype:NULL multitype:
	 */
	public function schedule() {
		
		// get all the services
		$serviceManagerDBContext = new DBContext($this->dataBase, 'Service');
		$dbServices = $serviceManagerDBContext->readMany();
		
		// check if there are any services in the database.
		if(count($dbServices) == 0) 
			$this->redirect('Error/index/'.urlencode("Administrator has not posted any services yet"));

		// checkc if the user has posted data
		if (isset ( $_POST ['date'] )) {
			
			try{
				if($_POST['employee'] == -1){
					throw new Exception('Please select an employee');
				}
			}catch(Exception $err){
				$this->redirect('Error/index/'.urlencode($err->getMessage()));
			}
			// get user
			$user = $_SESSION ['user'];
			
			// get service
			$selectedService;
			foreach ($dbServices as $service){
				if($service->id === $_POST['service']){
					$selectedService = $service;
				}
			}
			
			$appointment = new Appointment(
							$user->id,
							$_POST ["employee"],
							date('H:i:s',$_POST ['time']),
							date('Y-m-d',$_POST ['date']),
							$selectedService->duration,
							$selectedService->name 
					) ;
					
			// save appointments to data base
			$appointmentDBContext = new DBContext($this->dataBase, $appointment);
			try{
				if(!$appointmentDBContext->exist("WHERE employeeid = $appointment->employeeid AND
					date = '$appointment->date' AND
					time = '$appointment->time' AND
					service = '$appointment->service' ")){
						
					$appointmentDBContext->create();
				}else 
					throw new Exception("Appointment is not avalible");
			}catch (Exception $err){
						$this->redirect("Error/index/".urlencode($err->getMessage()));
			}
		}
		
		$appointmentManagerDBContext = new DBContext($this->dataBase, 'Appointment');
		$dbAppointments = $appointmentManagerDBContext->readMany("ORDER BY date DESC, time DESC");
		
		// get the default time for the schedule filter to work propertly
		$defaultTime = $this->getTimes();
		$defaultTime = date("H:i:s",$defaultTime[0]);
		
		$firstService = $dbServices[0];
		
		return array (
				'services' => $dbServices,
				'employees' => $this->loadEmployees (),
				'appointments' => $dbAppointments,
				'dates' => $this->getDates(),
			    'times' => $this->getTimes(),
				'serviceFilters' => $this->serviceFilters(),
				'scheduleFilters' => $this->scheduleFilters(),
				'defaultTime' => $defaultTime,
				'firstService' => $firstService
		);
	}
	
	/**
	 * @desc : cancels the appointments
	 * @param unknown $args
	 */
	public function cancel($args){
		$appointment_id = $args[0];
	
		// get all the appointments
		$appointmentManagerDBContext = new DBContext($this->dataBase, 'Appointment');
		$appointments = $appointmentManagerDBContext->readMany("ORDER BY date DESC, time DESC");
		
		// deletes seleted appointment
		foreach ($appointments as $appointment){
			if($appointment->id === $appointment_id){
				$appointmentDBContext = new DBContext($this->dataBase, $appointment);
				$appointmentDBContext->delete();
			}
		}
		
		$this->redirect('Account/upcoming/1/5');
	}
	 
	/**
	 * @desc : shows upcoming appointments
	 * @return multitype:Ambigous <multitype:, multitype:>
	 */
	public function upcoming($args){
		
		$page_number = $args[0]; // the page number for pagination
		$items_per_page = $args[1];// how many entries for page
		$start = $items_per_page * ($page_number - 1);// the start for the limit
		
		$user_id = $_SESSION['user']->id;
		
		// get all the appointments
		$appointmentManagerDBContext = new DBContext($this->dataBase, 'Appointment');
		$appointments = $appointmentManagerDBContext->readMany("WHERE userid = $user_id AND date > NOW() ORDER BY date DESC, time DESC LIMIT $start, $items_per_page");
		
		// get all employees
		$employeesManagerDBContext = new DBContext($this->dataBase, 'User');
		$employees = $employeesManagerDBContext->readMany("WHERE role = 'employee' OR role = 'admin'");
		
		return array(
				'appointments' => $appointments,
				'employees' => $employees,
				// parameters for paginations
				'number_of_pages' => $this->get_number_of_pages($items_per_page, $this->getEntriesNumber('user', "role = 'employee' OR role = 'admin'")),
				'page_number' => $page_number,
				'items_per_page' => $items_per_page
		);
	}
	
	/**
	 * @desc : shows appointment history
	 * @return multitype:Ambigous <multitype:, multitype:>
	 */
	public function history(){
		$user_id = $_SESSION['user']->id;
		
		// get all the appointments
		$appointmentManagerDBContext = new DBContext($this->dataBase, 'Appointment');
		$appointments = $appointmentManagerDBContext->readMany("WHERE userid = $user_id AND date <= NOW() ORDER BY date DESC, time DESC");
		
		// get all employees
		$employeesManagerDBContext = new DBContext($this->dataBase, 'User');
		$employees = $employeesManagerDBContext->readMany("WHERE role = 'employee' OR role = 'admin'");
		
		return array('appointments' => $appointments,
				'employees' => $employees);
	}
	
	/*-----------------------staff controllers-------------------------*/
	/**
	 * @desc : returns the json representation of the array of employee objects
	 */
	public function employees(){
		echo json_encode(array('employees' => $this->loadEmployees(),
							   'serviceFilters' => $this->serviceFilters(),
							   'scheduleFilters' => $this->scheduleFilters(),
							   'time' => $this->getProperTime($_POST['time'])));
		exit;
	}
	
	
	/**
	 * |----------------------|
	 * |      Utilities       |
	 * |----------------------|
	 */
	
	
	/**
	 * @desc : return the proper format of a timestamp passed
	 * @param int $timeStamp
	 * @return string
	 */
	protected  function getProperTime($timeStamp){
		return date("H:i:s",$timeStamp);
	}
	
	/**
	 * @desc : load employees for services filtering out employees by date and time of appointments
	 * @return multitype:
	 */
	protected function loadEmployees(){
	
		// get all the appointments
		$appointmentManagerDBContext = new DBContext($this->dataBase, 'Appointment');
		$appointments = $appointmentManagerDBContext->readMany("ORDER BY date DESC, time DESC");
		
		// get the default date and time.
		$defaultDate = $this->getDates();
		$defaultTime = $this->getTimes();
		$defaultDate = $defaultDate[0];
		$defaultTime = $defaultTime[0];
		
		// filter dates
		$date = (isset($_POST['date']))?$_POST['date']:$defaultDate;
		$time = (isset($_POST['time']))?$_POST['time']:$defaultTime;
		$date = date('Y-m-d', $date);
		$time = date('H:i:s', $time);
	
		// get all the employees
		$employeesManagerDBContext = new DBContext($this->dataBase, 'User');
		$employees = $employeesManagerDBContext->readMany("WHERE role = 'employee' OR role = 'admin'");
		
		// deletes the employees if they have an apoointment at the selected times
		for($i = 0; $i < count($employees); $i++){
			
			$employee = $employees[$i];
			foreach ($appointments as $appointment){
				// still working on this bitch.
				if($employee->hasAppointment($appointment, $date, $time)){
					
						unset($employees[$i]);
						$employees = array_values($employees);
				}
			}
		}
		return $employees;
	}
	
	/**
	 * @desc : returns the schedules per employees.
	 * @return multitype:
	 */
	protected function scheduleFilters(){
		
		// check if the date is set, and if not, gets the default date and formats it porperly.
		$day = (isset($_POST['date']))?date("l",$_POST['date'] ):date("l", strtotime("+1 day", time()));
		
		$EmptyDBContext = new DBContext($this->dataBase);
		return $EmptyDBContext->querybuilder
							  ->select('*')
							  ->from('employee_schedule')
							  ->where("day = '$day'")->options()
							  ->execute(true);
	}
	
	/**
	 * @desc : returns the services per employees.
	 * @return multitype:
	 */
	protected function serviceFilters(){
		$EmptyDBContext = new DBContext($this->dataBase);
		return $EmptyDBContext->querybuilder
							  ->select('*')
							  ->from('employee_services')
							  ->where()->options()
							  ->execute(true); 
	}
	
	/**
	 * @desc : returns the times for the appointments
	 * @return multitype:number
	 */
	protected function getTimes(){
		$times = array();
		for($i = 9; $i <= 20; $i++){
			if($i > 12){
				$times[] = strtotime(($i - 12).':00pm');
			}elseif($i == 12){
				$times[] = strtotime(($i).':00pm');
			}else{
				$times[] = strtotime(($i).':00am');
			}
		}
		return $times;
	}
	
	/**
	 * @desc : returns the dates for appointments
	 * @return Ambigous <multitype:, string>
	 */
	protected function getDates(){
		$dates = array();
		for($i = 1; $i<= 31;$i++ ){
			$dates[] = strtotime("+$i day");
		}
		return $dates;
	}
	
	/**
	 * @desc : returns the user posted.
	 * @return User
	 */
	protected function createUser(){
		
		$role = (isset ( $_POST ['role'] ))? $_POST ['role']: 'user';
		$description = (isset ( $_POST ['description'] ))? $_POST ['description']: '';
		
		$img = $this->upload();
		$user = new User($this->sanitize ( $_POST ['firstname'] ), $this->sanitize ( $_POST ['lastname'] ),
				($img !== 'upload/')?$img:"avatar", $this->sanitize ( $_POST ['email'] ),
				$this->sanitize ( $_POST ['phone'] ), $this->sanitize ( $_POST ['password'] ),
				$role, $description);
		
		$user->password = $user->hashPassword($user->password);
		
		return $user;
	}
	
}
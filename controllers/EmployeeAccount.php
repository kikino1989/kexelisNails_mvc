<?php
class EmployeeAccount extends Account {
	
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
		if($user === null){
			
			$this->redirect('EmployeeAccount/login');
		}
		return array('user' => $user);
	}
	
	/**
	 * @desc : returns the schedule for the employee
	 * @return multitype:Ambigous <array(object, multitype:>
	 */
	public function viewSchedule(){
		
		$user = $_SESSION['user'];
		
		$scheduleManagerDBC = new DBContext($this->dataBase, 'employee_schedule');
		$schedules = $scheduleManagerDBC->readMany("WHERE employeeid = $user->id ORDER BY day_number");
		
		return array('schedules' => $schedules);
	}
	
	/**
	 * @desc : gets the clients for the employee
	 * @return multitype:multitype:Ambigous <object, mixed>
	 */
	public function clients($args){
		
		$page_number = $args[0]; // the page number for pagination
		$items_per_page = $args[1];// how many entries for page
		$start = $items_per_page * ($page_number - 1);// the start for the limit
		
		// get the use object
		$user = $_SESSION['user'];
		
		// get all the appointments for users filtering
		$appointmentsManangerDBContext = new DBContext($this->dataBase, 'Appointment');
		$appointments = $appointmentsManangerDBContext->readMany("WHERE employeeid = $user->id");
		
		
		$previous = -1; // previous id to avoid duplicated entries
		$clients = array();// array to store the clients 
		$clientsManagerDBContext = new DBContext($this->dataBase, 'user'); // DBContect object to the the clients
		foreach ($appointments as $appointment){

			// filters the users to avoid duplicated entries.
			if($previous !== $appointment->userid){
				$clients[] = $clientsManagerDBContext->read("WHERE id = $appointment->userid ORDER BY firstname DESC LIMIT $start, $items_per_page");
			}else
				$previous = $appointment->userid;
		}
		
		return array(
				'clients' => $clients,
				// parameters for paginations 
				'number_of_pages' => $this->get_number_of_pages($items_per_page, $this->getEntriesNumber('user', "role = 'employee' OR role = 'admin'")),
				'page_number' => $page_number,
				'items_per_page' => $items_per_page
		);
	}

	
	/**
	 * @desc : shows upcoming appointments only for this employee
	 * @return multitype:Ambigous <multitype:, multitype:>
	 */
	public function upcoming($args){
		
		$page_number = $args[0]; // the page number for pagination
		$items_per_page = $args[1];// how many entries for page
		$start = $items_per_page * ($page_number - 1);// the start for the limit
		
		$user_id = $_SESSION['user']->id;
		
		// get all the appointments
		$appointmentManagerDBContext = new DBContext($this->dataBase, 'Appointment');
		$appointments = $appointmentManagerDBContext->readMany("WHERE employeeid = $user_id AND date > NOW() ORDER BY date DESC, time DESC LIMIT $start, $items_per_page");
		
		// get all employees
		$employeesManagerDBContext = new DBContext($this->dataBase, 'User');
		$users = $employeesManagerDBContext->readMany("WHERE role = 'user'");
		
		return array(
				'appointments' => $appointments,
				'users' => $users,
				// parameters for paginations 
				'number_of_pages' => $this->get_number_of_pages($items_per_page, $this->getEntriesNumber('user', "role = 'employee' OR role = 'admin'")),
				'page_number' => $page_number,
				'items_per_page' => $items_per_page
		);
	}
	
	/**
	 * @desc : shows appointment history only for this employee
	 * @return multitype:Ambigous <multitype:, multitype:>
	 */
	public function history($args){
		
		$page_number = $args[0]; // the page number for pagination
		$items_per_page = $args[1];// how many entries for page
		$start = $items_per_page * ($page_number - 1);// the start for the limit
		
		$user_id = $_SESSION['user']->id;
		
		// get all the appointments
		$appointmentManagerDBContext = new DBContext($this->dataBase, 'Appointment');
		$appointments = $appointmentManagerDBContext->readMany("WHERE employeeid = $user_id AND date <= NOW() ORDER BY date DESC, time DESC LIMIT $start, $items_per_page");
		
		// get all employees
		$employeesManagerDBContext = new DBContext($this->dataBase, 'User');
		$users = $employeesManagerDBContext->readMany("WHERE role = 'user'");
		
		return array(
				'appointments' => $appointments,
				'users' => $users,
				// parameters for paginations
				'number_of_pages' => $this->get_number_of_pages($items_per_page, $this->getEntriesNumber('user', "role = 'employee' OR role = 'admin'")),
				'page_number' => $page_number,
				'items_per_page' => $items_per_page
		);
	}
	
	/**
	 * @desc : returns the comments
	 * @return multitype:Ambigous <rating, Rating_for_employee> array(object Ambigous <array(object, multitype:>
	 */
	public function comments($args){
		
		$page_number = $args[0]; // the page number for pagination
		$items_per_page = $args[1];// how many entries for page
		$start = $items_per_page * ($page_number - 1);// the start for the limit
		
		$user = $_SESSION['user'];
		
		$commentsManagerDBContext = new DBContext($this->dataBase, 'Comment_for_employee');
		$comments = $commentsManagerDBContext->readMany("WHERE employeeid = $user->id ORDER BY date LIMIT $start, $items_per_page");
		
		$clientsManagerDBContext = new DBContext($this->dataBase, 'User');
		$clients = $clientsManagerDBContext->readMany();
		
		return array(
				'clients' => $clients,
				'comments' => $comments,
				'rating' => $this->getRating($user->id),
				// parameters for paginations
				'number_of_pages' => $this->get_number_of_pages($items_per_page, $this->getEntriesNumber('user', "role = 'employee' OR role = 'admin'")),
				'page_number' => $page_number,
				'items_per_page' => $items_per_page
		);
	}
	
	/**
	 * |----------------------|
	 * |       Utilities      |
	 * |----------------------|
	 */

	/**
	 *
	 * @return rating for the especified employeeid
	 */
	protected function getRating($employee_id){
	
		$usersManagerDBContext = new DBContext($this->dataBase, 'Rating_for_employee');
		$rating_total = 0;
		$count = 0;
		foreach ($usersManagerDBContext->readMany("WHERE employeeid = $employee_id") as $rating){
			if($rating->employeeid === $employee_id){
				$count += 1;
				$rating_total += $rating->rate;
			}
		}
		if($count > 0)
			return new Rating_for_employee(-1, $employee_id, ceil($rating_total / $count));
		else
			return new Rating_for_employee(-1, $employee_id, 3);
	}
}
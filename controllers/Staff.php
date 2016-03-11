<?php
class Staff extends Controller {
	
	function __construct() {
		parent::__construct();
	}

	/**
	 * |----------------------|
	 * |      Controllers     |
	 * |----------------------|
	 */
	
	/**
	 * @desc : loads data to index view
	 * @return multitype:Ambigous <multitype:, multitype:>
	 */
	public function index($args){
		
		$page_number = $args[0]; // the page number for pagination
		$items_per_page = $args[1];// how many entries for page 
		$start = $items_per_page * ($page_number - 1);// the start for the limit  
		
		return array(
				'staff' => $this->loadStaff($start, $items_per_page),
				// parameters for paginations 
				'number_of_pages' => $this->get_number_of_pages($items_per_page, $this->getEntriesNumber('user', "role = 'employee' OR role = 'admin'")),
				'page_number' => $page_number,
				'items_per_page' => $items_per_page
		);
	}
	
	/**
	 * @desc : gets the details for the employee
	 * @param unknown $args
	 * @return multitype:mixed
	 */
	public function details($args){
		
		$page_number = $args[1]; // the page number for pagination
		$items_per_page = $args[2];// how many entries for page 
		$start = $items_per_page * ($page_number - 1);// the start for the limit 
		
		// get employees info
		$employee_id = $args[0];
		$employeeDBContext = new DBContext($this->dataBase, 'User');
		
		return array(
				'employee' => $employeeDBContext->read("WHERE role = 'employee' OR role = 'admin' AND id = $employee_id ORDER BY firstname LIMIT $start, $items_per_page"),
				'rating' => $this->getRating($employee_id),
				'comments' => $this->getComments($employee_id),
				'users' => $employeeDBContext->readMany(),
				// parameters for paginations
				'number_of_pages' => $this->get_number_of_pages($items_per_page, $this->getEntriesNumber('user', "role = 'employee' OR role = 'admin'")),
				'page_number' => $page_number,
				'items_per_page' => $items_per_page
		);
	}
	
	/**
	 * @desc : commmets on employees
	 */
	public function comment(){
		$owner = (isset($_SESSION['user']))?$_SESSION['user']:null;
		$owner = ($owner !== null)?$owner->id:-1;
		
		$comment = new Comment_for_employee($owner, $_POST['employeeid'], $this->sanitize($_POST['text']), date('Y-m-d',time()));
		$commentDBContext = new DBContext($this->dataBase, $comment);
		$commentDBContext->create();
		
		$this->redirect('Staff/index/1/5');
	}
	
	/**
	 * @desc : rate images thru ajax calls
	 */
	public function rate(){
		
		$owner = (isset($_SESSION['user']))?$_SESSION['user']:null;
		$owner = ($owner !== null)?$owner->id:-1;
	
		$rating = new Rating_for_employee($owner, $_POST['employeeid'], $this->sanitize($_POST['rate']));
		$ratingDBContext = new DBContext($this->dataBase, $rating);
		
		if($ratingDBContext->exist("WHERE ownerid = $rating->ownerid AND employeeid = $rating->employeeid")){
			$ratingDBContext->update("WHERE ownerid = $rating->ownerid AND employeeid = $rating->employeeid");
		}else{
			$ratingDBContext->create();
		}
		exit();
	}
	

	/**
	 * |----------------------|
	 * |      Utilities     |
	 * |----------------------|
	 */
	
	/**
	 * @desc : returns image comments
	 * @return multitype:
	 */
	private function getComments($employee_id){
		$commentManagerDBContext = new DBContext($this->dataBase, 'Comment_for_employee');
		return $commentManagerDBContext->readMany("WHERE employeeid = $employee_id");
	}
	
	/**
	 * @desc : load all the employees
	 * @return multitype:
	 */
	private function loadStaff($start, $amount){
		
		$employeesManagerDBContext = new DBContext($this->dataBase, 'User');
		return $employeesManagerDBContext->readMany("WHERE role = 'employee' OR role = 'admin' LIMIT $start, $amount");			 
	}
	
	/**
	 *
	 * @return rating for the especified employeeid
	 */
	private function getRating($employee_id){
		
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
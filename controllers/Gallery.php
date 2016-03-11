<?php
class Gallery extends Controller {
	
	function __construct() {
		parent::__construct();
	}
	

	/**
	 * |----------------------|
	 * |      Controllers     |
	 * |----------------------|
	 */
	
	/**
	 * @desc : returns the data to load to the gallery.
	 * @return multitype:multitype: Ambigous <unknown, multitype:>
	 */
	public function index($args){
		
		$page_number = $args[0]; // the page number for pagination
		$items_per_page = $args[1];// how many entries for page
		$start = $items_per_page * ($page_number - 1);// the start for the limit
		
		// load images and their ratings
		$images = $this->loadImages($start, $items_per_page);
		$ratings = array();// get images ratings
		foreach ($images as $image){
			$ratings[] = $this->getAverageRating($image->id);
		}
		
		return array('images' => $images,
				     'comments' => $this->getComments(),
				     'users' => $this->getUsers(),
					 'ratings' => $ratings,
					 // parameters for paginations 
					 'number_of_pages' => $this->get_number_of_pages($items_per_page, $this->getEntriesNumber('user', "role = 'employee' OR role = 'admin'")),
					 'page_number' => $page_number,
					 'items_per_page' => $items_per_page
		);
	}
	
	/**
	 * @desc : uploads images to the site and store dirs in database
	 */
	public function uploadImage(){
		
		$owner = (isset($_SESSION['user']))?$_SESSION['user']:null;
		$owner = ($owner !== null)?$owner->id:-1;
		
		$image = new Image($this->upload(), $this->sanitize($_POST['name']), $owner);
		$imageDBContext = new DBContext($this->dataBase, $image);
		$imageDBContext->create();
		
		$this->redirect('Gallery/index/1/5');
	}
	
	/**
	 * @desc : save commnets for the pictures
	 */
	public function comment(){
		
		$owner = (isset($_SESSION['user']))?$_SESSION['user']:null;
		$owner = ($owner !== null)?$owner->id:-1;
		
		$comment = new Comment($owner, $_POST['entityid'], $this->sanitize($_POST['text']), date('Y-m-d', time()));
		$commentDBContext = new DBContext($this->dataBase, $comment);
		$commentDBContext->create();
		
		$this->redirect('Gallery/index/1/5');
	}
	
	// get the details for an image
	public function details($args){
		
		$page_number = $args[1]; // the page number for pagination
		$items_per_page = $args[2];// how many entries for page
		$start = $items_per_page * ($page_number - 1);// the start for the limit
		
		// get image information
		$image_id = $args[0];
		$imagesManagerDBContext = new DBContext($this->dataBase, 'Image');
		$image = $imagesManagerDBContext->read("WHERE id = $image_id");
		
		$usersManagerDBContext = new DBContext($this->dataBase, 'User');
		$users = $usersManagerDBContext->readMany();
		
		return array(
				'image' => $image,
				'rating' => $this->getAverageRating($image_id), 
				'comments' => $this->getComments("WHERE entityid = $image_id ORDER BY date LIMIT $start, $items_per_page"),
				'users' => $users,
				// parameters for paginations
				'number_of_pages' => $this->get_number_of_pages($items_per_page, $this->getEntriesNumber('user', "role = 'employee' OR role = 'admin'")),
				'page_number' => $page_number,
				'items_per_page' => $items_per_page
		);
	}
	/**
	 * @desc : rate images thru ajax calls
	 */
	public function rate(){
		
		$owner = (isset($_SESSION['user']))?$_SESSION['user']:null;
		$owner = ($owner !== null)?$owner->id:-1;
	
		$rating = new Rating($owner, $_POST['entityid'], $this->sanitize($_POST['rate']));
		$ratingDBContext = new DBContext($this->dataBase, $rating);
		
		if($ratingDBContext->exist("WHERE ownerid = $rating->ownerid AND entityid = $rating->entityid")){
			$ratingDBContext->update("WHERE ownerid = $rating->ownerid AND entityid = $rating->entityid");
		}else{
			$ratingDBContext->create();
		}
		exit();
	}
	
	/**
	 * |----------------------|
	 * |      Utilities       |
	 * |----------------------|
	 */
	
	/**
	 * 
	 * @param image $image entity to get the comment
	 * @return Rating_for_employee
	 */
	private function getAverageRating($image_id){
		
		$rating_total = 0;
		$count = 0;
		$image_id;
		foreach ($this->getRatings() as $rating){
			if($rating->entityid === $image_id){
				$count += 1;
				$rating_total += $rating->rate;
			}
		}
		if($count > 0)
			return new Rating(-1, $image_id,ceil($rating_total / $count));
		else 
			return new Rating(-1, $image_id, 3);
	}
	
	/**
	 * @desc : returns image comments
	 * @return multitype:
	 */
	private function getComments($condition = ""){
		$commentManagerDBContext = new DBContext($this->dataBase, 'Comment');
		return $commentManagerDBContext->readMany($condition);
	}
	
	/**
	 * @desc : returns image array.
	 * @return unknown
	 */
	private function loadImages($start, $amount){
		$imagesManagerDBContext = new DBContext($this->dataBase, 'Image');
		return $imagesManagerDBContext->readMany("LIMIT $start, $amount");
	}
	
	/**
	 * 
	 * @return array of users
	 */
	private function getUsers(){
		$usersManagerDBContext = new DBContext($this->dataBase, 'User');
		return $usersManagerDBContext->readMany();
	}
	
	/**
	 * 
	 * @return array of ratings
	 */
	private function getRatings($condition = ""){
		$usersManagerDBContext = new DBContext($this->dataBase, 'Rating');
		return $usersManagerDBContext->readMany($condition);
	}
}
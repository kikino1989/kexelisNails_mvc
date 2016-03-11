<?php
class Controller extends Base{
	
	protected $dataBase;
	
	function __construct(){
		parent::__construct();
		
		$this->dataBase = new DataBase();
		session_start();
	}
	/**
	 * @desc : redirects the user to the specified url.
	 * @param unknown $_link
	 */
	protected function redirect($_link){
		header('location: '.$this->path($_link));
	}
	
	/**
	 * @desc : strips html tags and sql injections from input
	 * @param string $value
	 * @return string
	 */
	protected function sanitize($value){
	
		$value = strip_tags($value);// clean html tags
		$value = mysql_real_escape_string($value);//clean sql
		return $value;
	}
	
	/**
	 * @desc : returns the file directory to be stored
	 * @return string
	 */
	protected function upload(){
	
		if(isset($_FILES['img'])){
			
			$filename = $_FILES ['img'] ['name']; // the file name
			$filetmp = $_FILES ['img'] ['tmp_name']; // the php temporal folder
			$filetype = $_FILES ['img'] ['type']; // the file type
			$filesize = $_FILES ['img'] ['size']; // the file size
			$fileerror = $_FILES ['img'] ['error']; // the file error message
		
			if ($filesize < 4242880){
				move_uploaded_file($filetmp, "upload/$filename");
				
				if(file_exists($filetmp)){
					unlink($filetmp);
				}
				return "upload/$filename";
			}else
				$this->redirect ( 'Error/index/image is too big' );
		}else return null;
	}
	
	/**
	 * @desc : returns the number of pages to be rendered
	 * @param integer $entries
	 * @return number
	 */
	protected function get_number_of_pages($amount, $entries){
		return (($entries / $amount) < 1)?1:ceil($entries / $amount);
	}
	

	/**
	 * @desc : get the number of entries in the table
	 * @param string $table
	 * @param string $where
	 * @return integer
	 */
	public function getEntriesNumber($table, $where){
	
		// gets the number of entries
		$dbcontext = new DBContext($this->dataBase);
		$entries = $dbcontext->querybuilder
							 ->select("count(id)")
							 ->from($table)
							 ->where($where)
							 ->options()
							 ->execute(false, PDO::FETCH_ASSOC);
		
		return $entries['count(id)'];
	}
}
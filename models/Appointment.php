<?php
class Appointment extends Model{
	
	public $id;
	public $userid;
	public $employeeid;
	public $date;
	public $time;
	public $duration;
	public $service;
	
	
	function __construct($userid = null, $employeeid = null, $time = null, $date = null, $duration = null, $service = null) {
		parent::__construct();
		
		$this->userid = $userid;
		$this->employeeid = $employeeid; 
		$this->date = $date;
		$this->time = $time;
		$this->duration = $duration;
		$this->service = $service;
	}
	
	/**
	 * @desc : returns whether the appointment is finnished at the specified time.
	 * @param string $time
	 * @return boolean
	 */
	public function isNotFinnishedAt($time){
		// the time that will take for the appointment to end
		$ending_time = strtotime("$this->time. + ".ceil($this->duration / 60)." hours");
		
		return (strtotime($time) >= strtotime($this->time) && strtotime($time) < $ending_time);
	}
}
<?php
class User extends Model {
	
	public $id;
	public $firstname;
	public $lastname;
	public $img;
	public $email;
	public $phone;
	public $password;
	public $role;
	public $description;
	
	public function __construct($firstname = null, $lastname = null, $img = null, $email = null, $phone = null, $password = null, $role = null, $description = null){
		parent::__construct();
		
		$this->firstname = $firstname;
		$this->lastname = $lastname;
		$this->img = $img;
		$this->email = $email;
		$this->phone = $phone;
		$this->password = $password;
		$this->role = $role;
		$this->description = $description;
	}
	
	/**
	 * @desc : returns whether of not the employee has an appointment
	 * @param Appointment $Appointment
	 * @param string $date
	 * @param string $time
	 * @return boolean
	 */
	public function hasAppointment($appointment, $date, $time){
		return ($this->id === $appointment->employeeid &&
			   	$appointment->date === $date && 
				$appointment->isNotFinnishedAt($time));
	}
}
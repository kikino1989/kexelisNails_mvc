<?php
abstract class Model{
	
	function __construct(){
		
	}
	
	/**
	 * @desc : converts text password into hash password.
	 * @param string $data
	 * @return string
	 */
	public function hashPassword($data){
		$context = hash_init('md5', HASH_HMAC, SALT);
		hash_update($context, $data);
		return hash_final($context);	
	}
	
	/**
	 * @desc : encodes data.
	 * @param string $data
	 * @return string
	 */
	public function encodeData($data){
			
		$ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, KEY, $data, MCRYPT_MODE_ECB);
		return rtrim(base64_encode($ciphertext));
	}
	
	/**
	 * @desc : decodes data
	 * @param string $data
	 * @return string
	 */
	public function decodeData($encodedData){
		$ciphertext_dec = base64_decode($encodedData);
		return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, KEY, $ciphertext_dec, MCRYPT_MODE_ECB));
	}
	
	/**
	 * @desc : copy each field of one object to another.
	 * @param object $object
	 */
	public function copy($object){
		
		// get the reflection object for the class
		$reflectedClass = new ReflectionClass($this);
		
		// get the properties for the class
		$properties = $reflectedClass->getProperties();
		foreach ($properties as $property){// iterate thru the properties
			
			$name = $property->getName();
			$this->$name = $object->$name;
		}
	}
}
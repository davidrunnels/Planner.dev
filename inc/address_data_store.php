<?php

require_once("Filestore.php");

//create class to open & close csv file

class AddressDataStore extends Filestore {

	public function __construct($filename = '') {
		parent::__construct(strtolower($filename));
	}
	
}
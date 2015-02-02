<?php

class Model 
{
	protected $dbc;
	
	public $attributes = [];

	public function __construct($dbc)
	{
		$this->dbc = $dbc;
	}
	
	public function save()
	{
		if (isset($this->id)) {
			return $this->update();
		} else {
			return $this->insert();
		}

	}

	public function __set($property, $value) 
	{ 
	     $this->attributes[$property] = trim($value);
	}

}

	public function __get()($property, $value) 
	{ 
	     $this->attributes[$property] = strip_tags($value);
	}



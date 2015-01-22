<?php

class InvalidAddressbookInputException extends Exception {}

class InvalidTodoInputException extends Exception {}

class Filestore {
    
    public $filename = '';

    // filetype is NOT.csv
    private $isCSV = FALSE;

    // function to read filetype passed thru upload
    public function __construct($filename = '') 
    {
        $this->filename = $filename;
        if (substr($filename, -3) == 'csv') {
            $this->isCSV = TRUE;
        }
    }
    /**
     * Returns array of lines in $this->filename
     */
    private function readLines()
    {
        if (filesize($this->filename) == 0) {
            return [];
        } else {
            $handle = fopen($this->filename, "r");
            $contents = fread($handle, filesize($this->filename));
            $contentsarray = explode("\n", $contents);
            fclose($handle);
            return $contentsarray;
        }
    }
    /**
     * Writes each element in $array to a new line in $this->filename
     */
    private function writeLines($new_items)
    {
        $handle = fopen($this->filename, 'w');
        fwrite($handle, implode("\n", $new_items));
        fclose($handle);
    }
    /**
     * Reads contents of csv $this->filename, returns an array
     */
    private function readCSV()
    {
        $addressBook = [];
		if (($handle = fopen($this->filename, "r")) !== FALSE) {
			while (($fields = fgetcsv($handle)) !== FALSE) {
				array_push($addressBook, $fields);
			}
	    	fclose($handle);
		}
		return $addressBook;
    }
    /**
     * Writes contents of $array to csv $this->filename
     */
    private function writeCSV($array)
    {
		$handle = fopen($this->filename, 'w');
		foreach ($array as $fields) {
	    	fputcsv($handle, $fields);
			}
	    fclose($handle);
    }
    /**
    * Opens either csv or txt file
    */
    public function read() 
    {
        if ($this->isCSV == TRUE) {
            return $this->readCSV();
        } else {
            return $this->readLines();
        }
    }
    /**
    * Writes to either csv or txt file
    */
    public function write($array) 
    {
        if ($this->isCSV == TRUE) {
            return $this->writeCSV($array);
        }
        else {
            return $this->writeLines($array);
        }
    }


    public function validateInput($string) 
     {
        if (strlen($string) > 240) {
            throw new Exception("Input must be less than 240 characters. ");
        }

        if (strlen($string) == 0) {
            throw new Exception("Input can't be empty.");
        }

        return $string;
    }

    public function sanitize($array) {
        foreach ($array as $key => $value) {
                $array[$key] = htmlspecialchars(strip_tags($value));  // Overwrite each value.
            }
            return $array;
        }
}